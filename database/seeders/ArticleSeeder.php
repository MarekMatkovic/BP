<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::insert([
            [
                'title' => 'Druhý úvod do predmetu',
                'content' => 'Krátky úvodný text.',
                'page_slug' => 'Slovencina3',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'title' => 'Druhé Pravidlá písania',
                'content' => 'Obsah kapitoly o pravidlách.',
                'page_slug' => 'Slovencina3',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
