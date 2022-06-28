<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    use \App\Traits\General\Utility;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create(
            [
                'uuid'=>$this->makeUuid(),
                'first_name'=>'super',
                'last_name'=>'admin',
                'email'=>'test@app.com',
                'password'=>bcrypt('password'),
                'email_verified_at'=>now(),
            ]
        );
    }
}
