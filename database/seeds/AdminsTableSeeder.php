<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
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
                'id' =>1,
                'name' => 'admin',
                'type' => 'admin',
                'email' => 'admin@admin.com',
                'password' => '$2y$10$pJRKQbAQ5ChYur.Q/dhZmuka.ObXm1G6sHB9J59c74P21fxTxEfDC',
                'image' => '',
                'status' => 1,
            ],
        ];
        DB::table('admins')->insert($adminRecords);

        /*foreach ($adminRecords as $key => $record){
            \App\Admin::create($record);
        }*/
    }
}
