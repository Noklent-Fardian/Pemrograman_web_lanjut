<?php

namespace App\DataTables;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BarangDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('kategori_kode', function ($row) {
                return $row->kategori->kategori_kode;
            })
            ->addColumn('kategori_nama', function ($row) {
                return $row->kategori->kategori_nama;
            })
            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex">
                    <a href="' . route('barang.edit', $row->barang_id) . '" class="btn btn-sm btn-primary d-flex align-items-center" style="margin-right: 5px; height: 100%;">
                    <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="' . route('barang.destroy', $row->barang_id) . '" method="POST">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah anda yakin akan menghapus item ini?\')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    </form>
                </div>';
            })
            ->addColumn('harga_formatted', function ($row) {
                return 'Rp ' . number_format($row->harga_jual, 0, ',', '.');
            })
            ->rawColumns(['action'])
            ->setRowId('barang_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Barang $model): QueryBuilder
    {
        return $model->newQuery()->with('kategori');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('barang-table')
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
            Column::make('barang_id'),
            Column::make('barang_kode'),
            Column::make('barang_nama'),
            Column::computed('kategori_kode'),
            Column::computed('kategori_nama'),
            Column::make('harga_beli'),
            Column::make('harga_jual'),
            Column::computed('harga_formatted')
                ->title('Harga Formatted')
                ->exportable(false),
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
        return 'Barang_' . date('YmdHis');
    }
}