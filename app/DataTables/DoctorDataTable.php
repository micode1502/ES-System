<?php

namespace App\DataTables;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Gate;

class DoctorDataTable extends DataTable
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
                if (auth()->user()->can('doctor-edit')) {
                    $action .= '<button data-action="edit" data-id="' . $row->id . '" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded-lg mr-2 action"><i class="fas fa-edit"></i></button>';
                }
                if (auth()->user()->can('doctor-delete')) { 
                    $action .= '<button data-action="delete" data-id="' . $row->id . '" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded-lg action"><i class="fas fa-trash"></i></button>';
                }
                return $action;
            })
            ->addColumn('type_document', function ($row) {
                return $row->type_document ? "DNI": __('Passport');
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Doctor $model): QueryBuilder
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
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('name')->title('Nombre'),
            Column::make('lastname')->title('Apellido'),
            Column::make('specialty')->title('Especialidad'),
            Column::make('type_document')->title('Tipo de Documento'),
            Column::make('document')->title('Número de Documento'),
            Column::make('phone')->title('Teléfono'),
            Column::make('email')->title('Correo'),
            Column::make('address')->title('Dirección'),
            Column::computed('options')->title(__('Opciones'))->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Doctor_' . date('YmdHis');
    }
}
