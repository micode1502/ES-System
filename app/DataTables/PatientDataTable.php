<?php

namespace App\DataTables;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Gate;

class PatientDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->escapeColumns('active')
            ->addColumn('options', function ($row) {
                $action = '';
                if (auth()->user()->can('patient-edit')) {
                    $action .= '<button data-action="edit" data-id="' . $row->id . '" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded-lg mr-2 action"><i class="fas fa-edit"></i></button>';
                }
                if (auth()->user()->can('patient-delete')) {
                    $action .= '<button data-action="delete" data-id="' . $row->id . '" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded-lg action"><i class="fas fa-trash"></i></button>';
                }
                return $action;
            })
            ->addColumn('type_document', function ($row) {
                return $row->type_document ? "DNI": __('Passport');
            })
            ->addColumn('gender', function ($row) {
                return $row->type_document ? __('Female'): __('Male');
            })
            ->addColumn('date_birth', function ($row) {
                return date('d/m/Y', strtotime($row->date_birth));
            })
            ->addColumn('status', function ($row) {
                return $row->status ? __('Served') : __('Unattended');
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Patient $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('table-list')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            /*
                    ->buttons(
                        Button::make('copy'),
                        Button::make('csv'),
                        Button::make('excel'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('colvis')
                    )*/
            ->parameters(([
                /* 'language' => ['url' => '/assets/i18n/es-ES.json'] */
                'language' => session('lang') === 'es' ? ['url' => '/assets/datatable/lang/es-ES.json'] : []
            ]));
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name')->title(__('Names')),
            Column::make('lastname')->title(__('Lastname')),
            Column::make('email')->title(__('Email')),
            Column::make('phone')->title(__('Phone')),
            Column::make('type_document')->title(__('D. Type')),
            Column::make('document')->title(__('Document')),
            Column::make('date_birth')->title(__('Birthdate')),
            Column::make('gender')->title(__('Gender')),
            //Column::make('address')->title(__('Address')),
            Column::make('status')->title(__('Status')),
            Column::computed('options')
                ->exportable(false)
                ->printable(false)
                ->title(__('Opciones')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Patient_' . date('YmdHis');
    }
}
