<?php

namespace App\Http\Livewire\User\Step2;

use App\Http\Livewire\BaseComponent;
use App\Repositories\MarketRepository;
use App\Repositories\ShopRepository;
use App\Models\Market;
use App\Models\Shop;
use Paystack;
use Carbon\Carbon;
use DB;

class Home extends BaseComponent
{
    public $market = 'A';

    public $markets = [], $names = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $payment_method = 'online';

    public function mount()
    {
        $this->getMarkets();
    }

    public function getMarkets()
    {
        $markets = Market::with(['shops'])->where('user_id', auth()->id())->get();

        foreach ($markets as $key => $market) {
            $this->names[$market->id] = $market->name;

            $shops = $market->shops()->get(['shop_line', 'shop_number', 'id'])->toArray();

            if (count($shops) == 0) {
                $this->markets[$market->id] = [
                    'shops' => [
                        [
                            'shop_line' => '',
                            'shop_number' => ''
                        ]
                    ],
                    'start_date' => '',
                    'end_date' => '',
                    'is_selected' => 0 //1 means selected
                ];
            } else {
                $this->markets[$market->id] =  [
                    'shops' => $shops,
                    'start_date' => '',
                    'end_date' => '',
                    'is_selected' => 0 //1 means selected
                ];
            }
        }
    }

    public function addMarket()
    {
        $this->validate([
            'market' => 'required'
        ]);

        try {
            $data = [
                'name' => $this->market,
                'user_id' => auth()->id()
            ];

            throw_unless($market = MarketRepository::createMarket($data), 'An error occured');

            toast()->success("Market Added")->push();

            $this->names[$market->id] = $market->name;
            $this->markets[$market->id] =  [
                'shops' => [
                    [
                        'shop_line' => '',
                        'shop_number' => ''
                    ]
                ],
                'start_date' => '',
                'end_date' => '',
                'is_selected' => 0 //1 means selected
            ];

            $this->emit('refreshComponent');
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }


    public function submit()
    {
        try {
            DB::beginTransaction();

            $total = 0;
            $isItemSelected = false;
            $query1 = [];

            foreach ($this->markets as $key1 => $market) {
                $safeIds = array_column($market['shops'], 'id');
                $startDate = Carbon::parse($market['start_date']);
                $endDate = Carbon::parse($market['end_date']);
                $totalMonths = $endDate->diffInMonths($startDate) + 1;
                $isSelected = $market['is_selected'];
                $model = Market::find($key1);

                if ($isSelected) {
                    $isItemSelected = true;

                    $query1[$model->id] = [
                        'market_name' => $model->name,
                        'payment_period' => $market['start_date'] . " to " . $market['end_date'],
                    ];
                    //Validate Date for selected market
                    throw_if(strlen($market['start_date']) == 0, "Invalid Start Date for selected market");
                    throw_if(strlen($market['end_date']) == 0, "Invalid End Date for selected market");
                }


                throw_if($endDate < $startDate, "End Date cannot be less than start Date");

                Shop::whereNotIn('id', $safeIds)->where('market_id', $key1)->delete(); //delete out Ids not found
                foreach ($market['shops'] as $key2 => $shop) {
                    if ($isSelected) {
                        throw_if(strlen($shop['shop_number']) === 0, "Please select your shop number to proceed");
                        throw_if(strlen($shop['shop_line']) === 0, "Please select your shop line to proceed");

                        Shop::updateOrCreate([
                            'id' => $shop['id'] ?? null,
                            'market_id' => $key1
                        ], [
                            'shop_number' => $shop['shop_number'],
                            'shop_line' => $shop['shop_line']
                        ]);

                        $query1[$model->id]['shops'][] = [
                            'shop_number' => $shop['shop_number'],
                            'shop_line' => $shop['shop_line']
                        ];


                        $total += gs()->subscription_amount * $totalMonths;
                    }
                }
            }

            throw_unless($isItemSelected, 'Please select at least 1 market to proceed');

            throw_if($total == 0, 'Invalid Amount');


            $transaction = save_transaction([
                'user_id' => auth()->id(),
                'amount' => $total,
                'trx' => getTrx(),
                'discount_amount' =>  0,
                'charge' => 0,
                'type' => "-",
                'details' => "Payment Subscription",
                'remark' => 'SUBSCRIPTION',
                'query1' => $query1
            ]);

            $data = array(
                "amount" => $total * 100,
                "reference" => $transaction->trx,
                "email" => auth()->user()->email,
                "currency" => "NGN",
                'metadata' => [
                    'trx' => $transaction->trx,
                    "cancel_action" => route('user.dashboard', ['status' => 'cancelled'])
                ],
                'callback_url' => route('user.transaction.list')
            );

            DB::commit();

            if ($this->payment_method === 'office') {
                return redirect()->route('user.transaction.list');
            }

            return Paystack::getAuthorizationUrl($data)->redirectNow();
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
            DB::rollback();
        }
    }



    public function render()
    {
        return view('livewire.user.step2.home', [])->layout('layouts.user-base');
    }
}
