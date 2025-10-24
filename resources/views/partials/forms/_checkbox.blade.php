@php
    $id = $id ?? $name;
@endphp

<div class="flex items-center">
    <input id="{{ $id }}" name="{{ $name }}" type="checkbox"
           @checked(old($name, $checked ?? false))
           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
    <label for="{{ $id }}" class="ml-2 block text-sm text-gray-700">
        {{ $label ?? Str::of($name)->headline() }}
    </label>
</div>
@error($name)
<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
@enderror
