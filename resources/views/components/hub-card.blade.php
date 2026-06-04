@props([
  'title',
  'href' => '#',
  'description' => null,
  'icon' => null,   // optional SVG string
])

<a href="{{ $href }}"
   class="group block rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
    <div class="rounded-xl flex items-start gap-4">
        @if($icon)
            <div class="rounded-xl bg-gray-50 p-3 shrink-0">
                {!! $icon !!}
            </div>
        @endif
        <div>
            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-700">
                {{ $title }}
            </h3>
            @if($description)
                <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
            @endif
        </div>
    </div>
</a>
