<header class="border-b border-secondary w-full flex justify-between items-center p-3 sticky top-0 z-50 ">
    @if (!AppHelper::isAdminAuthRoute())
        <button class="text-xl text-dark dark:text-white" x-on:click="toggleSidebar = !toggleSidebar">
            <i class="las la-bars"></i>
        </button>
    @endIf

    <div>
        USER ID: {{ auth()->user()->unique_id }}
    </div>

    {{-- <img src="{{asset('images/logo/logo.png')}}" class="scale-50" /> --}}
    @if (!AppHelper::isAdminAuthRoute())
        <div class="relative" x-data="{ show: false }" x-cloak>
            <button class="text-xl text-white bg-danger rounded-full py-1 px-2" x-on:click="show = !show">
                <i class="las la-user"></i>
            </button>

            <div class="absolute w-[200px] right-[15px] z-50 bg-white rounded-lg shadow-xl overflow-hidden"
                x-show="show" x-cloak x-on:click.away="show = false">
                <ul>
                    {{-- <li>
                    <a href="{{route('admin.setting.update_password')}}"
                        class="py-2 px-3 block hover:bg-gray-100">Account Setting</a>
                </li> --}}
                    <li>
                        <a href="{{ route('logout') }}" class="py-2 px-3 block hover:bg-gray-100">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    @endIf
</header>
