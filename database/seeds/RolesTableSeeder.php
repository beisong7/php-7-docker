<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolesTableSeeder extends Seeder
{
    use \App\Traits\Role\RoleList;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //modified the seed method to manage consistency in updated roles
        $role = new Role();
        $role->uuid = (string)Str::uuid();
        $role->name = 'Super Admin';
        $role->active = true;
        foreach ($this->roleItems() as $item){
            $role->$item =true;
        }
        $role->save();
    }
}
