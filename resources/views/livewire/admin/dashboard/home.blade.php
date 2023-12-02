<div class="hidden-sub-wrapper">
    <main class="bg-white dark:bg-dark dark:text-white dark:border-gray-500 rounded shadow-xl">

        <x-loading />

        <header class="flex justify-end p-3">
            <select class="form-control md:w-1/4" wire:model="currentStats">
                <option value="all">Overall statistics</option>
                <option value="current_month">This month</option>
                <option value="previous_month">Previous month</option>
                <option value="current_year">This Year</option>
                <option value="previous_year">Previous Year</option>
                <option value="current_week">This Week</option>
                <option value="previous_week">Previous Week</option>
                <option value="today">Today</option>
                <option value="yersterday">Yersterday</option>
            </select>
        </header>

        <div class="p-5">


            <div class="grid grid-cols-1">

                <div class="space-y-5">

                    <section class="grid md:grid-cols-3 gap-3">


                        {{-- <section class="bg-purple-200 rounded-xl">
                            <header class="flex justify-between items-center p-3 ">
                                <button class="bg-white p-2 px-3 rounded-lg">
                                    <i class="las la-tags text-xl"></i>
                                </button>
                                <h3 class="font-bold">Total Revenue</h3>
                            </header>
                            <footer class="flex justify-between items-center p-3 ">
                                <h3 class="header-font text-3xl font-bold">&#8358;
                                    {{ number_format($stats['total_revenue']) }}
                                </h3>
                                <div>
                                    <i class="las la-tags text-xl"></i>
                                </div>
                            </footer>
                        </section> --}}

                        {{-- <section class="bg-purple-200 rounded-xl">
                            <header class="flex justify-between items-center p-3 ">
                                <button class="bg-white p-2 px-3 rounded-lg">
                                    <i class="las la-tags text-xl"></i>
                                </button>
                                <h3 class="font-bold">Active Investment</h3>
                            </header>
                            <footer class="flex justify-between items-center p-3 ">
                                <h3 class="header-font text-3xl font-bold">&#8358; {{ number_format($stats['total_active_investments']) }}
                                </h3>
                                <div>
                                    <i class="las la-tags text-xl"></i>
                                </div>
                            </footer>
                        </section> --}}

                        <section class="bg-purple-200 rounded-xl">
                            <header class="flex justify-between items-center p-3 ">
                                <button class="bg-white p-2 px-3 rounded-lg">
                                    <i class="las la-tags text-xl"></i>
                                </button>
                                <h3 class="font-bold">Total Revenue</h3>
                            </header>
                            <footer class="flex justify-between items-center p-3 ">
                                <h3 class="header-font text-3xl font-bold">&#8358;
                                    {{ number_format($stats['total_revenue']) }}
                                </h3>
                                <div>
                                    <i class="las la-tags text-xl"></i>
                                </div>
                            </footer>
                        </section>

                        <a href="#" class="bg-blue-100 rounded-xl">
                            <header class="flex justify-between items-center p-3 ">
                                <button class="bg-white p-2 px-3 rounded-lg">
                                    <i class="las la-tag  text-xl"></i>
                                </button>
                                <h3 class="font-bold">Total Users</h3>
                            </header>
                            <footer class="flex justify-between items-center p-3 ">
                                <h3 class="header-font text-3xl font-bold">{{ $stats['total_customers'] }}
                                </h3>
                                <div>
                                    <i class="las la-tag  text-xl"></i>
                                </div>
                            </footer>
                        </a>

                        <a href="#" class="bg-green-200 rounded-xl">
                            <header class="flex justify-between items-center p-3 ">
                                <button class="bg-white p-2 px-3 rounded-lg">
                                    <i class="las la-signal text-xl"></i>
                                </button>
                                <h3 class="font-bold">Total Transactions</h3>
                            </header>
                            <footer class="flex justify-between items-center p-3 ">
                                <h3 class="header-font text-3xl font-bold">{{ $stats['total_customers'] }}</h3>
                                <div>
                                    <i class="las la-signal text-xl"></i>
                                </div>
                            </footer>
                        </a>




                        {{-- <a href="{{ route('admin.order.list', ['order_status' => 'pending']) }}"
                            class="bg-light flex justify-between items-center p-3 ">
                            <h3 class="font-bold">Pending Orders</h3>
                            <div class="font-bold">{{ $stats['pending_orders'] }}</div>
                        </a>

                        <a href="{{ route('admin.order.list', ['order_status' => 'delivered']) }}"
                            class="bg-light flex justify-between items-center p-3 ">
                            <h3 class="font-bold">Delivered Orders</h3>
                            <div class="font-bold">{{ $stats['delivered_orders'] }}</div>
                        </a>

                        <a href="{{ route('admin.order.list', ['order_status' => 'cancelled']) }}"
                            class="bg-light flex justify-between items-center p-3 ">
                            <h3 class="font-bold">Cancelled Orders</h3>
                            <div class="font-bold">{{ $stats['cancelled_orders'] }}</div>
                        </a>

                        <a href="{{ route('admin.order.list', ['order_status' => 'failed']) }}"
                            class="bg-light flex justify-between items-center p-3 ">
                            <h3 class="font-bold">Failed Orders</h3>
                            <div class="font-bold">{{ $stats['failed_orders'] }}</div>
                        </a>


                        <a href="{{ route('admin.withdrawal.list', ['status' => 'pending']) }}"
                            class="bg-light flex justify-between items-center p-3 ">
                            <h3 class="font-bold">Pending Withdrawals</h3>
                            <div class="font-bold">{{ $stats['pending_withdrawals'] }}</div>
                        </a>

                        <a href="{{ route('admin.withdrawal.list', ['status' => 'delivered']) }}"
                            class="bg-light flex justify-between items-center p-3 ">
                            <h3 class="font-bold">Approved Withdrawals</h3>
                            <div class="font-bold">{{ $stats['approved_withdrawals'] }}</div>
                        </a>

                        <a href="{{ route('admin.withdrawal.list', ['status' => 'cancelled']) }}"
                            class="bg-light flex justify-between items-center p-3 ">
                            <h3 class="font-bold">Cancelled Withdrawals</h3>
                            <div class="font-bold">{{ $stats['cancelled_withdrawals'] }}</div>
                        </a> --}}
                    </section>

                    {{-- <section class="p-5 border rounded-xl min-h-[300px]">
                        <canvas id="myChart"></canvas>
                    </section> --}}


                </div>

            </div>

        </div>

    </main>
