<section :class="toggleSidebar ? '' : 'sidebar-wrapper'" x-on:click="toggleSidebar = !toggleSidebar" x-cloak
    class="bg-black">
    <div x-on:click="event.stopPropagation()" class=" h-screen relative overflow-hidden"
        :class="toggleSidebar ? 'w-0 md:w-[250px]' : 'w-[270px] md:w-0'">
        <ul class="sidebar z-0">
            <li class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <a href="{{ route('user.dashboard') }}">
                    <i class="las la-th"></i>
                    <span>My Form</span>
                </a>
            </li>


            <li class="{{ request()->routeIs('user.transaction.*') ? 'active' : '' }}">
                <a href="{{ route('user.transaction.list') }}">
                    <i class="las la-money-bill"></i>
                    <span>My Transactions</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.logout') }}">
                    <i class="las la-power-off"></i>
                    <span>Logout</span>
                </a>
            </li>

            {{-- <li class="{{request()->routeIs('admin.live.*') ? 'active' : ''}}">
                <a href="{{route('admin.live')}}">
                    <i class="las la-play"></i>
                    <span>Manage Channel Content</span>
                </a>
            </li> --}}


        </ul>
    </div>
</section>
