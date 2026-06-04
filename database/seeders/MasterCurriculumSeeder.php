<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\PageSection;
use App\Models\Article;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestOption;

class MasterCurriculumSeeder extends Seeder
{
    public function run(): void
    {
        $sections = $this->sectionsData();

        foreach ($sections as $section) {
            $slug = $section['slug'];

            // 1) Master sekcia (aby bola viditeľná v hube)
            PageSection::updateOrCreate(
                ['slug' => $slug],
                ['title' => $section['title']]
            );

            // 2) Články: 10 lekcií pre daný slug (upsert podľa (page_slug + title))
            foreach ($section['lessons'] as $i => $lesson) {
                $lessonNumber = $i + 1;

                Article::updateOrCreate(
                    ['page_slug' => $slug, 'title' => $lesson['title']],
                    [
                        'content' => $lesson['content'],
                        'image_url' => null,
                        'image_position' => 'none',
                    ]
                );
            }

            // 3) Test pre danú sekciu (1 test, 10 otázok)
            $test = Test::updateOrCreate(
                ['page_slug' => $slug],
                [
                    'title' => $section['title'] . ' – Záverečný test',
                    'max_points' => 10,
                ]
            );

            // Zmaž staré otázky + možnosti (bezpečne)
            $oldQIds = TestQuestion::where('test_id', $test->id)->pluck('id');
            if ($oldQIds->isNotEmpty()) {
                TestOption::whereIn('question_id', $oldQIds)->delete();
                TestQuestion::where('test_id', $test->id)->delete();
            }

            $points = 0;

            foreach ($section['test'] as $row) {
                $q = TestQuestion::create([
                    'test_id' => $test->id,
                    'question' => $row['q'],
                    'points' => 1,
                ]);
                $points += 1;

                foreach ($row['opts'] as $idx => $text) {
                    TestOption::create([
                        'question_id' => $q->id,
                        'text' => $text,
                        'is_correct' => ($idx === $row['a']),
                    ]);
                }
            }

            // max_points podľa počtu otázok (malo by byť 10)
            $test->update(['max_points' => max(1, $points)]);
        }
    }

    private function p(array $paragraphs): string
    {
        return collect($paragraphs)
            ->map(fn ($t) => '<p>' . e($t) . '</p>')
            ->implode("\n");
    }

    private function sectionsData(): array
    {
        // Každá sekcia = 10 článkov + 10 otázok (1 na lekciu)
        return [
            $this->programovanie1(),
            $this->programovanie2(),
            $this->programovanie3(),
            $this->programovanie4(),
            $this->programovanie5(),

            $this->testovanie1(),
            $this->testovanie2(),
            $this->testovanie3(),
            $this->testovanie4(),
            $this->testovanie5(),
        ];
    }

