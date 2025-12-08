<?php

namespace App\Services;

use App\Models\General\Setting;
use Illuminate\Support\Facades\App;
use App\Services\WebhookService;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Client;


class PaystackService
{
    /**
     * @var string
     */
    protected string $apiURL;
    private $client;

    const METHOD_POST = 'POST';

    const METHOD_GET = 'GET';

    const METHOD_PUT = 'PUT';

    public function __construct()
    {
        $this->apiURL = config('services.paystack.url');
        $this->client = new Client();
    }

    /**
     * @return array
     */
    public function getHeaderConfig(): array
    {
        $settings = (object)Setting::pluck('value', 'key')->toArray();

        $bearerToken = app()->environment('local') ? env('PAYSTACK_SK_KEY') : $settings->paystack_secret_key;

        return [
            'Accept' => 'application/json',  
            'content-type' => 'application/json', 
            "Authorization" => "Bearer {$bearerToken}"
        ];
    }

    public function refundCustomer(Model $model, string $reference, bool $refund = false): mixed
    {
        // TODO: Implement refundCustomer() method.
    }

    public function handleWebhookEvent(array $payload, WebhookService $webhookService): void
    {
        try {

            Log::alert("Paystack Webhook payment response.");
            $data           = $payload['data'];
            $status         = $data['status'];

            # handle the different implementation
            if ($payload['event'] === 'charge.success' && $status === 'success') {
                $reference  = $data['reference'];
                # PAYMENT_CONTRIBUTION_2afaf8d5-b6bb-404b-bd95-8a5b16afeef2,
                # PAYMENT_LOAN_2afaf8d5-b6bb-404b-bd95-8a5b16afeef2,
                # kindly note that there must be a prefix for a payment reference
                # If no prefix is added to a payment reference, It would fail at this point, because the system would not find the Class
                # A new Payment prefix must be defined as a Class in the directory PaymentReferences and must extend PaymentReferenceAbstract
                $event_type = explode('_', $reference)[0];
                # use the different PaymentReference Services to handle the Webhook
                $service    = $webhookService->proceedReferenceServiceHandler($event_type);
                Log::alert("Service", [$service]);
                $service?->handleReferenceImplementation($data);

                # send HTTP OK
                http_response_code(200);
            }

        } catch (\Exception $e) { Log::error($e); }

    }

    /** this gets all the available banks in a specified country from PayStack
     * @param string $account_number
     * @param string $bank_code
     * @return array
     */
    public function getVerifiedAccount(string $account_number, string $bank_code)
    {
        try {
            $api = $this->apiURL."bank/resolve?account_number={$account_number}&bank_code={$bank_code}";

            $response = ExternalAPIService::GetRequestService($api, $this->getHeaderConfig());

            Log::alert('verified', [$response]);

            if ($response->status) return $response->data;

        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }


    protected function send($endpoint, $method = 'POST', $data = [])
    {
        $errors = '';
        $response = '';
        $hasError = false;

        $options = [
            'headers' => $this->getHeaderConfig(),
            'body' => json_encode($data),
        ];

        try {
            $result = $this->client->request($method, $this->apiURL.$endpoint, $options);
            $response = json_decode($result->getBody());
            \Log::debug(json_encode(json_decode($result->getBody())));
        } catch (ClientException $e) {
            $hasError = true;
            if ($e->hasResponse()) {
                $err = json_decode($e->getResponse()->getBody());
                \Log::debug(Message::toString($e->getResponse()));
                $errors .= ($err->message ?? '').' ,';
            }
        }

        return [
            'response' => $response,
            'error' => $errors,
            'hasError' => $hasError,
        ];
    }

    public function initializeTransaction($email, $amount, $reference)
    {
        try {

            $data = [
                'reference' => $reference,
                'email' => $email,
                'amount' => $amount * 100,
                'callback_url' => url('/checkout/callback'),
                "metadata" => [
                    "env" => App::environment() == "production" ? "prod" : "dev"
                ]
            ];

            $transaction = $this->send('transaction/initialize', self::METHOD_POST, $data);

            if($transaction['response'] == ""){
                throw new \Exception($transaction['error']);
            }
    
            return $transaction;
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Fetch a transfer
     */
    public function verifyTransaction($reference, $table = null, $column = null)
    {
        if($table && DB::table($table)->where($column, $reference)->exists()){
            throw new \Exception("Transaction already processed");
        }

        $transaction = $this->send('transaction/verify/'.$reference, self::METHOD_GET);

        if($transaction['response'] == ""){
            throw new \Exception($transaction['error']);
        }

        return $transaction;
    }

    /**
     * Initialise a transaction
     *
     * @param  array  $params[email]
     * @param  array  $params[amount]
     * @param  array  $params[plan]
     * @return array
     */
    public function initialize_subscription(array $params)
    {
        return $this->send('transaction/initialize', self::METHOD_POST, $params);
    }

    /**
     * This is intended for funding of wallets alone
     */
    public function getPaymentLink($params)
    {
        $response = $this->client->request('POST', $this->apiURL.'transaction/initialize', [
            'headers' => $this->getHeaderConfig(),
            'body' => json_encode($params),
        ]);

        return json_decode($response->getBody()->getContents());
    }


    /**
     *  Data format
     *  "name": "Monthly Retainer",
     *  "interval": "monthly",
     *  "amount": 500000
     *
     **/
    public function createPlan(array $params)
    {
        return $this->send('plan', self::METHOD_POST, $params);
    }

    /**
     * Update a plan
     *
     * @return array
     */
    public function updatePlan($id, array $params)
    {
        return $this->send('plan/'.$id, self::METHOD_PUT, $params);
    }

    /**
     * "source": "balance", "reason": "Calm down",
     * " amount":3794800, "recipient": "RCP_gx2wn530m0i3w3m"
     *
     * @return array
     */
    public function transfer(array $params)
    {
        return $this->send('transfer', self::METHOD_POST, $params);
    }

    /**
     * Create a paystack customer
     *
     * @param array $params email
     * @return void
     * @throws GuzzleException
     */
    public function createCustomer(array $params)
    {
        $response = $this->client->request('POST', $this->apiURL.'customer', [
            'headers' => $this->getHeaderConfig(),
            'body' => json_encode($params),
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function fetchCustomer($email = 'nugaray@gmail.com')
    {
        try {
            $response = $this->client->request('GET', $this->apiURL.'customer/'.$email, [
                'headers' => $this->getHeaderConfig(),
            ]);

            return json_decode($response->getBody()->getContents());
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }

    /**
     * \App\Models\User\User $user
     */
    public function hasActiveSubscription($email): bool
    {
        $statuses = [];
        $customer = $this->fetchCustomer($email);

        if ($customer && count($customer->data->subscriptions)) {
            foreach ($customer->data->subscriptions as $subscription) {
                $statuses[] = $subscription->status;
            }
        }

        return in_array('active', $statuses);
    }

    /**
     * Charge a stored card
     *
     * @param array $params ['amount']
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function chargeAuthorization(array $params)
    {
        $response = $this->client->request('POST', $this->apiURL.'transaction/charge_authorization', [
            'headers' => $this->getHeaderConfig(),
            'body' => json_encode($params),
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Create a invoice for capturing consultation costs
     * endpoint: paymentrequest
     *
     * @return void
     */
    public function createInvoice(array $params)
    {
        return $this->send('paymentrequest', self::METHOD_POST, $params);
    }
}
