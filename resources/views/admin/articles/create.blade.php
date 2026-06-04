<x-guest-layout>
    <main class="mx-auto w-full md:w-3/4 px-4 py-10">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Nový článok</h1>
        @include('admin.articles.form', ['article'=>null])
    </main>
</x-guest-layout>
