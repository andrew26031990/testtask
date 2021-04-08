<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors')->insert([
            'name' => 'Достоевский',
        ]);
        DB::table('authors')->insert([
            'name' => 'Лермонтов',
        ]);
        DB::table('authors')->insert([
            'name' => 'Гончаров',
        ]);
        DB::table('authors')->insert([
            'name' => 'Янка Купала',
        ]);
        DB::table('authors')->insert([
            'name' => 'Якуб Колас',
        ]);
    }
}
