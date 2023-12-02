<section class="space-y-5">
    <section class="flex justify-between items-center">
        <h1 class="title">Markets</h1>
    </section>

    <section class="space-y-5">

        <form class="grid grid-cols-3 gap-5 bg-white p-5" wire:submit.prevent="addMarket">

            <div class="flex space-x-2">

                <select wire:model.defer='market' class="form-control">
                    @foreach (range('A', 'Z') as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>

                <x-atoms.loading-button text="Add market" target="addMarket"
                    class="btn btn-lg btn-primary btn-rounded whitespace-nowrap" />

            </div>

        </form>


        <form x-data="{ markets: @entangle('markets').defer, names: @entangle('names').defer }" wire:submit.prevent='submit'>

            <div class="space-y-5" wire:ignore>
                <template x-for="(market, key1) in markets" :key="key1">
                    <section class="p-5 border rounded-lg bg-white space-y-5 relative">
                        <h3 x-text="names[key1]"></h3>

                        <button class="absolute top-0 right-5 btn btn-sm text-white"
                            x-on:click.prevent="markets[key1]['is_selected'] = !markets[key1]['is_selected']"
                            :class="markets[key1]['is_selected'] == 1 ? 'bg-success' : 'bg-primary'"
                            x-text="markets[key1]['is_selected'] == 1 ? 'Selected' : 'Select Market'">

                        </button>

                        <section class="grid grid-cols-4">
                            <section class="col-span-3 space-y-5">
                                <template x-for="(shop, key2) in market.shops" :key="key2">
                                    <section class="col-span-3 grid grid-cols-5 gap-5">
                                        <div class="form-group col-span-2">
                                            <label>Shop
                                                Line</label>
                                            <select x-model="markets[key1]['shops'][key2]['shop_line']"
                                                class="form-control">
                                                <option>Select from A - Z</option>
                                                <template x-for="letter in 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'">
                                                    <option x-bind:value="letter" x-text="letter"
                                                        x-bind:selected="letter == markets[key1]['shops'][key2]['shop_line']">
                                                    </option>
                                                </template>
                                            </select>
                                        </div>

                                        <div class="form-group col-span-2">
                                            <label>Shop Number</label>
                                            <select x-model="markets[key1]['shops'][key2].shop_number"
                                                class="form-control">
                                                <option>Select from 0001 - 5000</option>
                                                <template
                                                    x-for="item in Array.from({ length: 1000 }, (_, i) => String(i + 1).padStart(4, '0'))">
                                                    <option x-bind:value="item" x-text="item"
                                                        x-bind:selected="item == markets[key1]['shops'][key2]['shop_number']">
                                                    </option>
                                                </template>
                                            </select>
                                        </div>

                                        <div class="flex items-center">
                                            <button x-on:click.prevent="markets[key1]['shops'].splice(key2, 1)">
                                                <i class="las la-trash text-danger text-2xl"></i>
                                            </button>
                                        </div>
                                    </section>
                                </template>
                            </section>


                            <section class="space-y-2 py-5">
                                <h3><strong>Payment Period</strong></h3>

                                <div class="form-group" wire:ignore>
                                    <label>Start Date</label>
                                    <input type="month" placeholder="Start Date" x-model="markets[key1]['start_date']"
                                        class="form-control" />
                                </div>

                                <div class="form-group" wire:ignore.self>
                                    <label>End Date</label>
                                    <input type="month" placeholder="End Date" x-model="markets[key1]['end_date']"
                                        class="form-control" />
                                </div>

                                <div class="form-group" wire:ignore.self>
                                    <ul>
                                        <li>Total Stores: <span x-text='market.shops.length'></span></li>
                                        <li>Total Months:
                                            <span
                                                x-text="() => {
                                                let result = (new Date(markets[key1]['end_date'] + '-01') - new Date(markets[key1]['start_date'] + '-01')) / (1000 * 60 * 60 * 24 * 30) + 1;

                                                return result < 1 ? 0 : Math.floor(result)
                                            }"></span>
                                        </li>
                                        <li>Total: ₦<span
                                                x-text="() => {
                                            let result = (new Date(markets[key1]['end_date'] + '-01') - new Date(markets[key1]['start_date'] + '-01')) / (1000 * 60 * 60 * 24 * 30) + 1;

                                            result = result < 1 ? 0 : Math.floor(result)

                                           return market.shops.length * {{ gs()->subscription_amount }} * result
                                        }">0</span>
                                        </li>
                                    </ul>
                                </div>

                            </section>
                        </section>

                        <div class="form-group col-span-3">
                            <button
                                x-on:click.prevent="markets[key1]['shops'].push({ shop_line: 'A', shop_number: '0001' })">
                                Add more shops under this market
                            </button>
                        </div>
                    </section>
                </template>
            </div>


            <div class="form-group md:col-span-3 py-5 flex justify-between">
                <a href="{{ route('user.dashboard') }}" class="btn btn-lg btn-primary btn-rounded">Back</a>

                <section class="space-y-3 flex flex-col justify-center">

                    <section class="flex items-center space-x-5">
                        <div>
                            <input type="radio" value="office" id="office" wire:model.defer='payment_method'
                                name="payment_method" />
                            <label for="office">Cash payment or Pay at the office</label>
                        </div>

                        <div>
                            <input type="radio" value="online" id="online" wire:model.defer='payment_method'
                                name="payment_method" />
                            <label for="online">Online Payment</label>
                        </div>
                    </section>

                    <x-atoms.loading-button text="Submit & Proceed to make Payment" target="submit"
                        class="btn btn-lg btn-primary btn-rounded" />
                </section>
            </div>
        </form>
    </section>

</section>
