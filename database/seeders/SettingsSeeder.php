<?php

namespace Database\Seeders;

use App\Enums\SettingsCategory;
use App\Models\General\Setting;
use App\Services\SettingsService;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = database_path('dumps/settings.csv');
		$csv = array_map('str_getcsv', file($csvFile));
		$keys = array_shift($csv);
        $settings = [];

        foreach ($csv as $i => $row) 
        {
            $record = array_combine($keys, $row);
            $settings[] = [
                'key' => $record['item'],
                'value' =>  $record['value'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Setting::upsert($settings, 'key');
    }
}