    private function programovanie1(): array
    {
        $slug = 'Programovanie1';
        $title = 'Programovanie 1';

        $lessons = [
            [
                'title' => 'Programovanie 1 – Lekcia 1: Čo je programovanie a prečo sa ho učiť',
                'content' => $this->p([
                    'Programovanie je spôsob, ako dávame počítaču presné inštrukcie. Počítač nerobí “približne” – vykoná iba to, čo mu povieme. Preto je dôležité myslieť presne, rozdeliť problém na menšie kroky a tieto kroky zapísať do jazyka, ktorému rozumie počítač.',
                    'Výsledkom programovania nemusí byť len aplikácia. Môže to byť automatizácia práce (napr. spracovanie údajov), skript na premenovanie súborov, webová stránka alebo systém, ktorý komunikuje s databázou. V praxi je programovanie aj o tom, že vieš vytvoriť riešenie, ktoré je opakovateľné a spoľahlivé.',
                    'Učenie programovania rozvíja schopnosť riešiť problémy. Pri každej úlohe si kladieš otázky: “Aké vstupy mám?”, “Čo je výstup?”, “Aké pravidlá platia?”, “Aké hraničné prípady môžu nastať?”. Toto je presne typ myslenia, ktorý sa hodí v IT aj mimo neho.',
                    'Mini úloha: vyber si bežný problém (napr. “spočítať nákup”, “vyhodnotiť známky”) a skús si napísať kroky riešenia slovami. Zatiaľ bez kódu – len presný postup.',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 2: Algoritmus, pseudokód a krokovanie',
                'content' => $this->p([
                    'Algoritmus je postup riešenia problému krok za krokom. Je to “recept”, ktorý vedie k výsledku. Dobrý algoritmus je jednoznačný (každý krok má jasný význam), konečný (niekde skončí) a vykonateľný (kroky sa dajú vykonať).',
                    'Pseudokód je “polokód” – zapisuješ riešenie v tvare podobnom programovaciemu jazyku, ale bez presnej syntaxe. Pomáha ti skôr pochopiť logiku ako riešiť detaily. Napríklad: “ak je suma väčšia ako 100, daj zľavu 10%”.',
                    'Krokovanie znamená, že si algoritmus prejdeš na konkrétnom príklade. Napríklad máš zoznam čísel a chceš nájsť maximum – prechádzaš čísla jedno po druhom a kontroluješ, či je nové číslo väčšie než doterajšie maximum.',
                    'Typická chyba: preskočíš krokovanie a ideš rovno do kódu. Potom sa stratíš v chybách. Odporúčanie: pri zložitejšej úlohe si vždy sprav pseudokód a otestuj ho na 2–3 príkladoch.',
                    'Mini úloha: napíš pseudokód pre výpočet priemeru známok (vstup: zoznam známok, výstup: priemer). Potom ho “prejdi” na príklade (napr. 1, 2, 3, 1).',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 3: Premenné a pomenovanie',
                'content' => $this->p([
                    'Premenná je pomenované miesto v pamäti, kam si ukladáš hodnotu. Predstav si ju ako krabičku s menom, do ktorej dáš číslo alebo text. Neskôr túto hodnotu použiješ, zmeníš alebo porovnáš.',
                    'Kľúč je pomenovanie. Zlé pomenovanie premenných je jeden z najčastejších dôvodov neprehľadného kódu. `x`, `a`, `tmp` môžu byť v krátkom príklade OK, ale v reálnej aplikácii chceš `totalPrice`, `userEmail`, `maxScore`.',
                    'Premenné často menia hodnotu. Napríklad v cykle počítaš súčet: začínaš od 0 a postupne pripočítavaš ďalšie čísla. Preto musí byť jasné, čo premenná reprezentuje a aká hodnota sa od nej očakáva.',
                    'Typická chyba: miešanie významov. Premenná sa najprv používa ako “počet položiek” a neskôr ako “suma”. To je recept na bugy. Každá premenná nech má jeden význam.',
                    'Mini úloha: navrhni 5 premenných, ktoré by si použil v e-learning aplikácii (napr. meno používateľa, počet bodov, percentá). Ku každej napíš, aký typ hodnoty bude obsahovať.',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 4: Dátové typy a konverzie',
                'content' => $this->p([
                    'Dátový typ hovorí, aký druh hodnoty premenná drží. Najčastejšie typy: číslo, text (string), boolean (true/false), pole (array) a objekt.',
                    'Problémy vznikajú pri konverziách. Napríklad “10” (text) a 10 (číslo) vyzerajú rovnako, ale správanie môže byť iné pri porovnávaní alebo sčítaní. Zvyk: vždy si ujasni, či pracuješ s textom alebo číslom.',
                    'V praxi často dostávaš vstup z formulára ako text. Aj keď používateľ zadá číslo, môže prísť ako string. Preto je dôležité validovať a prípadne konvertovať typ.',
                    'Boolean je skvelý na stavy: prihlásený/neprihlásený, aktívny/neaktívny, dokončené/nedokončené. Takéto stavy robia kód jednoduchším.',
                    'Mini úloha: uveď 3 príklady, kde sa ti v aplikácii môže “tváriť číslo ako text”. Napíš, čo by si spravil, aby si tomu predišiel (validácia/konverzia).',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 5: Operátory a porovnania',
                'content' => $this->p([
                    'Operátory používame na výpočty (+, -, *, /) a porovnania (==, !=, >, <, >=, <=). Porovnania vracajú boolean hodnotu (true/false).',
                    'V praxi sú porovnania základom rozhodovania v if/else. Napríklad: “ak má používateľ viac ako 80% bodov, test je úspešne splnený”.',
                    'Logické operátory AND/OR (napr. &&, ||) umožňujú kombinovať podmienky. AND znamená, že musia byť splnené všetky podmienky. OR znamená, že stačí jedna.',
                    'Typická chyba: nesprávne porovnanie typov (napr. text vs číslo), alebo zle zoskupené podmienky bez zátvoriek. Odporúčanie: pri zložitejšej logike používaj zátvorky a rozdeľ podmienky do premenných s názvom.',
                    'Mini úloha: napíš 3 podmienky, ktoré by rozhodovali o výsledku testu (napr. percento >= 60, používateľ je prihlásený, test nie je po deadline).',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 6: Podmienky (if/else) a čitateľnosť',
                'content' => $this->p([
                    'Podmienky umožňujú programu rozhodovať sa. if spustí kód, ak je podmienka true. else sa vykoná, keď podmienka true nie je.',
                    'Ak máš viac možností, používa sa else if (reťazenie podmienok). Dávaj pozor na poradie – prvá splnená vetva ukončí reťaz.',
                    'Čitateľnosť je priorita. Ak sa podmienka nedá prečítať na jeden nádych, pravdepodobne je príliš zložitá. Pomôže rozbiť ju do menších častí a pomenovať si medzivýsledky.',
                    'Dobrá prax je používať “guard clauses” – teda skoro vrátiť výsledok pri chybovom stave (napr. keď používateľ nie je prihlásený). Znižuje to zanořovanie.',
                    'Mini úloha: navrhni podmienky pre prístup k admin sekcii: (1) používateľ prihlásený, (2) má rolu moderátor alebo admin. Skús to napísať čitateľne.',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 7: Cykly a práca so zoznamom',
                'content' => $this->p([
                    'Cykly opakujú blok kódu. Najčastejšie: for (počet opakovaní), while (kým platí podmienka) a foreach (pre každý prvok v zozname).',
                    'V e-learning aplikácii často spracúvaš zoznamy: kapitoly, otázky, výsledky testov. Tam je foreach ideálny, lebo sa sústredíš na “každú položku”.',
                    'Pozor na nekonečné cykly: while cyklus sa musí vedieť zastaviť. Pri for cykle si dávaj pozor na hranice (od 0 po n-1).',
                    'Výkon: cyklus cez 10 položiek je OK, cez 100 000 už môže byť problém. Zvyk: premýšľaj, koľko dát spracúvaš.',
                    'Mini úloha: predstav si zoznam bodov [3, 5, 1, 4]. Napíš postup (slovne) ako spočítaš súčet a ako nájdeš maximum.',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 8: Funkcie, vstup/výstup a čistota',
                'content' => $this->p([
                    'Funkcie sú základ modularity. Namiesto kopírovania rovnakého kódu si vytvoríš funkciu a voláš ju opakovane.',
                    'Funkcia by mala robiť jednu vec. Ak robí 5 rôznych vecí, bude sa zle testovať a zle upravovať. Dobrý signál je, že sa dá pomenovať jedným slovesom (napr. vypočítajPercentá).',
                    'Základný koncept: vstup (parametre), výstup (return). Keď je funkcia “čistá” (nemá vedľajšie efekty), testuje sa veľmi ľahko.',
                    'Príklad v e-learning: funkcia, ktorá z bodov a maxima vypočíta percentá. To sa dá testovať na pár vstupoch (0/10, 5/10, 10/10).',
                    'Mini úloha: navrhni funkciu, ktorá zistí, či používateľ prešiel testom (percentá >= 60). Aké vstupy potrebuje?',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 9: Debugging a čítanie chýb',
                'content' => $this->p([
                    'Debugging je hľadanie a oprava chýb. Každý programátor to robí denne – je to normálna súčasť práce.',
                    'Najprv si prečítaj error hlášku. Veľmi často obsahuje názov súboru a riadok. Začiatočnícka chyba je preskočiť hlášku a hľadať “naslepo”.',
                    'Krokovanie: zúž problém. Zisti, aké hodnoty prichádzajú do funkcie, či sa spúšťa správna vetva if-u, či cyklus iteruje to, čo čakáš.',
                    'Používaj logy (napr. vypísať hodnotu premennej) alebo debugger v IDE. Neopravuj 10 vecí naraz — rob jednu zmenu a over výsledok.',
                    'Mini úloha: ak ti nejde zobraziť obrázok, čo spravíš? Skontroluj, či sa z DB načítava URL, či je správna, a či sa `<img>` vykreslí v HTML.',
                ]),
            ],
            [
                'title' => 'Programovanie 1 – Lekcia 10: Zhrnutie a študijný plán',
                'content' => $this->p([
                    'V tejto sekcii si si prešiel základ: algoritmus, premenné, typy, operátory, podmienky, cykly, funkcie a debugging.',
                    'Odporúčanie: vytvor si malý plán. Napríklad každý deň 20–30 minút, jedna mini úloha a zápis poznámok. Dôležitejšia je pravidelnosť než jednorazové “maratóny”.',
                    'Pri písaní kódu sa pýtaj: “Je to čitateľné?”, “Dá sa to otestovať?”, “Čo keď príde prázdny vstup?”. Týmto sa rýchlo posunieš.',
                    'Mini úloha: napíš si 3 veci, ktoré chceš vedieť urobiť po tejto kapitole (napr. spraviť jednoduchý formulár, uložiť dáta, zobraziť výsledok).',
                ]),
            ],
        ];

        $test = [
            ['q' => 'Programovanie je…', 'a' => 1, 'opts' => [
                'iba kreslenie webu',
                'tvorba inštrukcií pre počítač',
                'inštalácia aplikácií',
            ]],
            ['q' => 'Algoritmus je…', 'a' => 0, 'opts' => [
                'postup riešenia problému krok za krokom',
                'typ premenných',
                'názov databázy',
            ]],
            ['q' => 'Premenná je…', 'a' => 2, 'opts' => [
                'iba číslo',
                'iba text',
                'pomenované miesto na uloženie hodnoty',
            ]],
            ['q' => 'Dátový typ určuje…', 'a' => 1, 'opts' => [
                'farbu textu',
                'druh hodnoty (číslo/text/true-false)',
                'rýchlosť internetu',
            ]],
            ['q' => 'Operátory sa používajú na…', 'a' => 0, 'opts' => [
                'výpočty a porovnávania',
                'spustenie servera',
                'uloženie fotky',
            ]],
            ['q' => 'if/else slúži na…', 'a' => 2, 'opts' => [
                'kopírovanie súborov',
                'tvorbu grafiky',
                'rozhodovanie podľa podmienky',
            ]],
            ['q' => 'Cykly sú užitočné, keď…', 'a' => 1, 'opts' => [
                'chceš zmazať kód',
                'chceš opakovať činnosť viackrát',
                'chceš zmeniť heslo',
            ]],
            ['q' => 'Funkcia je…', 'a' => 0, 'opts' => [
                'opakovane použiteľný blok kódu',
                'iba komentár',
                'databázová tabuľka',
            ]],
            ['q' => 'Debugging znamená…', 'a' => 1, 'opts' => [
                'písanie dokumentácie',
                'hľadanie a opravu chýb',
                'zmenu farieb UI',
            ]],
            ['q' => 'Najlepší tréning v programovaní je…', 'a' => 2, 'opts' => [
                'len čítať teóriu',
                'len pozerať videá',
                'písať kód a skúšať príklady',
            ]],
        ];

        return compact('slug', 'title', 'lessons', 'test');
    }

    // Pre zvyšné sekcie spravím rovnaký štýl (10 lekcií + 10 otázok),
    // aby to bolo kompletné a konzistentné. Obsah je skrátený, ale po slovensky.

    private function programovanie2(): array
    {
        $slug = 'Programovanie2';
        $title = 'Programovanie 2';

        $lessons = $this->genericLessons($title, [
            'Základy práce so vstupom a výstupom',
            'Reťazce a práca s textom',
            'Polia (arrays) a indexy',
            'Objekty a jednoduché štruktúry',
            'Funkcie pre prácu s poľami',
            'Funkcie pre prácu s textom',
            'Konverzie typov a validácia vstupu',
            'Chyby pri práci s dátami',
            'Čitateľnosť: formátovanie a pomenovania',
            'Zhrnutie + mini úloha',
        ]);

        $test = $this->genericTest10($title, [
            'Vstup/výstup',
            'Reťazce',
            'Polia',
            'Objekty',
            'Funkcie pre polia',
            'Funkcie pre text',
            'Konverzie typov',
            'Validácia',
            'Čitateľnosť',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function programovanie3(): array
    {
        $slug = 'Programovanie3';
        $title = 'Programovanie 3';

        $lessons = $this->genericLessons($title, [
            'Zložitejšie podmienky a logika',
            'Switch/case a čitateľnosť',
            'Zanořovanie vs. guard clauses',
            'Práca s chybovými stavmi',
            'Refaktoring podmienok',
            'Iterácie a mapovanie dát',
            'Vyhľadávanie a filtrovanie',
            'Triedenie dát',
            'Základy časovej zložitosti (intuitívne)',
            'Zhrnutie + príklady',
        ]);

        $test = $this->genericTest10($title, [
            'Logika',
            'Switch',
            'Guard clauses',
            'Chybové stavy',
            'Refaktoring',
            'Mapovanie',
            'Filtrovanie',
            'Triedenie',
            'Zložitosť',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function programovanie4(): array
    {
        $slug = 'Programovanie4';
        $title = 'Programovanie 4';

        $lessons = $this->genericLessons($title, [
            'Modularita a štruktúra projektu',
            'Základy OOP: trieda a objekt',
            'Metódy a vlastnosti',
            'Zapuzdrenie a viditeľnosť',
            'Konštruktor a inicializácia',
            'Jednoduchá dedičnosť',
            'Kompozícia vs. dedičnosť',
            'Práca s dátami cez modely (koncept)',
            'Výnimky a ošetrenie chýb',
            'Zhrnutie + malé cvičenie',
        ]);

        $test = $this->genericTest10($title, [
            'Modularita',
            'Triedy',
            'Metódy',
            'Zapuzdrenie',
            'Konštruktor',
            'Dedičnosť',
            'Kompozícia',
            'Modely',
            'Výnimky',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function programovanie5(): array
    {
        $slug = 'Programovanie5';
        $title = 'Programovanie 5';

        $lessons = $this->genericLessons($title, [
            'Architektúra: vrstvy aplikácie',
            'Základy API a request/response',
            'Validácia vstupu',
            'Autentifikácia (koncept)',
            'Autorizácia (role/práva)',
            'Bezpečnosť: XSS/CSRF (koncept)',
            'Práca s databázou (koncept)',
            'Optimalizácia a caching (koncept)',
            'Logovanie a monitoring',
            'Zhrnutie + odporúčania',
        ]);

        $test = $this->genericTest10($title, [
            'Vrstvy',
            'API',
            'Validácia',
            'Autentifikácia',
            'Autorizácia',
            'Bezpečnosť',
            'Databáza',
            'Caching',
            'Logy',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function testovanie1(): array
    {
        $slug = 'Testovanie1';
        $title = 'Testovanie 1';

        $lessons = $this->genericLessons($title, [
            'Prečo testovať a čo tým získame',
            'Typy testov: unit/integration/e2e',
            'Testovací scenár a očakávania',
            'Hraničné prípady (edge cases)',
            'Testovateľný kód',
            'Základy assertion (tvrdení)',
            'Mocky a izolácia závislostí (koncept)',
            'Test dát a príprava prostredia',
            'Časté chyby v testoch',
            'Zhrnutie + check-list',
        ]);

        $test = $this->genericTest10($title, [
            'Prečo testovať',
            'Typy testov',
            'Scenár',
            'Edge cases',
            'Testovateľnosť',
            'Assertion',
            'Mocky',
            'Prostredie',
            'Chyby',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function testovanie2(): array
    {
        $slug = 'Testovanie2';
        $title = 'Testovanie 2';

        $lessons = $this->genericLessons($title, [
            'AAA: Arrange–Act–Assert',
            'Výber vstupov pre unit test',
            'Deterministické testy',
            'Pokrytie (coverage) – čo znamená',
            'Testovanie výnimiek',
            'Parametrizované testy (koncept)',
            'Rýchlosť testov a optimalizácia',
            'Naming a štruktúra testov',
            'Refaktoring testov',
            'Zhrnutie + odporúčania',
        ]);

        $test = $this->genericTest10($title, [
            'AAA',
            'Vstupy',
            'Deterministickosť',
            'Coverage',
            'Výnimky',
            'Parametrizácia',
            'Rýchlosť',
            'Naming',
            'Refaktoring',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function testovanie3(): array
    {
        $slug = 'Testovanie3';
        $title = 'Testovanie 3';

        $lessons = $this->genericLessons($title, [
            'Integračný test: čo overuje',
            'Práca s DB v testoch (koncept)',
            'Seedovanie test dát (koncept)',
            'Testovanie API endpointov (koncept)',
            'Testovanie autorizácie (koncept)',
            'Testovanie validácií',
            'Chyby v integráciách',
            'Stabilita a flaky testy',
            'Kedy integračné testy stačia',
            'Zhrnutie + check-list',
        ]);

        $test = $this->genericTest10($title, [
            'Integračný test',
            'DB v testoch',
            'Test dáta',
            'API testy',
            'Autorizácia',
            'Validácie',
            'Integrácie',
            'Flaky testy',
            'Kedy stačí',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function testovanie4(): array
    {
        $slug = 'Testovanie4';
        $title = 'Testovanie 4';

        $lessons = $this->genericLessons($title, [
            'E2E: používateľský tok',
            'Nástroje E2E (koncept)',
            'Stabilné selektory (koncept)',
            'Testovanie formulárov',
            'Testovanie navigácie',
            'Screenshots a reporty (koncept)',
            'Rýchlosť E2E testov (koncept)',
            'Kritické scenáre',
            'Ako udržať E2E udržateľné',
            'Zhrnutie + odporúčania',
        ]);

        $test = $this->genericTest10($title, [
            'Tok',
            'Nástroje',
            'Selektory',
            'Formuláre',
            'Navigácia',
            'Reporty',
            'Rýchlosť',
            'Scenáre',
            'Udržateľnosť',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function testovanie5(): array
    {
        $slug = 'Testovanie5';
        $title = 'Testovanie 5';

        $lessons = $this->genericLessons($title, [
            'Stratégia testovania projektu',
            'Test pyramída (koncept)',
            'CI/CD a automatické spúšťanie (koncept)',
            'Kedy testy písať',
            'Ako vyberať scenáre',
            'Dlhodobá údržba testov',
            'Metriky: čo sledovať',
            'Bug report a reprodukcia',
            'Spolupráca tímu',
            'Zhrnutie + praktický plán',
        ]);

        $test = $this->genericTest10($title, [
            'Stratégia',
            'Pyramída',
            'CI/CD',
            'Kedy písať',
            'Scenáre',
            'Údržba',
            'Metriky',
            'Bug report',
            'Tím',
            'Zhrnutie',
        ]);

        return compact('slug', 'title', 'lessons', 'test');
    }

    private function genericLessons(string $sectionTitle, array $topics): array
    {
        $lessons = [];
        foreach ($topics as $i => $topic) {
            $n = $i + 1;
            $lessons[] = [
                'title' => $sectionTitle . " – Lekcia {$n}: {$topic}",
                'content' => $this->p([
                    $topic . ' – v tejto lekcii si vysvetlíme hlavné pojmy a prečo sú dôležité v praxi.',
                    'Zameriame sa na jednoduché príklady a typické chyby, ktorým sa oplatí vyhnúť.',
                    'Na konci si odporúčame spraviť krátke vlastné cvičenie, aby si si učivo upevnil.',
                ]),
            ];
        }
        return $lessons;
    }

    private function genericTest10(string $sectionTitle, array $topics): array
    {
        $rows = [];
        foreach ($topics as $i => $topic) {
            $rows[] = [
                'q' => "Čo je hlavná myšlienka témy „{$topic}“ v sekcii {$sectionTitle}?",
                'a' => 1,
                'opts' => [
                    'Nemá praktické využitie',
                    'Pomáha pochopiť a správne používať daný koncept v praxi',
                    'Slúži len na zmenu dizajnu stránky',
                ],
            ];
        }
        return $rows;
    }
}