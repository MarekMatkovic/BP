<x-guest-layout>
    <main class="mx-auto w-full md:w-4/5 px-4 py-10">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ url('/admin') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 hover:underline">⟵ Späť na prehľad</a>
            <a href="{{ route('admin.tests.create') }}"
               class="rounded-xl bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700">Nový test</a>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-gray-200 bg-white">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Názov</th>
                    <th class="px-4 py-3">Slug sekcie</th>
                    <th class="px-4 py-3">Max bodov</th>
                    <th class="px-4 py-3">Upravené</th>
                    <th class="px-4 py-3 text-right">Akcie</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($tests as $t)
                    <tr>
                        <td class="px-4 py-3 text-gray-900">{{ $t->title }}</td>
                        <td class="px-4 py-3 text-center">{{ $t->page_slug }}</td>
                        <td class="px-4 py-3 text-center">{{ $t->max_points }}</td>
                        <td class="px-4 py-3 text-center">{{ $t->updated_at->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.tests.edit',$t) }}" class="text-indigo-700 hover:underline">Upraviť</a>
                            <a href="{{ route('admin.tests.questions',$t) }}" class="ml-3 text-gray-700 hover:underline">Otázky</a>
                            <form method="POST" action="{{ route('admin.tests.destroy',$t) }}" class="inline"
                                  onsubmit="return confirm('Zmazať test?')">
                                @csrf @method('DELETE')
                                <button class="ml-3 text-red-600 hover:underline">Zmazať</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Žiadne testy.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </main>
</x-guest-layout>
