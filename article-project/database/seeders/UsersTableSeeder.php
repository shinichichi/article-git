<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
            $params =
            [

            // adminユーザー1
            [
                'user_name' => 'test11',
                'account_name' => 'test11',
                'icon' => 'test1.jpg',
                'admin' => 'admin',
                'email' => 'superstar1999842345@protonmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1999-11-09',
                'created_at' => '2024-05-08 16:19:17',
                'updated_at' => '2024-05-08 16:19:17',
            ],

            // adminユーザー2
            [
                'user_name' => 'test13',
                'account_name' => 'test13',
                'icon' => 'test2.jpg',
                'admin' => 'admin',
                'email' => 'example2@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1998-12-07',
                'created_at' => '2024-05-09 16:19:17',
                'updated_at' => '2024-05-09 16:19:17',
            ],

            // adminユーザー3
            [
                'user_name' => 'test3',
                'account_name' => 'test3',
                'admin' => 'admin',
                'email' => 'example3@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1999-1-07',
                'created_at' => '2024-05-10 16:19:17',
                'updated_at' => '2024-05-10 16:19:17',
            ],

            // adminユーザー4
            [
                'user_name' => 'test4',
                'account_name' => 'test4',
                'admin' => 'admin',
                'email' => 'example4@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '1',
                'birth' => '1999-1-10',
                'created_at' => '2024-05-11 16:19:17',
                'updated_at' => '2024-05-11 16:19:17',
            ],

            // adminユーザー5
            [
                'user_name' => 'test5',
                'account_name' => 'test5',
                'admin' => 'admin',
                'email' => 'example5@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1991-1-17',
                'created_at' => '2024-05-12 16:19:17',
                'updated_at' => '2024-05-12 16:19:17',
            ],

            // 一般ユーザー1
            [
                'user_name' => '一般１',
                'account_name' => 'normal1',
                'icon' => 'test3.jpg',
                'email' => 'example6@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1998-1-27',
                'created_at' => '2024-05-15 16:19:17',
                'updated_at' => '2024-05-15 16:19:17',
            ],

            // 一般ユーザー2
            [
                'user_name' => '一般2',
                'account_name' => 'normal2',
                'icon' => 'test4.jpg',
                'email' => 'example7@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1997-10-07',
                'created_at' => '2024-05-16 16:19:17',
                'updated_at' => '2024-05-16 16:19:17',
            ],

            // 一般ユーザー3
            [
                'user_name' => '一般3',
                'account_name' => 'normal3',
                'icon' => 'test5.jpg',
                'email' => 'example8@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1997-10-07',
                'created_at' => '2024-05-17 16:19:17',
                'updated_at' => '2024-05-17 16:19:17',
            ],

            // 一般ユーザー4
            [
                'user_name' => '一般4',
                'account_name' => 'normal4',
                'email' => 'example9@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1999-10-07',
                'created_at' => '2024-05-18 16:19:17',
                'updated_at' => '2024-05-18 16:19:17',
            ],

            // 一般ユーザー5
            [
                'user_name' => '一般5',
                'account_name' => 'normal5',
                'email' => 'example10@gmail.com',
                'email_verified_at' => '0000-00-00 00:00:00',
                'password' => Hash::make('12345678'),
                'gender' => '0',
                'birth' => '1989-10-17',
                'created_at' => '2024-05-19 16:19:17',
                'updated_at' => '2024-05-19 16:19:17',
            ],
        ];

        foreach ($params as $param) {
            DB::table('users')->insert($param);
        }
    }
}
