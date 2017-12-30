<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    const ID = 'id';
    const EMAIL = 'email';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const ADDRESS = 'address';
    const CITY = 'city';
    const STATE = 'state';
    const ZIP = 'zip';
    const PHONE = 'phone';
    const PASSWORD = 'password';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const COMPANY_ID = 'company_id';
    const ROLE_ID = 'role_id';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                static::ID => 1,
                static::EMAIL =>'superadmin@gmail.com',
                static::FIRST_NAME => 'Super',
                static::LAST_NAME => 'Admin',
                static::ADDRESS => 'Some street 3',
                static::CITY => 'Las Vegas',
                static::STATE => 'Nevada',
                static::ZIP => '32414',
                static::PHONE => '755-555-5555',
                static::PASSWORD => Hash::make('qwerty123'),
                static::CREATED_AT => '2017-01-01 10:00:00',
                static::UPDATED_AT => '2017-01-01 10:00:00',
                static::COMPANY_ID => 1,
                static::ROLE_ID => \App\Models\Role::SUPER_ADMIN,
            ],
            [
                static::ID => 2,
                static::EMAIL =>'admin@gmail.com',
                static::FIRST_NAME => 'Admin',
                static::LAST_NAME => 'Admin',
                static::ADDRESS => 'Some street 4',
                static::CITY => 'Las Vegas',
                static::STATE => 'Nevada',
                static::ZIP => '32414',
                static::PHONE => '755-555-5555',
                static::PASSWORD => Hash::make('qwerty123'),
                static::CREATED_AT => '2017-01-01 10:00:00',
                static::UPDATED_AT => '2017-01-01 10:00:00',
                static::COMPANY_ID => 2,
                static::ROLE_ID => \App\Models\Role::ADMIN,
            ],
            [
                static::ID => 3,
                static::EMAIL =>'user@gmail.com',
                static::FIRST_NAME => 'Tester',
                static::LAST_NAME => 'Testowski',
                static::ADDRESS => 'Some street 5',
                static::CITY => 'Las Vegas',
                static::STATE => 'Nevada',
                static::ZIP => '32414',
                static::PHONE => '755-555-5555',
                static::PASSWORD => Hash::make('qwerty123'),
                static::CREATED_AT => '2017-01-01 10:00:00',
                static::UPDATED_AT => '2017-01-01 10:00:00',
                static::COMPANY_ID => 2,
                static::ROLE_ID => \App\Models\Role::USER,
            ],
            [
                static::ID => 4,
                static::EMAIL =>'user2@gmail.com',
                static::FIRST_NAME => 'User',
                static::LAST_NAME => 'User',
                static::ADDRESS => 'Some street 6',
                static::CITY => 'Las Vegas',
                static::STATE => 'Nevada',
                static::ZIP => '32414',
                static::PHONE => '755-555-5555',
                static::PASSWORD => Hash::make('qwerty123'),
                static::CREATED_AT => '2017-01-01 10:00:00',
                static::UPDATED_AT => '2017-01-01 10:00:00',
                static::COMPANY_ID => 2,
                static::ROLE_ID => \App\Models\Role::USER,
            ]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
