<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'title' => 'Преступление и наказание',
            'description' => 'Преступление и наказание: Описание',
            'image' => 'uploads/pic1.jpg',
            'author_id' => 1,
        ]);
        DB::table('books')->insert([
            'title' => 'Герой нашего времени',
            'description' => 'Герой нашего времени: Описание',
            'image' => 'uploads/pic2.jpg',
            'author_id' => 2,
        ]);
        DB::table('books')->insert([
            'title' => 'Обломов',
            'description' => 'Обломов: Описание',
            'image' => 'uploads/pic3.jpg',
            'author_id' => 3,
        ]);
        DB::table('books')->insert([
            'title' => 'Мцыри',
            'description' => 'Мцыри: Описание',
            'image' => 'uploads/pic4.jpg',
            'author_id' => 2,
        ]);
        //Yanka kupala
        DB::table('books')->insert([
            'title' => 'Паўлінка',
            'description' => 'Паўлінка: Описание',
            'image' => 'uploads/pic5.jpg',
            'author_id' => 4,
        ]);
        //Yakib Kolas
        DB::table('books')->insert([
            'title' => 'Новая земля',
            'description' => 'Новая земля: Описание',
            'image' => 'uploads/pic6.jpg',
            'author_id' => 5,
        ]);
    }
}
