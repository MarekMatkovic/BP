@props(['test'=>null])

@php
    $action = $test ? route('admin.tests.update',$test) : route('admin.tests.store');
    $method = $test ? 'PUT' : 'POST';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-5">
    @csrf @method($method)

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Názov testu</label>
        <input type="text" name="title" value="{{ old('title', $test->title ?? '') }}" required
               class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
        @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Slug sekcie (napr. Slovencina1)</label>
        <input type="text" name="page_slug" value="{{ old('page_slug', $test->page_slug ?? '') }}" required
               class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
        @error('page_slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Max bodov</label>
        <input type="number" min="1" name="max_points" value="{{ old('max_points', $test->max_points ?? 1) }}" required
               class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
        @error('max_points') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <button class="rounded-xl bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700">
        Uložiť
    </button>
</form>
