<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $defaultPassword = \Hash::make(config('app.env') == 'production' ? 'm@bileshop' : 'password');

        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@thaglobetrotters.com',
                'phone_number' => '2348079982123'
            ]
        ];

        $subAdmins = [
            [
                'name' => 'Support Admin',
                'email' => 'subadmin@thaglobetrotters.com',
                'phone_number' => '2348165940836'
            ]
        ];

        foreach($admins as $admin){
            $admin = array_merge($admin, [
                'password' => $defaultPassword,
                'status' => Status::ACTIVE(),
                'state_id' => State::DEFAULT,
                'country_id' => Country::DEFAULT
            ]);

            $user = User::updateOrCreate(['email' => $admin['email']], $admin);
            $user->assignRole(UserRole::ADMIN);
            $user->permissions()->sync(Permission::pluck('id')->toArray());
        }

        foreach($subAdmins as $subAdmin){

            $subAdmin = array_merge($subAdmin, [
                'password' => $defaultPassword,
                'status' => Status::ACTIVE(),
                'state_id' => State::DEFAULT,
                'country_id' => Country::DEFAULT
            ]);

            $user = User::updateOrCreate(['email' => $subAdmin['email']], $subAdmin);
            $user->assignRole(UserRole::SUB_ADMIN);
            $user->permissions()->sync(Permission::pluck('id')->toArray());
        }
    }
}
