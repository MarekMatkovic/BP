<x-guest-layout>
    <div class="min-h-screen bg-gray-50">
        <main class="mx-auto w-full md:w-4/5 px-4 py-10">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    @auth Ahoj, {{ Auth::user()->name }}! @else Vitaj! @endauth
                </h1>
                <p class="mt-2 text-gray-600">Vyber si sekciu:</p>
            </header>

            @if($sections->isEmpty())
                <p class="rounded-xl border border-gray-200 bg-white p-6 text-gray-600">
                    Zatiaľ tu nemáš žiadne sekcie. Pridaj záznamy do <code>page_sections</code>.
                </p>
            @else
                @php
                    $chunks = $sections->chunk(10);
                    $left = $chunks->get(0) ?? collect();
                    $right = $chunks->get(1) ?? collect();
                @endphp

                <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        @foreach($left as $s)
                            <x-hub-card
                                    :title="$s->title"
                                    :href="route('hub.section', ['slug' => $s->slug])"
                                    :description="($s->articles_count ?? 0).' článkov'"
                            />
                        @endforeach
                    </div>

                    <div class="space-y-6">
                        @foreach($right as $s)
                            <x-hub-card
                                    :title="$s->title"
                                    :href="route('hub.section', ['slug' => $s->slug])"
                                    :description="($s->articles_count ?? 0).' článkov'"
                            />
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
</x-guest-layout>
