<?php

namespace App\DataTables;

use App\Models\Payment;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class paymentDataTable extends DataTable
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
                if (auth()->user()->can('payment-print')) {
                    $action .= '<button data-action="print" data-id="' . $row->id . '" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-2 rounded-lg mr-2 action"><i class="fas fa-print"></i></button>';
                }
                if (auth()->user()->can('payment-edit')) {
                    $action .= '<button data-action="edit" data-id="' . $row->id . '" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded-lg mr-2 action"><i class="fas fa-edit"></i></button>';
                }
                if (auth()->user()->can('payment-delete')) { 
                    $action .= '<button data-action="delete" data-id="' . $row->id . '" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded-lg action"><i class="fas fa-trash"></i></button>';
                }
                return $action;
            })
            ->addColumn('patient_id', function ($row) {
                $patient = Patient::find($row->patient_id);
                return $patient->name;
            });;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Payment $model): QueryBuilder
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
            ->orderBy(1)
            ->parameters([
                // Aquí puedes establecer parámetros adicionales de DataTables si es necesario
                'language' => session('lang') === 'es' ? ['url' => '/assets/datatable/lang/es-ES.json'] : []
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('patient_id')->title('Paciente'),
            Column::make('city')->title('Ciudad'),
            Column::make('state')->title('Estado'),
            Column::make('postal_code')->title('Código postal'),
            Column::make('payment_method')->title('Metodo de pago'),
            Column::make('amount')->title('Monto'),
            Column::make('options')->title(__('Opciones'))->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Payment_' . date('YmdHis');
    }
}
