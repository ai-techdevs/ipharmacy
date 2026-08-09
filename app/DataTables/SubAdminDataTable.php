<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubAdminDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<user> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.sub-admin.action')
             ->addColumn('role_name', function($user){
            return $user->role ? $user->role->display_name : '';
        })
            ->editColumn('created_at', function($q){
                return $q->created_at->format('d-m-Y H:i A');
            })
            ->editColumn('updated_at', function($q){
                return $q->updated_at->format('d-m-Y H:i A');
            })
            ->editColumn('status', function($q){
                $text = $q->status == 1 ? 'Active' : 'Disabled' ;
                $class = $q->status == 1 ? 'badge-success' : 'badge-danger' ;

                return '<span class="badge '.$class.'">'.$text.'</span>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
       return $model->newQuery()->where('role_id','<>',3)->select('users.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
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
            Column::make('name')->title('First Name'),
           // Column::make('last_name')->title('Last Name'),
            Column::make('email'),
            Column::make('mobile'),
             
            Column::make('role_name')->title("Role") ->orderable(false),
            Column::make('status'),
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
        return 'SubAdmin_' . date('YmdHis');
    }
}
