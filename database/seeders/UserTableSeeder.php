<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin_role = Role::create(['name' => 'superadmin','field_name'=>'Super Admin']);
        $admin_role = Role::create(['name' => 'admin','field_name'=>'Admin']);
    
        

        // DB::table("")
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'super@ero.org',
            'password' => bcrypt('123456'),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@ero.org',
            'password' => bcrypt('123456'),

        ]);

        $superadmin = User::where('email','super@ero.org')->first();
        $superadmin->assignRoleCustom("superadmin",$superadmin->id);

        $admin = User::where('email','admin@ero.org')->first();
        $admin->assignRoleCustom("admin",$admin->id);

    }
}
