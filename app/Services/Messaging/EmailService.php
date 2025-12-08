<?php

namespace App\Services\Messaging;

use App\Jobs\HandleEmailJob;
use App\Services\SettingsService;
use App\Utils\Utils;

class EmailService
{

    private $toAddress;
    private string $template;
    private array $templateData;
    private string $subject;
    private array $attachment;

    public function __construct(string $template, $toAddress, string $subject = "", array $templateData = [], $attachment = [])
    {
        $this->toAddress = $toAddress;
        $this->template = $template;
        $this->templateData = $templateData;
        $this->subject = $subject;
        $this->attachment = $attachment;
    }

    public function dispatch(): void
    {
        $toAddress = $this->toAddress;

        if(is_array($this->toAddress)){
            $toAddress = implode(',', $this->toAddress);
        }

        if ($this->attachment) {
            $pdfContent = $this->loadPDF($this->attachment['filename'], $this->templateData);
            $filePath = storage_path('app/public/' . $this->attachment['filename'] . '.pdf');
            file_put_contents($filePath, $pdfContent);
            $this->attachment['path'] = $filePath;
        }
        
        HandleEmailJob::dispatch($this->subject, trim($toAddress), $this->loadEmailTemplate(), $this->attachment);
    }

    private function loadEmailTemplate(): string
    {
        $settings = (new SettingsService)->getBasic();

        $this->templateData['appName'] = "Upbeat";
        $this->templateData['appOwner'] = "Upbeat";
        $this->templateData['url'] = Utils::PORTAL_URL();
        $this->templateData['email'] = $settings->email;
        $this->templateData['phoneNumber'] = $settings->phoneNumber;
        $this->templateData['vat'] = $settings->vat ?? 7.5;
        return view($this->template, $this->templateData)->render();
    }

    public function loadPDF($file_name, $data)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView($file_name, $data);
        return $pdf->output();
    }
}
