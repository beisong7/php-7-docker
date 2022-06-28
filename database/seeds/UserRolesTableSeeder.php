<?php

use App\User;
use App\Models\Role;
use App\Models\AdminRoles;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminRoles::create([
        	'uuid' => (string)Str::uuid(),
        	'admin_id' => User::first()->uuid,
        	'role_id' => Role::first()->uuid,
        ]);
    }
}
