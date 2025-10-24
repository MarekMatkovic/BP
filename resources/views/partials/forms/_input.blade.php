@php
    $id = $id ?? $name;
    $type = $type ?? 'text';
    $value = $value ?? old($name);
    $autocomplete = $autocomplete ?? $name;
    $required = $required ?? false;
    $autofocus = $autofocus ?? false;
@endphp

<label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">
    {{ $label ?? Str::of($name)->headline() }}
</label>

<input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        @if($required) required @endif
        @if($autofocus) autofocus @endif
        autocomplete="{{ $autocomplete }}"
        placeholder="{{ $placeholder ?? '' }}"
        class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
/>
@error($name)
<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
@enderror
