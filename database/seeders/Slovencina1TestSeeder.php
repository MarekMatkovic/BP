<?php

// database/seeders/Slovencina1TestSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestOption;

class Slovencina1TestSeeder extends Seeder
{
    public function run(): void
    {
        // Vytvor test
        $test = Test::updateOrCreate(
            ['title' => 'Slovenčina 2', 'page_slug' => 'Slovencina2'],
            ['max_points' => 0] // dopočítame podľa otázok
        );

        // Vymaž staré otázky (ak seeder spúšťaš opakovane)
        $test->questions()->delete();

        // Otázky (single-choice)
        $data = [
            [
                'q' => 'V akom prostredí je vytvorená táto stránka',
                'opts' => [
                    ['text' => 'Laravel', 'ok' => true],
                    ['text' => 'Java', 'ok' => false],
                    ['text' => 'Neviem', 'ok' => false],
                ],
            ],
            [
                'q' => 'Ktoré slovo je PRÍSLOVKA?',
                'opts' => [
                    ['text' => 'Rýchly', 'ok' => false],
                    ['text' => 'Rýchlo', 'ok' => true],
                    ['text' => 'Rýchlosť', 'ok' => false],
                ],
            ],
            [
                'q' => 'Urči správne i/y: „Det*?* bežali do školy.“',
                'opts' => [
                    ['text' => 'i', 'ok' => true],
                    ['text' => 'y', 'ok' => false],
                ],
            ],
        ];

        $max = 0;
        foreach ($data as $row) {
            $q = TestQuestion::create([
                'test_id' => $test->id,
                'question' => $row['q'],
                'points' => 1,
            ]);
            $max += 1;

            foreach ($row['opts'] as $o) {
                TestOption::create([
                    'question_id' => $q->id,
                    'text' => $o['text'],
                    'is_correct' => $o['ok'],
                ]);
            }
        }

        // Nastav max_points podľa počtu otázok
        $test->update(['max_points' => $max]);
    }
}

