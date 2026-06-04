<x-guest-layout>
    <div class="min-h-screen bg-gray-50">
    <main class="mx-auto w-full md:w-4/5 px-4 py-8">
        <a href="{{ route('hub.section', ['slug' => $test->page_slug ?: 'Slovencina1']) }}"
           class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10.828 12l4.95-4.95-1.414-1.414L8 12l6.364 6.364 1.414-1.414z"/>
            </svg>
            Späť na sekciu
        </a>

        <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ $test->title }}</h1>
        <p class="text-gray-600">Max. bodov: {{ $test->max_points }}</p>

        <form method="POST" action="{{ route('tests.submit', $test) }}" class="mt-6 space-y-6">
            @csrf

            @foreach($test->questions as $idx => $q)
                <fieldset class="rounded-2xl  bg-white p-5">
                    <legend class="font-medium text-gray-900">{{ $idx+1 }}. {{ $q->question }}</legend>
                    <div class="mt-3 space-y-2">
                        @foreach($q->options as $opt)
                            <label class="flex items-center gap-2">
                                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt->id }}" class="h-4 w-4">
                                <span class="text-gray-800">{{ $opt->text }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            @endforeach

            @auth
                <button class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                    Odovzdať test
                </button>
            @else
                <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
                    Na odovzdanie testu sa <a class="underline" href="{{ route('login') }}">prihlás</a>.
                </div>
            @endauth
        </form>
    </main>
    </div>
</x-guest-layout>
