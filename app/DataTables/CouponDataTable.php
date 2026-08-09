<?php

namespace App\DataTables;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CouponDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<coupon> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.coupon.action')
            ->editColumn('discount', fn($coupon) => "<span class='badge bg-success'>{$coupon->discount}</span>")
            ->editColumn('image', function ($coupon) {
                return $coupon->image
                    ? '<img src="' . asset('storage/'.$coupon->image) . '" width="60" height="60" style="object-fit:cover; border-radius:6px;">'
                    : '<img src="' . url('assets/images/coupons-right-img.png') . '" width="60" height="60" style="object-fit:cover; border-radius:6px;">';
            })
            ->editColumn('status', function($query){
                $text = $query->status == 1 ? 'Active' : 'Disabled' ;
                $class = $query->status == 1 ? 'badge-success' : 'badge-danger' ;

                return '<span class="badge '.$class.'">'.$text.'</span>';
            })
            ->editColumn('created_at', function ($coupon) {
    return $coupon->created_at
        ? $coupon->created_at->format('jS F, Y') // 22nd September, 2025
        : '-';
})
            ->rawColumns(['discount', 'image', 'action','status']) ;// allow HTML
            // ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<coupon>
     */
    public function query(Coupon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('coupon-table')
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
          


            Column::make('discount')->title('Discount'),
            Column::make('title')->title('Title'),
            Column::make('description')->title('Description'),
            // Column::make('button_text')->title('Button Text'),
            // Column::make('button_link')->title('Button Link'),
            Column::make('image')->title('Image'),
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
        return 'coupon_' . date('YmdHis');
    }
}
