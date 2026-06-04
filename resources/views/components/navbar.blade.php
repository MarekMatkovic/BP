@php $user = Auth::user(); @endphp

<nav class="w-full bg-gray-100 border-b border-gray-200">
    <div class="w-full px-4">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-10">
                <div class="flex items-center gap-6">
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-black hover:text-gray-600">
                        BP App
                    </a>
                </div>

                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ url('/') }}"
                       class="text-sm px-3 py-2 rounded-lg text-gray hover:text-white">
                        Domov
                    </a>
                </div>

                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ url('/profile') }}"
                       class="text-sm px-3 py-2 rounded-lg text-gray hover:text-white">
                        Profil
                    </a>
                </div>

                @if(auth()->check() && auth()->user()->hasAnyRole(['moderator','administrator']))
                    <div class="hidden sm:flex items-center gap-6">
                        <a href="{{ url('/admin') }}"
                           class="text-sm px-3 py-2 rounded-lg text-gray-800 hover:bg-white transition-colors">
                            Admin
                        </a>
                    </div>
                @endif

            </div>

            <div class="hidden sm:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm rounded-lg border border-gray-300 hover:bg-gray-100">
                        Prihlásiť sa
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                            Registrácia
                        </a>
                    @endif
                @endguest

                @auth
                    <div class="relative" data-dropdown>
                        <button type="button"
                                class="flex items-center gap-2 rounded-lg px-3 py-2 hover:bg-gray-100"
                                data-dropdown-button>
                            <span class="text-sm text-gray-700">{{ $user->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 rounded-xl border bg-white shadow-md p-1 hidden" data-dropdown-menu>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Odhlásiť sa
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            <button class="sm:hidden inline-flex items-center justify-center rounded-lg p-2 hover:bg-gray-100"
                    aria-label="Menu" data-mobile-toggle>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <div class="sm:hidden border-t bg-white hidden" data-mobile-menu>
        <div class="space-y-1 px-4 py-3">
            <a href="{{ url('/') }}"
               class="block rounded-lg px-3 py-2 text-sm {{ request()->is('/') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                Domov
            </a>

            @auth
                <div class="px-3 pt-2 pb-1 text-xs text-gray-500">Prihlásený: {{ $user->name }}</div>
                <form method="POST" action="{{ route('logout') }}" class="px-3">
                    @csrf
                    <button class="w-full text-left rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        Odhlásiť sa
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-700">
                    Prihlásiť sa
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block rounded-lg px-3 py-2 text-sm bg-indigo-600 text-white hover:bg-indigo-700">
                        Registrácia
                    </a>
                @endif
            @endguest
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.querySelector('[data-mobile-toggle]');
        const menu = document.querySelector('[data-mobile-menu]');
        btn?.addEventListener('click', () => menu?.classList.toggle('hidden'));

        const dd = document.querySelector('[data-dropdown]');
        const ddBtn = dd?.querySelector('[data-dropdown-button]');
        const ddMenu = dd?.querySelector('[data-dropdown-menu]');
        ddBtn?.addEventListener('click', (e) => { e.stopPropagation(); ddMenu?.classList.toggle('hidden'); });
        document.addEventListener('click', () => ddMenu && !ddMenu.classList.contains('hidden') && ddMenu.classList.add('hidden'));
    });
</script>
