<x-guest-layout>
    <main class="mx-auto w-full md:w-4/5 px-4 py-10">
        <h1 class="text-2xl font-bold text-gray-900">Otázky: {{ $test->title }}</h1>
        <p class="text-sm text-gray-600">Max bodov aktuálne: {{ $test->max_points }} (aktualizuje sa podľa počtu bodov otázok).</p>

        <form method="POST" action="{{ route('admin.tests.questions.update',$test) }}" class="mt-6 space-y-6">
            @csrf

            @foreach($test->questions as $qIndex => $q)
                <div class="rounded-2xl bg-white p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold text-gray-900">Otázka #{{ $qIndex+1 }}</h2>
                        <label class="text-sm text-gray-700">Body:
                            <input type="number" min="0" name="questions[{{ $q->id }}][points]" value="{{ old("questions.$q->id.points", $q->points) }}"
                                   class="ml-2 w-20 rounded-lg border-gray-300">
                        </label>
                    </div>

                    <div>
                        <input type="text" name="questions[{{ $q->id }}][question]" value="{{ old("questions.$q->id.question", $q->question) }}"
                               class="w-full rounded-xl border-gray-300" placeholder="Text otázky">
                    </div>

                    <div class="space-y-2">
                        @foreach($q->options as $opt)
                            <div class="flex items-center gap-3">
                                <input type="radio" name="correct[{{ $q->id }}]" value="{{ $opt->id }}" {{ $opt->is_correct ? 'checked' : '' }}>
                                <input type="text" name="options[{{ $opt->id }}][text]" value="{{ old("options.$opt->id.text", $opt->text) }}"
                                       class="flex-1 rounded-xl border-gray-300" placeholder="Možnosť">
                                <button formaction="{{ route('admin.tests.questions.update',$test) }}"
                                        name="delete_option" value="{{ $opt->id }}"
                                        class="text-red-600 text-sm">Zmazať</button>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <button name="add_option" value="{{ $q->id }}"
                                class="text-sm text-indigo-700 hover:underline">+ pridať možnosť</button>
                        <button name="delete_question" value="{{ $q->id }}"
                                class="ml-4 text-sm text-red-600 hover:underline"
                                onclick="return confirm('Zmazať otázku?')">Zmazať otázku</button>
                    </div>
                </div>
            @endforeach

            <div class="rounded-2xl  bg-white p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Nová otázka</h3>
                <input type="text" name="new_question[text]" class="w-full rounded-xl border-gray-300" placeholder="Text novej otázky">
                <div class="mt-3 flex items-center gap-3">
                    <label class="text-sm">Body:
                        <input type="number" min="0" name="new_question[points]" value="1" class="ml-2 w-20 rounded-lg border-gray-300">
                    </label>
                </div>
                <p class="mt-2 text-sm text-gray-500">Možnosti pridáš po uložení.</p>
            </div>

            <div class="flex items-center gap-3">
                <button class="rounded-xl bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700">Uložiť zmeny</button>
                <a href="{{ route('admin.tests.index') }}" class="text-gray-700 hover:underline">Späť na testy</a>
            </div>
        </form>
    </main>
</x-guest-layout>
