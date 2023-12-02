<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Users</h1>

        {{-- <a href="{{ route('admin.user.create') }}" class="bg-primary action-btn">Add New Customers</a> --}}
    </section>
    @livewire('admin.user.tables.home', key($key))
</section>
