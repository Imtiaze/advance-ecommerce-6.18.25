<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        $adminRecords = [
            [
                'id'       => 1,
                'name'     => 'admin',
                'type'     => 'admin',
                'email'    => 'admin@gmail.com',
                'mobile'   => '01303120306',
                'password' => Hash::make('123456'),
                'image'    => '',
                'status'   => 1,
            ]
        ];

        foreach ($adminRecords as $key => $value) {
            Admin::create($value);
        }
    }
}
