<x-app-layout>
    <x-auth-card>
        @include('partials.layout._alerts')

    <h1 class="text-xl font-semibold text-gray-900 mb-6">Nastaviť nové heslo</h1>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        @include('partials.forms._input', [
          'name' => 'email',
          'type' => 'email',
          'label' => 'Email',
          'autocomplete' => 'email',
          'required' => true,
          'value' => old('email', $request->email),
        ])

        @include('partials.forms._password', [
          'name' => 'password',
          'label' => 'Nové heslo',
          'autocomplete' => 'new-password',
        ])

        @include('partials.forms._password', [
          'name' => 'password_confirmation',
          'label' => 'Potvrdenie hesla',
          'autocomplete' => 'new-password',
        ])

        @include('partials.forms._button', ['label' => 'Uložiť nové heslo'])
    </form>
    @endinclude
    </x-auth-card>
</x-app-layout>
