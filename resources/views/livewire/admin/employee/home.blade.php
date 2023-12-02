<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title">Employee</h1>

        <a href="{{ route('admin.employee.create') }}" class="bg-primary action-btn">Add New Employee</a>
    </section>
    @livewire('admin.employee.tables.home', key($key))
</section>