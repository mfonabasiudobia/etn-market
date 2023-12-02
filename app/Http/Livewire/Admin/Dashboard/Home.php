<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Http\Livewire\BaseComponent;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Shop;
use App\Models\Market;
use App\Helpers\Statistics;

class Home extends BaseComponent
{

    public $currentStats = "all", $stats;

    public function mount()
    {
        $this->updatedCurrentStats();
    }

    public function updatedCurrentStats()
    {
        $this->stats['total_revenue'] = Statistics::computeStats(Transaction::completed(), $this->currentStats)->sum('amount');
        $this->stats['total_customers'] = Statistics::computeStats(User::role('normal'), $this->currentStats)->count();
        $this->stats['total_transactions'] = Statistics::computeStats(Transaction::query(), $this->currentStats)->count();


        // $this->stats['total_active_investments'] = Statistics::computeStats(UserInvestment::active(),$this->currentStats)->sum('amount_invested');
        // $this->stats['total_inactive_investments'] = Statistics::computeStats(UserInvestment::inActive(),$this->currentStats)->sum('amount_invested');

        // $this->stats['total_orders'] = Statistics::computeStats(Order::query(), $this->currentStats)->count();
        // $this->stats['pending_orders'] = Statistics::computeStats(Order::pending(), $this->currentStats)->count();
        // $this->stats['delivered_orders'] = Statistics::computeStats(Order::delivered(), $this->currentStats)->count();
        // $this->stats['cancelled_orders'] = Statistics::computeStats(Order::cancelled(), $this->currentStats)->count();

        // $this->stats['total_withdrawals'] = Statistics::computeStats(Withdrawal::query(), $this->currentStats)->count();
        // $this->stats['pending_withdrawals'] = Statistics::computeStats(Withdrawal::pending(), $this->currentStats)->count();
        // $this->stats['approved_withdrawals'] = Statistics::computeStats(Withdrawal::approved(), $this->currentStats)->count();
        // $this->stats['cancelled_withdrawals'] = Statistics::computeStats(Withdrawal::cancelled(), $this->currentStats)->count();


        // $this->stats['failed_orders'] = Statistics::computeStats(Order::failed(), $this->currentStats)->count();
        // $this->stats['customer_time_series_analysis'] = [];

        // //Statistics::getSumByMonthInAYear(User::query(),$this->currentStats,'total_amount');
        // $this->stats['orders_time_series_analysis'] = Statistics::getTotalByMonthInAYear(Order::query(),$this->currentStats);
        // $this->stats['customer_time_series_analysis'] = Statistics::getTotalByMonthInAYear(User::query(),$this->currentStats);

        $this->dispatchBrowserEvent('showgraph');
    }


    public function render()
    {
        return view('livewire.admin.dashboard.home')->layout('layouts.admin-base');
    }
}
