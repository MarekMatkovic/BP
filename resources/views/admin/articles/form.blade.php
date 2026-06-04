@props(['article'=>null])

@php
    $action = $article ? route('admin.articles.update',$article) : route('admin.articles.store');
    $method = $article ? 'PUT' : 'POST';

    $defaultImage = 'https://placehold.co/1200x600?text=Uk%C3%A1zkov%C3%BD+obrazok';
@endphp

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<form method="POST" action="{{ $action }}" class="space-y-8" x-data="articleEditor()">
    @csrf @method($method)

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nadpis</label>
                <input type="text" name="title" x-model="title"
                       value="{{ old('title', $article->title ?? '') }}" required
                       class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug sekcie (napr. Slovencina1)</label>
                <input type="text" name="page_slug" x-model="page_slug"
                       value="{{ old('page_slug', $article->page_slug ?? '') }}" required
                       class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                @error('page_slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Obsah (HTML alebo text)</label>
                <textarea name="content" rows="10" x-model="content"
                          class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('content', $article->content ?? '') }}</textarea>
                @error('content') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL obrázka (voliteľné)</label>
                <input type="url" name="image_url" x-model="image_url"
                       value="{{ old('image_url', $article->image_url ?? '') }}"
                       placeholder="https://..."
                       class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                @error('image_url') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pozícia obrázka</label>
                <select name="image_position" x-model="image_position"
                        class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="none">Žiadny obrázok</option>
                    <option value="right">Vpravo (menší)</option>
                    <option value="below">Pod textom (full šírka)</option>
                </select>
                @error('image_position') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Náhľad článku</h3>
            <div class="rounded-2xl border border-gray-200 bg-white p-6">
                <h2 class="text-xl font-bold text-gray-900" x-text="title || 'Ukážkový nadpis'"></h2>

                <template x-if="image_position === 'right'">
                    <div class="mt-4 flex items-start gap-6">
                        <div class="prose max-w-none min-w-0 flex-1" x-html="previewContent()"></div>

                        <img
                                :src="(image_url && image_url.trim()) ? image_url : '{{ $defaultImage }}'"
                                alt=""
                                class="shrink-0 flex-none self-start rounded-lg border border-gray-200 object-cover"
                                style="width:clamp(25%, 25%, 25%); max-height:25%; height:auto;"
                        >
                    </div>
                </template>


                <template x-if="image_position === 'below'">
                    <div class="mt-4">
                        <div class="prose max-w-none" x-html="previewContent()"></div>
                        <img
                                :src="(image_url && image_url.trim()) ? image_url : '{{ $defaultImage }}'"
                                alt=""
                                class="mt-4 mx-auto w-full rounded-xl border border-gray-200 object-cover"
                                style="max-height:40vh;">

                    </div>
                </template>

                <template x-if="image_position === 'none'">
                    <div class="mt-4 prose max-w-none" x-html="previewContent()"></div>
                </template>
            </div>
        </div>
    </div>

    <button class="rounded-xl bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700">
        Uložiť
    </button>
</form>

<script>
    function articleEditor() {
        return {
            title:        @js(old('title', $article->title ?? '')),
            page_slug:    @js(old('page_slug', $article->page_slug ?? '')),
            content:      @js(old('content', $article->content ?? '')),
            image_url:    @js(old('image_url', $article->image_url ?? '')),
            image_position: @js(old('image_position', $article->image_position ?? 'none')),
            previewContent() {
                const c = this.content || 'Sem príde obsah článku…';
                const looksHtml = /<\/?[a-z][\s\S]*>/i.test(c);
                return looksHtml ? c : c.replace(/\n/g, '<br>');
            },
        }
    }
</script>
