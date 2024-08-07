<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('article.index') }}">
                        <p class="text-xl ">サイト名</p>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                {{-- ユーザーログイン時アイコン表示 --}}
                {{-- @if (Auth::user())
                        
                @endif --}}
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @if (Auth::user())
                                <div>{{ Auth::user()->name }}</div>
                            @endif
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- ログイン中のみ表示 --}}
                        @if (Auth::user())
                            <x-dropdown-link :href="route('article.create')" id="create-article-link">
                                {{ __('記事作成') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('open_profile')">
                                {{ __('公開プロフィール') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('mypage.show')">
                                {{ __('マイページ') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @endif
                        {{-- ログインしていない場合 --}}
                        @if (is_null(Auth::user()))
                        <x-dropdown-link :href="route('auth.first-auth')" id="create-article-link">
                            {{ __('会員登録') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('login')">
                            {{ __('ログイン') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('article.create')" id="create-article-link">
                            {{ __('記事作成') }}
                        </x-dropdown-link>
                        @endif
                        {{-- ログイン中としていない共有 --}}

                        {{-- <x-dropdown-link :href="route('forminput')">
                            {{ __('お問い合わせ') }}
                        </x-dropdown-link> --}}
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @if (Auth::user())
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <span class="flex">
                        <div class="font-medium text-base text-gray-400">{{ Auth::user()->user_name }}</div>
                        <div class="font-medium text-gray-400">({{ Auth::user()->email }})</div>
                    </span>
                </div>
                
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('article.create')" id="create-article-link">
                        {{ __('記事作成') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('open_profile')">
                        {{ __('公開プロフィール') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('mypage.show')">
                        {{ __('マイページ') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endif

        {{-- ログインしていない場合 --}}
        @if (is_null(Auth::user()))
        <div class="pb-1 border-t border-gray-200">
                {{-- <div class="px-4">
                    <span class="flex">
                        <div class="font-medium text-base text-gray-400">{{ Auth::user()->user_name }}</div>
                        <div class="font-medium text-gray-400">({{ Auth::user()->email }})</div>
                    </span>
                </div> --}}
                
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('auth.first-auth')" id="create-article-link">
                        {{ __('会員登録') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('ログイン') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('article.create')" id="create-article-link">
                        {{ __('記事作成') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endif
    </div>
</nav>
@push('scripts')
<script>
    document.getElementById('create-article-link').addEventListener('click', function(event) {
        // リンクのデフォルトの動作を防ぐ
        event.preventDefault();
        // ローカルストレージをクリア
        localStorage.removeItem('title');
        localStorage.removeItem('content');
        localStorage.setItem('action', 'create');


        // リンク先に遷移
        window.location.href = this.href;
    });
    </script>
@endpush
