<x-guest-layout>
    <div class="min-h-screen bg-gray-50">
        <main class=" mx-auto w-full md:w-4/5 px-4 py-12">

            <h1 class="text-3xl font-bold text-gray-900">
                @auth
                    Vitaj, {{ Auth::user()->name }}
                @else
                    Vitaj v BP App
                @endauth
            </h1>

            @auth
                <p class="mt-2 text-gray-600">
                    Si prihlásený ako <span class="font-medium">{{ Auth::user()->email }}</span>.
                </p>
            @endauth

            <p class="mt-6 text-gray-700 leading-7">
                Táto stránka slúži na vzdelávanie sa technického jazyka a pojmov pre záujemcov o programovanie a technológie.
            </p>

            <p class="mt-4 text-gray-700 leading-7">
                Tu si môžete vybrať jednu z kategórií a začať sa vzdelávať. Každá oblasť má niekoľko kapitol, ktoré môžete študovať.
                Po dokončení kapitoly
                je možnosť dokončenia testu na preverenie Vašich znalostí. Na Vašom profile sa zaznamenáva Váš postup.
            </p>

            <div class="mt-6 flex justify-center">
                @auth
                    <a href="{{ route('hub.index') }}"
                       class="inline-flex items-center rounded-xl bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700">
                        Poďme na to
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center rounded-xl bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700">
                        Prihlásiť sa
                    </a>
                @endauth
            </div>
        </main>
        <footer>
            <div class="mt-10 border-t pt-6 text-sm text-gray-500">
                {{ date('Y') }} BP App Marek Matkovič
            </div>
        </footer>
    </div>
</x-guest-layout>
