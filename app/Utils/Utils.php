<?php

namespace App\Utils;

use App\Exceptions\InvalidMSISDNFormatException;
use App\Exceptions\InvalidPinException;
use App\Enums\ImageType;
use App\Enums\Status;
use App\Models\General\State;
use App\Models\Ticket;
use App\Models\UserCoupon;
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\PhoneNumber\PhoneNumberParseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\AdminNotification;
use Exception;


class Utils
{

    static function PORTAL_URL($substring = null)
    {
        return env('WEB_PORTAL_URL', 'https://dev.upbeatcentre.com').$substring;
    }
    
    static function generateMemberID(): string
    {
        return strtoupper(Utils::unique("users", "member_id", 8));
    }

    static function getSizeAndLocation($type, $id)
    {
        if(in_array($type, [ImageType::EVENT, ImageType::ACTIVITY]))
        {
            return (object)[
                "uploader" => Ticket::findOrFail($id),
                "location" => config('image.tickets.path'),
                "size" => config('image.tickets.size'),
                "type" => $type
            ];
        }

        return (object)[
            "uploader" => State::findOrFail(State::DEFAULT),
            "location" => config('image.gallery.path'),
            "size" => config('image.gallery.size'),
            "type" => $type
        ];
    }

    static function generateTicketCode(): string
    {
        return strtoupper(Utils::unique("e_tickets", "ticket_code", 8));
    }

    static function generateSequence(): string
    {
        return mt_rand(100000, 999999) . time();
    }

    /**
     * @param $amount
     * @return string
     */
    static function formatAmount($amount, $decimals = 2): string
    {
        return number_format($amount, $decimals, '.', ',');
    }


    static function generateTransactionReference(): string
    {
        return mt_rand(100000, 999999) . time();
    }

    /**
     * @throws PhoneNumberParseException
     */
    static function formatPhoneNumber(string $phoneNumber): string
    {
        try {
            $number = PhoneNumber::parse($phoneNumber, 'NG');
            $formattedPhoneNumber = $number->format(PhoneNumberFormat::E164); // +2348030520715
            return str_replace("+", "", $formattedPhoneNumber); // 2348030520715
        } catch (PhoneNumberParseException $e) {
            throw $e;
        }
    }

    static function removeCountryCodeFromPhoneNumber(string $phoneNumber): string
    {
        return str_starts_with($phoneNumber, "234") ? "0" . substr($phoneNumber, 3) : $phoneNumber;
    }


    static function checkAndFormatPhoneNumber(string $phoneNumber)
    {
        try {
            if ($phoneNumber[0] === '+')
                $number = PhoneNumber::parse($phoneNumber);
            else
                $number = PhoneNumber::parse($phoneNumber, 'NG');

            if (!$number->isValidNumber())
                throw new InvalidMSISDNFormatException();

            $formattedPhoneNumber = $number->format(PhoneNumberFormat::E164); // +2348030520715
            return str_replace("+", "", $formattedPhoneNumber); // 2348030520715
        } catch (PhoneNumberParseException $e) {
            throw new InvalidMSISDNFormatException();
        }
    }


    static function is_int_val($value)
    {
        if (!preg_match('/^[0-9]+$/', $value)) {
            return FALSE;
        }

        /* Disallow leading 0 */
        // cast value to string, to make index work
        $value = (string)$value;
        if ($value[0] == 0) {
            return FALSE;
        }

        return TRUE;
    }


    static function verifyPin($pin, $partner)
    {
        if (!Hash::check($pin, $partner->pin))
            throw new InvalidPinException();
    }

    static function enumHandler($enum)
    {
        return array_map(function ($key) {
            return [
                "id" => $key,
                "name" =>  self::cleanEnum($key)
            ];
        }, $enum);
    }


    static function cleanEnum($str)
    {
        return ucwords(strtolower(str_replace('_', ' ', $str)));
    }

    public static function validationError($errors)
    {
        $count = count($errors);

        if ($count == 1) {
            return $errors[0];
        } else {
            $otherErrorsCount = $count - 1;
            return $errors[0] . " & $otherErrorsCount other error(s)";
        }
    }


    public static function check($table, $column, $code)
    {
        if (DB::table($table)->where($column, $code)->exists()) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function unique($table, $column, $length, $type = 'alphanumeric')
    {
        $code = $type == 'int' ? substr(str_shuffle('0123456789'), 0, $length) : \Str::random($length);
        if (Utils::check($table, $column, $code) == 1) {
            return $code;
        } else {
            Utils::unique($table, $column, $length, $type);
        }
    }

    public static function getFormatedTimes($selectedTimes)
    {
        $timePattern = '/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/';

        return array_map(function ($times) use ($timePattern){

            if(!preg_match($timePattern, $times[0]) || !preg_match($timePattern,$times[1])){
                throw new Exception("Invalid time formats");
            }

            return [
                "start_at" => $times[0],
                "end_at" => $times[1],
            ];

        }, $selectedTimes);
    }

    public static function csv_file($columns, $data, string $filename = 'export')
    {
        $file      = fopen('php://memory', 'wb');
        $csvHeader = [...$columns];

        fputcsv($file, $csvHeader);

        foreach ($data as $line) {
            fputcsv($file, $line);
        }

        fseek($file, 0);

        $uid = uniqid();

        Storage::disk('local')->put("public/$uid", $file);

        return response()->download(storage_path('app/public/' . $uid), $filename)->deleteFileAfterSend(true);
    }

    public static function cleanCsvValue($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    public static function getEventTicketPrice($event, $ticketType, $numberOfTickets, $coupon, $userId)
    {
        $singleCost = $event->getPrice($ticketType);
        $cashbackCost = 0;
        $isDiscounted = false;

        $totalCost = $singleCost * $numberOfTickets;
        $discount = UserCoupon::where(['user_id' => $userId, 'promo_code_id' => $coupon])->first();

        if($discount && $discount->status == Status::ACTIVE){
            $totalCost -= $totalCost * ($discount->coupon->discount/100);
            $discount->update(['status' => Status::USED]);
            $isDiscounted = true;
        }

        $cashback = $event->getCashBack();

        if($cashback && ($totalCost >= $cashback->minimum)){
            $cashbackCost = $totalCost * ($cashback->percentage/100);
        }

        return (object)[
            'price' => $totalCost,
            'cashback' => $cashbackCost,
            'discount' => $isDiscounted
        ];
    }

    public static function getActivityTicketPrice($activity, $numberOfTickets, $coupon, $userId)
    {
        $cashbackCost = 0;
        $isDiscounted = false;
        $totalCost = $activity->price * $numberOfTickets;

        $discount = UserCoupon::where(['user_id' => $userId, 'promo_code_id' => $coupon])->first();

        if($discount && $discount->status == Status::ACTIVE){
            $totalCost -= $totalCost * ($discount->coupon->discount/100);
            $discount->update(['status' => Status::USED]);
            $isDiscounted = true;
        }

        $cashback = $activity->getCashBack();

        if($cashback && ($totalCost >= $cashback->minimum)){
            $cashbackCost = $totalCost * ($cashback->percentage/100);
        }

        return (object)[
            'price' => $totalCost,
            'cashback' => $cashbackCost,
            'discount' => $isDiscounted
        ];
    }

    public static function adminNotification($data)
    {
        return AdminNotification::create(
            [
                'type' => 'App\Notifications\InAppNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 0,
                'data' => $data
            ]
        );
    }

    public static function adminNotifications()
    {
        return AdminNotification::where(['notifiable_id' => 0])->latest();
    }
    
}
