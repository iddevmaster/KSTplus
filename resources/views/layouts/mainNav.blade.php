<nav x-data="{ open: false }" class="z-10 sticky top-0 border-b border-gray-100" style="background-color: var(--primary-color); border: unset;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <div class="bg-light py-2 rounded">
                        <a href="{{ route('home') }}">
                            <img src="/img/logo.png" alt="" width="100">
                        </a>
                    </div>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('My Course') }}
                    </x-nav-link>
                </div> --}}
            </div>
            <div class="flex items-center ml-2">
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex" style="color:white !important">
                    <a href="{{route('main')}}" >
                        {{ __('messages.home') }}
                    </a>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <a href="#" >
                                {{ __('messages.course') }}
                            </a>
                        </x-slot>

                        <x-slot name="content">
                            @can('course')
                                <x-dropdown-link :href="route('ownCourse')">
                                    {{ __('messages.own_course') }}
                                </x-dropdown-link>
                            @endcan
                            <x-dropdown-link :href="route('course.all')">
                                {{ __('messages.all_course') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('classroom')">
                                {{ __('messages.classroom') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    @can('quiz')
                        <a href="{{route('quiz')}}" >
                            {{ __('messages.quiz') }}
                        </a>
                    @endcan
                    @can('req')
                        <a href="{{route('request.all')}}" >
                            {{ __('messages.request') }}
                        </a>
                    @endcan
                    @can('userm')
                        <a href="{{route('users.all')}}" >
                            {{ __('messages.users') }}
                        </a>
                    @endcan
                    @if (auth()->user()->hasAnyPermission(['dCourse', 'dQuiz', 'dLog', 'dHistory']) || auth()->user()->hasRole('admin'))
                        <a href="{{route('dashboard')}}" >
                            {{ __('messages.dashboard') }}
                        </a>
                    @endif
                    <a href="{{route('user-manual')}}" >
                        {{ __('messages.user_manual') }}
                    </a>
                </div>
            </div>

            @php
                $alerts = App\Models\user_request::where('alert', 'LIKE', '%"' . auth()->user()->id . '"%')->get();
            @endphp

            @can('req')
                <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" class="inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none  " type="button">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 14 20">
                        <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"/>
                    </svg>
                    @if (count($alerts) > 0)
                        <div class="relative flex">
                            <div class="relative inline-flex w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-2 right-3 dark:border-gray-900"></div>
                        </div>
                    @endif
                </button>
            @endcan

            <!-- Dropdown menu -->
            <div id="dropdownNotification" class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow  dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
                <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50  ">
                    {{ __('messages.notify') }}
                </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @if (count($alerts) > 0)
                    @foreach ($alerts as $alert)
                        @if ($alert->status == 0)
                            <a href="{{route('request.all')}}" class="notification flex gap-4 block max-w-sm px-4 py-2 hover:bg-gray-100" data-alert-id="{{ $alert->id }}">
                                <div class="flex justify-center items-center">
                                    <div style="background-image: url('/img/icons/{{$alert->getUser->icon? $alert->getUser->icon : 'person.jpg'}}'); width: 40px; height: 40px; background-size: cover; background-position: center; border-radius: 100%; border: 1px solid black"></div>
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold tracking-tight text-gray-900 ">
                                        {{ $alert->getUser->name }} ({{ $alert->getUser->dpmName->name }}) &nbsp; <span class="text-xs text-gray-400 ms-2"><i class="bi bi-clock"></i> {{ Carbon\Carbon::parse($alert->created_at)->thaidate('j M Y') }}</span>
                                    </h5>
                                    <p class="font-normal text-xs text-gray-700 " style="overflow-wrap: break-word; word-wrap: break-word; hyphens: auto;">
                                        @if ($alert->type === 'course')
                                            คำขอเพิ่มหลักสูตร
                                        @else
                                            คำขออื่นๆ
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @elseif ($alert->status == 1)
                            <a href="{{route('request.all')}}" class="notification flex gap-4 block max-w-sm px-4 py-2 bg-green-100 hover:bg-green-200" data-alert-id="{{ $alert->id }}">
                                <div class="flex justify-center items-center">
                                    <div style="background-image: url('/img/icons/{{$alert->getUser->icon? $alert->getUser->icon : 'person.jpg'}}'); width: 40px; height: 40px; background-size: cover; background-position: center; border-radius: 100%; border: 1px solid black"></div>
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold tracking-tight text-gray-900 ">
                                        {{ $alert->getUser->name }} ({{ $alert->getUser->dpmName->name }}) &nbsp; <span class="text-xs text-gray-400 ms-2"><i class="bi bi-clock"></i> {{ Carbon\Carbon::parse($alert->created_at)->thaidate('j M Y') }}</span>
                                    </h5>
                                    <p class="font-normal text-xs text-gray-700 " style="overflow-wrap: break-word; word-wrap: break-word; hyphens: auto;">
                                        @if ($alert->type === 'course')
                                            คำขอเพิ่มหลักสูตร
                                        @else
                                            คำขออื่นๆ
                                        @endif
                                        <span class="justify-center inline-flex items-center p-1 text-xs font-medium text-center text-white bg-green-500 rounded-lg">
                                            ดำเนินการสำเร็จ
                                        </span>
                                    </p>
                                </div>
                            </a>
                        @elseif ($alert->status == 2)
                            <a href="{{route('request.all')}}" class="notification flex gap-4 block max-w-sm px-4 py-2 bg-pink-100 hover:bg-pink-200" data-alert-id="{{ $alert->id }}">
                                <div class="flex justify-center items-center">
                                    <div style="background-image: url('/img/icons/{{$alert->getUser->icon? $alert->getUser->icon : 'person.jpg'}}'); width: 40px; height: 40px; background-size: cover; background-position: center; border-radius: 100%; border: 1px solid black"></div>
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold tracking-tight text-gray-900 ">
                                        {{ $alert->getUser->name }} ({{ $alert->getUser->dpmName->name }}) &nbsp; <span class="text-xs text-gray-400 ms-2"><i class="bi bi-clock"></i> {{ Carbon\Carbon::parse($alert->created_at)->thaidate('j M Y') }}</span>
                                    </h5>
                                    <p class="font-normal text-xs text-gray-700 " style="overflow-wrap: break-word; word-wrap: break-word; hyphens: auto;">
                                        @if ($alert->type === 'course')
                                            คำขอเพิ่มหลักสูตร
                                        @else
                                            คำขออื่นๆ
                                        @endif
                                        <span class="justify-center inline-flex items-center p-1 text-xs font-medium text-center text-white bg-red-500 rounded-lg">
                                            ดำเนินการไม่สำเร็จ
                                        </span>
                                    </p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @else
                    <div class="flex justify-center py-4">
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ __('messages.notify_no') }}</span>
                    </div>
                @endif
            </div>
            <a href="{{route('request.all')}}" class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100  dark:hover:bg-gray-700 ">
                <div class="inline-flex items-center ">
                <svg class="w-4 h-4 mr-2 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                    <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                </svg>
                    {{ __('messages.view_all') }}
                </div>
            </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('messages.profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('messages.logout') }}
                            </x-dropdown-link>
                        </form>
                        <hr>
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('switch-language', ['locale' => 'en']) }}" data-toggle="tooltip" title="English"><img src="/img/english.png" class="hover:scale-90" width="30" alt=""></a>
                            <a href="{{ route('switch-language', ['locale' => 'th']) }}" data-toggle="tooltip" title="Thai"><img src="/img/thai.png" class="hover:scale-90" width="30" alt=""></a>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md  hover:text-black hover:bg-white focus:outline-none focus:bg-white focus:text-black transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('main')" :active="request()->routeIs('home')">
                {{ __('messages.home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('course.all')" :active="request()->routeIs('home')">
                {{ __('messages.all_course') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('course.all')" :active="request()->routeIs('home')">
                {{ __('messages.classroom') }}
            </x-responsive-nav-link>
            @can('course')
                <x-responsive-nav-link :href="route('course.all')" :active="request()->routeIs('home')">
                    {{ __('messages.own_course') }}
                </x-responsive-nav-link>
            @endcan
            @can('quiz')
                <x-responsive-nav-link :href="route('quiz')" :active="request()->routeIs('home')">
                    {{ __('messages.quiz') }}
                </x-responsive-nav-link>
            @endcan
            @can('req')
                <x-responsive-nav-link :href="route('request.all')" :active="request()->routeIs('home')">
                    {{ __('messages.request') }}
                </x-responsive-nav-link>
            @endcan
            @can('userm')
                <x-responsive-nav-link :href="route('users.all')" :active="request()->routeIs('home')">
                    {{ __('messages.users') }}
                </x-responsive-nav-link>
            @endcan
            @canAny(['dCourse', 'dQuiz', 'dLog', 'dHistory'])
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('home')">
                    {{ __('messages.dashboard') }}
                </x-responsive-nav-link>
            @endcanAny
            <x-responsive-nav-link :href="route('user-manual')" :active="request()->routeIs('home')">
                {{ __('messages.user_manual') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->username }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('messages.profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('messages.logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<script>
    $(document).ready(function() {
        $('.notification').click(function() {
            // Get the notification ID from the data attribute
            var notificationId = $(this).data('alert-id');

            // Send an AJAX request to mark the notification as read
            $.ajax({
                url: '/notifications/mark-as-read/' + notificationId, // You need to define this route in your web.php
                type: 'GET',
                success: function(response) {
                    // You can add some code here to handle a successful response
                    console.log(response['response']);
                },
                error: function(error) {
                    // You can add some error handling here
                    console.log(error);
                }
            });
        });
    });
</script>


<style>

</style>
