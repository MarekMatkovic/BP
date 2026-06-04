@if (session('status'))
    <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4">
        <div class="text-sm text-red-700 bg-red-50 border border-red-200 rounded-t-xl px-4 py-3">
            <strong>Ups!</strong> Niečo je zle vyplnené.
        </div>
        <ul class="text-sm text-red-700 border-x border-b border-red-200 rounded-b-xl px-4 py-3 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
