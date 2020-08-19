<?php

use Illuminate\Database\Seeder;

class AdminInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin\AdminUser::truncate();
       
        $admin = new \App\Models\Admin\AdminUser();
        $admin->id = 1;
        $admin->name = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('123456');
        $admin->emp_id = 'z20200000000001';
        $admin->mobile = '0123456789';
        $admin->id_number = 'A123456789';
        $admin->save();
    }
}
