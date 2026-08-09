<?php

namespace App\DataTables;

use App\Models\CdcComment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CdcCommentDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<CdcComment> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.cdc.comment_action')
            ->editColumn('created_at', fn($query) => \Carbon\Carbon::parse($query->created_at)->format('jS M, Y') ?? "")
            ->editColumn('name', function ($query) {
                return $query->name;
            })
            ->editColumn('email', function ($query) {
                return $query->email;
            })
            ->editColumn('message', function ($query) {
                return \Str::limit(strip_tags($query->message), 50);
            })
            ->editColumn('website', function ($query) {
                return $query->website ?? '';
            })
            ->editColumn('status', function ($query) {
                $text = $query->status == 1 ? 'Active' : 'Disabled';
                $class = $query->status == 1 ? 'badge-success' : 'badge-danger';

                return '<span class="badge ' . $class . '">' . $text . '</span>';
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<CdcComment>
     */
    public function query(CdcComment $model): QueryBuilder
    {
        return $model->newQuery()->where('cdc_id', $this->cdc_id)->select(["cdc_comments.*"]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('cdccomment-table')
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
            Column::make('id')->visible(false),
            Column::make('name'),
            Column::make('email'),
            Column::make('message'),
            Column::make('website'),
            Column::make('created_at'),
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CdcComment_' . date('YmdHis');
    }
}
