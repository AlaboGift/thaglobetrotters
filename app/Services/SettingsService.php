<?php

namespace App\Services;

use App\Enums\SettingsCategory;
use App\Models\General\FAQ;
use App\Models\General\Setting;
use App\Services\Messaging\EmailService;
use Illuminate\Support\Facades\Storage;

class SettingsService
{
    public function getBasic(){
        return $this->getSettings(SettingsCategory::BASIC);
    }

    public function postBasic($params){
        $this->updateSettings($params, SettingsCategory::BASIC);
        return $this->getBasic();
    }

    public function getSocial(){
        return $this->getSettings(SettingsCategory::SOCIAL);
    }

    public function postSocial($params){
        $this->updateSettings($params, SettingsCategory::SOCIAL);
        return $this->getSocial();
    }

    public function getSMTP()
    {
        return $this->getSettings(SettingsCategory::SMTP);
    }

    public function postSMTP($params)
    {
        $this->updateSettings($params, SettingsCategory::SMTP);

        (new EmailService("emails/alert/alert-template", $this->getBasic()->email, "SMTP Settings Update Test", [
            'message' => "This message is to confirm that the updated SMTP settings works."]))->dispatch();

        return $this->getSMTP();
    }

    public function getLanding()
    {
        $data = $this->getSettings(SettingsCategory::LANDING);

        return (object)[
            'useVideo' => $data?->useVideo ?? "false",
            'video' => !empty($data?->video) 
                        ? env('AZURE_STORAGE_URL') . '/' . $data->video 
                        : '',
            'image' => !empty($data?->image) 
                        ? env('AZURE_STORAGE_URL') . '/' . $data->image 
                        : ''
        ];
    }

    public function postLanding($params)
    {
        $existingData = $this->getSettings(SettingsCategory::LANDING);

        if($params->hasFile('video')){
            $data = $this->uploadFile($params->video, 'video', $existingData);
        }

        if($params->hasFile('image')){
            $data = $this->uploadFile($params->image, 'image', $existingData);
        }

        $data['useVideo'] = $params->useVideo;
        $this->updateSettings($data, SettingsCategory::LANDING);

        return $this->getLanding();

    }

    public function uploadFile($file, $type, $existingData)
    {
        if(!empty($existingData?->{$type})){
            if (Storage::disk('azure')->exists($existingData->{$type})) {
                Storage::disk('azure')->delete($existingData->{$type});
            }
        }

        $fileName = time().'_'.$file->getClientOriginalName();
        $file->storeAs('uploads/', $fileName, 'azure');
        $data[$type] = 'uploads/'.$fileName;

        return $data;
    }

    public function getFAQs(){
        return FAQ::latest();
    }

    public function postFAQs($params){
        return FAQ::create([
            'question' => $params['question'],
            'answer' => $params['answer']
        ]);
    }

    public function updateFAQs($params)
    {
        return FAQ::updateOrCreate(['id' => $params['faq_id']], [
            'question' => $params['question'],
            'answer' => $params['answer']
        ]);
    }

    public function deleteFAQs($faq)
    {
        return $faq->delete();
    }

    public function updateSettings($settings, $category)
    {
        $data = [];

        foreach($settings as $key => $value){
            $value = is_array($value) ? json_encode($value) : $value;
            $data[] = ['key' => $key, 'value' => $value, 'category' => $category];
        }

        Setting::upsert($data, ['key'], ['value']);
    }

    public function getSettings($category)
    {
        return (object)Setting::where('category', $category)
                    ->pluck('value', 'key')
                    ->map(function($value, $key) {
                        return in_array($key, ["activityCategories", "eventCategories"]) ? json_decode($value) : $value;
                    })->toArray();
    }
}