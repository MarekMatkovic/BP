<x-guest-layout>
    <main class="mx-auto w-full md:w-4/5 px-4 py-8">
        <a href="{{ url('/hub') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 hover:underline">⟵ Späť na prehľad</a>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">{{ $sectionTitle ?? $slug }}</h1>

        @forelse($articles as $article)
            @php
                $posRaw = (string)($article->image_position ?? 'none');
                $pos    = strtolower(trim($posRaw));
                $imgRaw = (string)($article->image_url ?? '');
                $img    = trim($imgRaw);

                $showImage = ($img !== '') || in_array($pos, ['right','below'], true);

                if ($showImage && $img === '') {
                    $img = 'https://placehold.co/1200x600?text=Uk%C3%A1zkov%C3%BD+obrazok';
                }
            @endphp

            <h2 class="text-xl font-semibold text-gray-900">{{ $article->title }}</h2>

            @if($showImage && $pos === 'right')
                <div class="mt-3 flex items-start gap-6">
                    <div class="prose max-w-none flex-1">{!! $article->content !!}</div>
                    <img src="{{ $img }}" alt=""
                         class="shrink-0 flex-none self-start rounded-lg border border-gray-200 object-cover cursor-zoom-in"
                         style="width:25%;"
                         data-lightbox-src="{{ $img }}">


                </div>

            @elseif($showImage && $pos === 'below')
                <div class="mt-3 prose max-w-none">{!! $article->content !!}</div>
                <img src="{{ $img }}" alt=""
                     class="mt-4 mx-auto w-full rounded-xl border border-gray-200 object-cover cursor-zoom-in"
                     style="max-height:40vh;"
                     data-lightbox-src="{{ $img }}">

            @elseif($showImage)
                <div class="mt-3 prose max-w-none">{!! $article->content !!}</div>
                <img src="{{ $img }}" alt=""
                     class="mt-4 mx-auto w-full max-w-[70%] md:max-w-[60%] rounded-xl border border-gray-200 object-cover cursor-zoom-in"
                     data-lightbox-src="{{ $img }}">
            @else
                <div class="mt-3 prose max-w-none">{!! $article->content !!}</div>
            @endif
        @empty
            <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 text-gray-600">Zatiaľ tu nič nie je.</div>
        @endforelse
        @isset($sectionTest)
            <div class="mt-4 rounded-2xl border border-indigo-200 bg-indigo-50 p-5 flex items-center justify-between">
                <div class="text-indigo-900">
                    <div class="text-sm">Dostupný test</div>
                    <div class="font-semibold">{{ $sectionTest->title }}</div>
                </div>
                <a href="{{ route('tests.show', $sectionTest) }}"
                   class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                    Spustiť test
                </a>
            </div>
        @endisset
    </main>
</x-guest-layout>
