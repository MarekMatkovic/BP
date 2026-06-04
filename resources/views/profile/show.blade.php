<x-guest-layout>
    <div class="min-h-screen bg-gray-50">
    <main class="mx-auto w-full md:w-4/5 px-4 py-10">
        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <section class="mt-6 mb-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="rounded-2xl mb-6 bg-white p-6">
                <h2 class="text-lg font-semibold text-gray-900">Údaje</h2>
                <dl class="mt-4 space-y-2 text-gray-700">
                    <div class="flex gap-3">
                        <dt class="font-medium">Meno:</dt>
                        <dd>{{ $user->name }}</dd>
                    </div>
                    <div class="flex gap-3">
                        <dt class="font-medium">Email: </dt>
                        <dd>{{ $user->email }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl bg-white p-6">
                <h2 class="text-lg font-semibold text-gray-900">Zmeniť heslo</h2>
                <form action="{{ route('profile.password') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <div class = 'mb-6'>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Aktuálne heslo</label>
                        <input type="password" name="current_password" required
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"/>
                        @error('current_password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class = 'mb-6'>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nové heslo</label>
                        <input type="password" name="password" required
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"/>
                        @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class = 'mb-6'>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Potvrdenie nového hesla</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"/>
                    </div>
                    <button class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                        Uložiť nové heslo
                    </button>
                </form>
            </div>
        </section>


        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">Moje najlepšie výsledky</h2>

            @if($results->isEmpty())
                <p class="mt-4 rounded-2xl border border-gray-200 bg-white p-6 text-gray-600">
                    Zatiaľ nemáš žiadne výsledky.
                </p>
            @else
                <div class="mt-4 overflow-x-auto rounded-2xl border border-gray-200 bg-white">
                    <table class="w-full table-fixed text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left w-1/2">Test</th>
                            <th class="px-4 py-3 text-right w-1/8">Body</th>
                            <th class="px-4 py-3 text-right w-1/8">Max</th>
                            <th class="px-4 py-3 text-right w-1/8">%</th>
                            <th class="px-4 py-3 text-right w-1/4">Najlepší pokus</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($results as $r)
                            @php
                                $max = $r->test?->max_points ?? 0;
                                $pct = $max > 0 ? round(($r->best_points / $max) * 100, 2) : 0;
                            @endphp
                            <tr class="text-gray-800">
                                <td class="px-4 py-3 text-left truncate">
                                    {{ $r->test?->title ?? 'Neznámy test' }}
                                </td>
                                <td class="px-4 py-3 text-center">{{ $r->best_points }}</td>
                                <td class="px-4 py-3 text-center">{{ $max }}</td>
                                <td class="px-4 py-3 text-center">{{ number_format($pct, 2) }}%</td>
                                <td class="px-4 py-3 text-center">
                                    {{ $r->last_completed_at ? \Carbon\Carbon::parse($r->last_completed_at)->format('d.m.Y H:i') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

    </main>
    </div>
</x-guest-layout>
