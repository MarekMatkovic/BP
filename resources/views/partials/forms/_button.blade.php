@php
    $type = $type ?? 'submit';
@endphp

<button type="{{ $type }}"
        class="inline-flex w-full justify-center items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-white text-sm font-medium
         hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
    {{ $slot ?? ($label ?? 'Potvrdiť') }}
</button>
