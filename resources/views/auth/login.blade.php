<x-guest-layout>
    <x-auth-card>
        @include('partials.layout._alerts')

        <h1 class="text-xl font-semibold text-gray-900 mb-6">Prihlásenie</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            @include('partials.forms._input', [
              'name' => 'email',
              'type' => 'email',
              'label' => 'Email',
              'autocomplete' => 'email',
              'required' => true,
              'autofocus' => true,
            ])

            @include('partials.forms._password', [
              'name' => 'password',
              'label' => 'Heslo',
              'autocomplete' => 'current-password',
            ])

            <div class="flex items-center justify-between">
                @include('partials.forms._checkbox', [
                  'name' => 'remember',
                  'label' => 'Zapamätať si ma',
                ])
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-700" href="{{ route('password.request') }}">
                        Zabudnuté heslo?
                    </a>
                @endif
            </div>

            @include('partials.forms._button', ['label' => 'Prihlásiť sa'])
        </form>

        <p class="mt-6 text-sm text-gray-600">
            Nemáš účet?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Registrovať sa</a>
        </p>
    </x-auth-card>
</x-guest-layout>
