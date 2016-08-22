<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        switch (getenv('APP_ENV')) {
            case 'production':
                DB::table('users')->insert([
                    'name' => 'Administrator',
                    'email' => env('ADMIN_EMAIL'),
                    'password' => bcrypt('ADMIN_PASSWORD')
                ]);
                break;

            case 'local':
                DB::table('users')->insert([
                    'name' => 'Administrator',
                    'email' => env('ADMIN_EMAIL'),
                    'password' => bcrypt('ADMIN_PASSWORD')
                ]);
                factory(User::class, 10)->create();
                break;

            case 'testing':
                DB::table('users')->insert([
                    'name' => 'Administrator',
                    'email' => 'admin@domain.com',
                    'password' => bcrypt('123')
                ]);
                break;
        }
    }
}