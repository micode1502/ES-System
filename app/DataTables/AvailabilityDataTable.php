<?php

namespace App\DataTables;

use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AvailabilityDataTable extends DataTable
{
    protected $daysOfWeek = [
        1 => 'Domingo',
        2 => 'Lunes',
        3 => 'Martes',
        4 => 'Miercoles',
        5 => 'Jueves',
        6 => 'Viernes',
        7 => 'Sabado',
    ];
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
                if (auth()->user()->can('availability-edit')) {
                    $action .= '<button data-action="edit" data-id="' . $row->id . '" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded-lg mr-2 action"><i class="fas fa-edit"></i></button>';
                }
                if (auth()->user()->can('availability-delete')) { 
                    $action .= '<button data-action="delete" data-id="' . $row->id . '" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded-lg action"><i class="fas fa-trash"></i></button>';
                }
                return $action;
            })
            ->addColumn('doctor_id', function ($row) {
                $doctor = Doctor::find($row->doctor_id);
                return $doctor->name;
            })
            ->addColumn('day_name', function ($row) {
                return $this->daysOfWeek[$row->day];
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Availability $model): QueryBuilder
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
            Column::make('id')->title('ID'),
            Column::make('doctor_id')->title('Doctor'),
            Column::make('day_name')->title('Dia'),
            Column::make('hour_start')->title('Hora Inicio'),
            Column::make('duration')->title('Duración'),
            Column::make('options')->title(__('Opciones'))->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Availability_' . date('YmdHis');
    }
}