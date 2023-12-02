<?php

namespace App\Http\Livewire\Admin\Transaction\Tables;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class Home extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */

    public $status, $user_id, $remark;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Transaction::query()
            ->latest()
            ->when($this->status != 'all', function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->remark, function ($q) {
                $q->where('remark', $this->remark);
            })
            ->when($this->user_id, function ($q) {
                $q->where('user_id', $this->user_id);
            });
    }


    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('formatted_date', function (Transaction $model) {
                return $model->created_at->format("d M, Y h:i A");
            })
            ->addColumn('amount_formatted', function (Transaction $model) {
                return ac() . number_format($model->amount);
            })
            ->addColumn('status_formatted', function (Transaction $model) {
                if ($model->status === "pending") {
                    return "<span class='bg-info text-white btn btn-xs'>Pending</span>";
                } else if ($model->status === "failed") {
                    return "<span class='bg-danger text-white btn btn-xs'>Failed</span>";
                } else if ($model->status === "cancelled") {
                    return "<span class='bg-warning text-white btn btn-xs'>Cancelled</span>";
                } else if ($model->status === "completed") {
                    return "<span class='bg-success text-white btn btn-xs'>Delivered</span>";
                } else {
                    return "<span class='bg-primary text-white btn btn-xs'>{$model->status}</span>";
                }
            })
            ->addColumn('customer_information', function (Transaction $model) {
                return "<strong>{$model->user->first_name} {$model->user->last_name}</strong><br />
                        <span>{$model->user->mobile_number}</span>";
            });
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('SNO')
                ->field('id')
                ->index(),

            Column::add()
                ->title('Transaction ID')
                ->field('trx')
                ->searchable()
                // ->makeInputText('id')
                ->sortable(),

            Column::add()
                ->title('Customer Information')
                ->field('customer_information')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Amount')
                ->field('amount_formatted')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Charge')
                ->field('charge')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Status')
                ->field('status_formatted')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Remark')
                ->field('remark')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Transaction Details')
                ->field('details')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Transaction Date')
                ->field('formatted_date')
                ->searchable()
                ->sortable(),
        ];
    }


    public function filters(): array
    {
        return [
            Filter::inputText('amount'),
            Filter::inputText('status'),
            Filter::inputText('trx'),
            Filter::inputText('remark')
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid User Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        return [
            Button::add('show')
                ->caption("View Transaction Details")
                ->class('bg-indigo-500 action-btn')
                ->route('admin.transaction.show', ['id' => 'id']),

            Button::add('destroy')
                ->caption('Delete')
                ->class('bg-danger action-btn')
                ->dispatch('trigger-delete-modal', [
                    'id' => 'id',
                    'model' => Transaction::class,
                    'title' => 'Are you sure?',
                    'message' => 'Are you sure you want to delete this Transaction?'
                ]),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::button('show')
                ->when(fn ($model) => in_array($model->remark, ['WITHDRAWAL_REQUEST']))
                ->hide(),

            Rule::button('destroy')
                ->when(fn () => auth()->user()->cannot('delete_orders'))
                ->hide(),
        ];
    }
}
