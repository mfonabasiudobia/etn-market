<section class="content-wrapper">
    <x-loading />

    <section class="flex justify-between items-center">
        <h1 class="title"><span class="capitalize">Transaction Details</h1>
        <nav class="flex items-center space-x-2">
            <a id="Previous Transaction"
                href="{{ $previousTransaction ? route('admin.transaction.show', ['id' => $previousTransaction->id]) : 'javascript:void(0)' }}"
                class="btn btn-primary btn-xs">
                <i class="las la-chevron-left"></i>
            </a>
            <a title="Next Transaction"
                href="{{ $nextTransaction ? route('admin.transaction.show', ['id' => $nextTransaction->id]) : 'javascript:void(0)' }}"
                class="btn btn-primary btn-xs">
                <i class="las la-chevron-right"></i>
            </a>
        </nav>
    </section>

    <section class="grid md:grid-cols-3 gap-5">
        <section class="md:col-span-2 rounded-lg border dark:border-gray-500 p-3 space-y-5">
            <header class="flex items-center justify-between">
                <section>
                    <h1 class="font-semibold text-xl">Transaction ID #{{ $transaction->trx }}</h1>
                    <div class="text-xs opacity-70">{{ $transaction->created_at->format('d M, Y h:i A') }}</div>
                </section>
            </header>

            <section class="grid  gap-5">
                <div>
                    {{-- <button class="btn btn-xs border border-primary dark:dark:border-gray-500">
                        <i class="las la-map-marker-alt"></i>
                        Show Location In Map
                    </button> --}}
                </div>

                <ul class="md:text-right text-sm space-y-2">
                    <li class="space-x-2">
                        <span>Transaction Status:</span>
                        @if ($transaction->status === 'pending')
                            <span class='bg-info text-white btn btn-xs'>Pending</span>
                        @elseif($transaction->order_status === 'failed')
                            <span class='bg-danger text-white btn btn-xs'>Failed</span>
                        @elseif($transaction->order_status === 'cancelled')
                            <span class='bg-warning text-white btn btn-xs'>Cancelled</span>
                        @elseif($transaction->order_status === 'completed')
                            <span class='bg-success text-white btn btn-xs'>Completed</span>
                        @else
                            <span class='bg-primary text-white btn btn-xs'>{{ $transaction->status }}</span>
                        @endIf
                    </li>
                </ul>

                <table>
                    <tbody>
                        <tr>
                            <td>Amount</td>
                            <td>{{ $transaction->amount }}</td>
                        </tr>
                        <tr>
                            <td>purpose</td>
                            <td>{{ $transaction->remark }}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{ $transaction->payment_method }}</td>
                        </tr>
                    </tbody>
                </table>


                <section class="space-y-3">
                    @foreach ($transaction->query1 ?? [] as $item)
                        <section class="border rounded p-3">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Market Name:</td>
                                        <td>{{ $item['market_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Period:</td>
                                        <td>{{ $item['payment_period'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Shops:</td>
                                        <td>
                                            <ul class="space-y-3">
                                                @foreach ($item['shops'] ?? [] as $shop)
                                                    <li>
                                                        <div>Shop Line: <span>{{ $shop['shop_line'] }}</span></div>
                                                        <div>Shop Number: <span>{{ $shop['shop_number'] }}</span></div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    @endforeach
                </section>

            </section>

        </section>

        <section class="space-y-5">

            <div class="space-y-2 p-3 rounded-lg border dark:border-gray-500">
                <h2 class="font-semibold">Change Transaction Status</h2>

                <select class="form-control" wire:model="status">
                    <option value="">--Select Status--</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="space-y-2 p-3 rounded-lg border dark:border-gray-500">
                <h2 class="font-semibold">
                    <i class="las la-user"></i>
                    <span>Customer Information</span>
                </h2>

                <div class="flex items-center justify-start space-x-2">
                    <img src="{{ asset('images/profile.png') }}" alt="">
                    <ul class="text-xs space-y-2">
                        <li class="font-semibold">
                            {{ $transaction->user->first_name }}
                            {{ $transaction->user->last_name }} -
                            #{{ $transaction->user->unique_id }}
                        </li>
                        {{-- <li>
                            <span class="font-semibold">{{ $transaction->user->orders->count() }}</span> Transactions
                        </li> --}}
                        <li class="font-light">
                            <i class="las la-phone"></i>
                            <a
                                href="tel:{{ $transaction->user->mobile_number1 }}">{{ $transaction->user->mobile_number1 }}</a>
                        </li>
                        <li class="font-light flex space-x-2 items-center">
                            <i class="las la-envelope"></i>
                            <a href="mailto:{{ $transaction->user->email }}">{{ $transaction->user->email }}</a>
                        </li>
                    </ul>
                </div>
            </div>

        </section>



    </section>
