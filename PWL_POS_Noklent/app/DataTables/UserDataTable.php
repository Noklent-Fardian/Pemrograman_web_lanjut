<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('level_kode', function ($row) {
                return $row->level->level_kode;
            })
            ->addColumn('level_nama', function ($row) {
                return $row->level->level_nama;
            })
            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex">
                    <a href="' . url('/user/ubah/' . $row->user_id) . '" class="btn btn-sm btn-primary d-flex align-items-center" style="margin-right: 5px; height: 100%;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="' . url('/user/hapus/' . $row->user_id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah anda yakin akan menghapus user ini?\')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </div>';
            })
            ->rawColumns(['action'])
            ->setRowId('user_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with('level');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
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
            Column::make('user_id'),
            Column::make('username'),
            Column::make('nama'),
            Column::make('level_id'),
            Column::computed('level_kode'),
            Column::computed('level_nama'),
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
        return 'User_' . date('YmdHis');
    }
}