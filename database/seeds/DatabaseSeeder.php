<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(AdminsTableSeeder::class);
        //$this->call(SectionSeeder::class);
        $this->call(CategorySeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
