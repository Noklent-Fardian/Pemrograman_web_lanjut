<?php

namespace App\DataTables;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StockDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('barang_kode', function ($row) {
                return $row->barang->barang_kode;
            })
            ->addColumn('barang_nama', function ($row) {
                return $row->barang->barang_nama;
            })
            ->addColumn('username', function ($row) {
                return $row->user->username;
            })
            ->addColumn('nama', function ($row) {
                return $row->user->nama;
            })
            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex">
                    <a href="' . route('stock.edit', $row->stock_id) . '" class="btn btn-sm btn-primary d-flex align-items-center" style="margin-right: 5px; height: 100%;">
                    <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="' . route('stock.destroy', $row->stock_id) . '" method="POST">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah anda yakin akan menghapus item ini?\')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    </form>
                </div>';
            })
            ->rawColumns(['action'])
            ->setRowId('stock_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Stock $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['barang', 'user']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('stock-table')
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
            Column::make('stock_id'),
            Column::computed('barang_kode'),
            Column::computed('barang_nama'),
            Column::computed('username'),
            Column::computed('nama'),
            Column::make('stok_tanggal_masuk'),
            Column::make('stok_jumlah'),
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
        return 'Stock_' . date('YmdHis');
    }
}