<x-app-layout>
    <x-auth-card>
        @include('partials.layout._alerts')

    <h1 class="text-xl font-semibold text-gray-900 mb-6">Registrácia</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        @include('partials.forms._input', [
          'name' => 'name',
          'label' => 'Meno',
          'autofocus' => true,
          'required' => true,
          'placeholder' => 'Jana Nováková',
        ])

        @include('partials.forms._input', [
          'name' => 'email',
          'type' => 'email',
          'label' => 'Email',
          'autocomplete' => 'email',
          'required' => true,
          'placeholder' => 'jana@example.com',
        ])

        @include('partials.forms._password', [
          'name' => 'password',
          'label' => 'Heslo',
          'autocomplete' => 'new-password',
        ])

        @include('partials.forms._password', [
          'name' => 'password_confirmation',
          'label' => 'Potvrdenie hesla',
          'autocomplete' => 'new-password',
        ])

        @include('partials.forms._button', ['label' => 'Vytvoriť účet'])
    </form>

    <p class="mt-6 text-sm text-gray-600">
        Už máš účet?
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Prihlásiť sa</a>
    </p>
    </x-auth-card>
</x-app-layout>
