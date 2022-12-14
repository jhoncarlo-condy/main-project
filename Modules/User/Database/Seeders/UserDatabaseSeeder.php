<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::firstOrCreate(
            [
                'email' => 'superadmin@davidvenneit.com',
            ],
            [
                'name' => 'Superadmin',
                'password' => Hash::make('ZFAzffinhq4bUhc')
            ]
        );
    }
}
