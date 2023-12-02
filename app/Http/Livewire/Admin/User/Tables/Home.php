<?php

namespace App\Http\Livewire\Admin\User\Tables;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
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
        return User::role('normal');
    }


    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('created_at_formatted', function ($q) {
                return $q->createdAt();
            })
            ->addColumn('id');
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('SNO')
                ->field('id')
                ->index(),

            Column::add()
                ->title('Unique ID')
                ->field('unique_id')
                ->searchable()
                // ->makeInputText('email')
                ->sortable(),

            Column::add()
                ->title('First name')
                ->field('first_name')
                ->searchable()
                // ->makeInputText('first_name')
                ->sortable(),

            Column::add()
                ->title('Email')
                ->field('email')
                ->searchable()
                // ->makeInputText('email')
                ->sortable(),

            Column::add()
                ->title('Mobile Number')
                ->field('mobile_number1')
                ->searchable()
                // ->makeInputText('mobile_number')
                ->sortable(),

            Column::add()
                ->title('Date Joined')
                ->field('created_at_formatted', 'created_at')
                ->searchable()
                // ->makeInputText('referral_code')
                ->sortable()
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('first_name'),
            Filter::inputText('last_name'),
            Filter::inputText('email'),
            Filter::inputText('unique_id'),
            Filter::inputText('status'),
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
                ->caption("Show")
                ->class('bg-indigo-500 action-btn')
                ->route('admin.user.show', ['id' => 'id']),

            Button::add('edit')
                ->caption("Edit")
                ->class('bg-indigo-500 action-btn')
                ->route('admin.user.edit', ['id' => 'id']),

            Button::add('destroy')
                ->caption('Delete')
                ->class('bg-danger action-btn')
                ->dispatch('trigger-delete-modal', [
                    'id' => 'id',
                    'model' => User::class,
                    'title' => 'Are you sure?',
                    'message' => 'Are you sure you want to delete this User?'
                ]),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::button('edit')
                ->when(fn () => auth()->user()->cannot('edit_user'))
                ->hide(),

            Rule::button('destroy')
                ->when(fn () => auth()->user()->cannot('delete_user'))
                ->hide(),
        ];
    }
}
