<x-guest-layout>
    <div class="w-full">
        <div class="mb-8">
            <p class="mt-2 text-gray-600">Správa obsahu a testov.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @can('edit articles')
                <a href="{{ route('admin.articles.index') }}"
                   class="block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start gap-4">
                        <div class="rounded-xl bg-gray-100 p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5a2 2 0 00-2 2v14l4-4h12a2 2 0 002-2V5a2 2 0 00-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Správa článkov</h2>
                            <p class="mt-1 text-sm text-gray-600">Vytvoriť, upraviť a zmazať články.</p>
                        </div>
                    </div>
                </a>
            @endcan

            @can('edit tests')
                <a href="{{ route('admin.tests.index') }}"
                   class="block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start gap-4">
                        <div class="rounded-xl bg-gray-100 p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h20V7a2 2 0 00-2-2h-2V3a1 1 0 10-2 0v2H8V3a1 1 0 00-1-1zm15 8H2v10a2 2 0 002 2h16a2 2 0 002-2V10z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Správa testov</h2>
                            <p class="mt-1 text-sm text-gray-600">Testy, otázky a možnosti.</p>
                        </div>
                    </div>
                </a>
            @endcan
        </div>

        @cannot('edit articles')
            @cannot('edit tests')
                <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 text-gray-600">
                    Nemáš oprávnenie na správu obsahu.
                </div>
            @endcannot
        @endcannot
    </div>
</x-guest-layout>