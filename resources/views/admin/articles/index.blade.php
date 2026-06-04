<x-guest-layout>
    <main class="mx-auto w-full md:w-4/5 px-4 py-10">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ url('/admin') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 hover:underline">⟵ Späť na prehľad</a>

            <a href="{{ route('admin.articles.create') }}"
               class="rounded-xl bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700">Nový článok</a>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-gray-200 bg-white">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Nadpis</th>
                    <th class="px-4 py-3">Slug sekcie</th>
                    <th class="px-4 py-3">Upravené</th>
                    <th class="px-4 py-3 text-right">Akcie</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($articles as $a)
                    <tr>
                        <td class="px-4 py-3 text-gray-900">{{ $a->title }}</td>
                        <td class="px-4 py-3 text-center">{{ $a->page_slug }}</td>
                        <td class="px-4 py-3 text-center">{{ $a->updated_at->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.articles.edit',$a) }}" class="text-indigo-700 hover:underline">Upraviť</a>
                            <form method="POST" action="{{ route('admin.articles.destroy',$a) }}" class="inline"
                                  onsubmit="return confirm('Zmazať článok?')">
                                @csrf @method('DELETE')
                                <button class="ml-3 text-red-600 hover:underline">Zmazať</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Žiadne články.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </main>
</x-guest-layout>
