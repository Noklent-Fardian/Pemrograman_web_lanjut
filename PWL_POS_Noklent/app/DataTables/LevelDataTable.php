<?php

namespace App\DataTables;

use App\Models\Level;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LevelDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex">
                    <a href="' . url('/level/ubah/' . $row->level_id) . '" class="btn btn-sm btn-primary d-flex align-items-center" style="margin-right: 5px; height: 100%;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="' . url('/level/hapus/' . $row->level_id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah anda yakin akan menghapus item ini?\')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </div>';
            })
            ->rawColumns(['action'])
            ->setRowId('level_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Level $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('level-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('level_id'),
            Column::make('level_kode'),
            Column::make('level_nama'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Level_' . date('YmdHis');
    }
}