</div>

{{-- @push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sept',
        'Oct',
        'Nov',
        'Dec',
      ];

      const data = {
        labels: labels,
        datasets: [{
          label: 'Customers',
          backgroundColor: '#E3F49A',
          borderColor: '#E3F49A',
          data: @json($stats['customer_time_series_analysis']),
          lineTension: 0.4,
          radius: 3
        },
        {
          label: 'Sales',
          backgroundColor: '#DCD2EE',
          borderColor: '#DCD2EE',
          data: @json($stats['orders_time_series_analysis']),
          lineTension: 0.4,
          radius: 3
        }
        ]
      };

      const config = {
        type: 'line',
        data: data,
        options: {
            scales : {
                x :  {
                    grid : {
                        display : false
                    },
                    ticks : {
                        padding : 10,
                    }
                },
                y : {
                    grid : {
                        drawBorder: false
                    },
                    ticks : {
                        padding : 15,
                    }
                }
            },
             plugins: {
                legend: {
                display: true,
                align: 'end',
                labels: {
                    usePointStyle: true,
                    boxWidth: 6,
                    font: {
                        size: 12,
                        weight : 'bold'
                    }
                }
                },
                title: {
                    display: true,
                    position : 'top',
                    align : 'start',
                    padding : {
                        left : 0
                    },
                    text: 'Sales Analytics',
                    color : '#000',
                    font: {
                        size: 20,
                        weight : 'bold',
                    }
                },
                subtitle: {
                display: true,
                position : 'bottom',
                text: 'Sales made for year {{date('Y')}}'
            },

            }
        }
      };


      const ctx = document.getElementById('myChart');
      const myChart = new Chart(
        ctx,
        config,
      );

</script>
@endPush --}}
