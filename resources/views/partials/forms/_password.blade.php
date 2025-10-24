@php
    $id = $id ?? $name ?? 'password';
    $name = $name ?? 'password';
    $autocomplete = $autocomplete ?? 'current-password';
@endphp

<label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">
    {{ $label ?? 'Heslo' }}
</label>

<input
        id="{{ $id }}"
        name="{{ $name }}"
        type="password"
        @if(($required ?? true)) required @endif
        autocomplete="{{ $autocomplete }}"
        placeholder="{{ $placeholder ?? '' }}"
        class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
/>
@error($name)
<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
@enderror
