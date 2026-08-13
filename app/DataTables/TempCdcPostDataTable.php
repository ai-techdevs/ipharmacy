<?php

namespace App\DataTables;

use App\Models\TempCdcPost;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class TempCdcPostDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.temp_cdc_posts.action')
            ->editColumn('created_at', fn($query)=> $query->created_at ? \Carbon\Carbon::parse($query->created_at)->format('jS M, Y H:i:s') : "")
            ->editColumn('description', function ($query) {
                return \Str::limit(strip_tags($query->description), 50);
            })
            ->editColumn('status', function($query){
                $text = $query->status == 1 ? 'Active' : 'Disabled';
                $class = $query->status == 1 ? 'badge-success' : 'badge-danger';
                
                return '<span class="badge '.$class.'">'.$text.'</span>';
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(TempCdcPost $model): QueryBuilder
    {
        return $model->newQuery()->select(["temp_cdc_posts.*"]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('temp-cdc-post-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(4, "desc") // Sort by created_at (index 4)
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
            Column::make('id')->visible(false),
            Column::make('title'),
            Column::make('author'),
            Column::make('status'),
            Column::make('created_at')->title('Fetched Date & Time'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(120)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'temp_cdc_posts_' . date('YmdHis');
    }
}
