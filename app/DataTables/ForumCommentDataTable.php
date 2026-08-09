<?php

namespace App\DataTables;

use App\Models\Forum;
use App\Models\ForumComment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ForumCommentDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.forums.comment_action')
            ->editColumn('created_at', fn($query)=> \Carbon\Carbon::parse($query->created_at)->format('jS M, Y') ?? "")
            ->editColumn('description', function ($query) {
                return \Str::limit(strip_tags($query->description), 50);
            })
            ->editColumn('status', function($query){
                $text = $query->status == 1 ? 'Active' : 'Disabled' ;
                $class = $query->status == 1 ? 'badge-success' : 'badge-danger' ;

                return '<span class="badge '.$class.'">'.$text.'</span>';
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ForumComment $model): QueryBuilder
    {

        return $model->newQuery()->with(['user'])->where('forum_id', $this->forum_id)->select(["forum_comments.*"]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('forum-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0, "desc")
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
            Column::make('user.name'),
            Column::make('comment'),
            Column::make('created_at'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'cdcs_' . date('YmdHis');
    }
}
