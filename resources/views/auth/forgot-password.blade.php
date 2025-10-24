<x-guest-layout>
    <x-auth-card>
    @include('partials.layout._alerts')

    <h1 class="text-xl font-semibold text-gray-900 mb-6">Zabudnuté heslo</h1>

    <p class="text-sm text-gray-600 mb-4">
        Zadaj svoj email a pošleme ti odkaz na obnovenie hesla.
    </p>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        @include('partials.forms._input', [
          'name' => 'email',
          'type' => 'email',
          'label' => 'Email',
          'autocomplete' => 'email',
          'required' => true,
        ])

        @include('partials.forms._button', ['label' => 'Poslať odkaz'])
    </form>

    <p class="mt-6 text-sm text-gray-600">
        Späť na
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">prihlásenie</a>
    </p>
    @endinclude
    </x-auth-card>
</x-guest-layout>
