<?php

namespace App\DataTables;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DonationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Donation> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'admin.donation.action')
            ->addColumn('action', function ($donation) {
                return view('admin.donation.action', compact('donation'))->render();
            })
            ->editColumn('payment_status', function ($query) {
                switch ($query->payment_status) {
                    case 'success':
                        $text = 'Success';
                        $class = 'badge-success';
                        break;

                    case 'pending':
                        $text = 'Pending';
                        $class = 'badge-warning';
                        break;

                    case 'failed':
                        $text = 'Failed';
                        $class = 'badge-danger';
                        break;

                    default:
                        $text = ucfirst($query->payment_status ?? 'Unknown');
                        $class = 'badge-secondary';
                        break;
                }

                return '<span class="badge ' . $class . '">' . $text . '</span>';
            })
            ->editColumn('subscription_id', function ($query) {

                if ($query->payment_method === 'paypal') {

                    $subscription = $query->subscription?->subscription_gateway_id ?? 'NA';
                    return $subscription;
                } else {

                    return $query->subscription_id ?? 'N/A';
                }
            })
            ->editColumn('subscription_status', function ($query) {

                if ($query->payment_method === 'paypal') {

                    $subscription = $query->subscription?->status ?? 'NA';
                    return strtoupper($subscription);
                } else {

                    return strtoupper($query->subscription_status) ?? 'N/A';
                }
            })
            ->editColumn('created_at', function ($query) {
                return \Carbon\Carbon::parse($query->created_at)->format('jS F, Y h:i A');
            })
            ->addColumn('invoice_sent', function ($query) {
                if ($query->invoice_sent == 1) {
                    return '<i class="fas fa-check text-success"></i>';
                } else {
                    return '<i class="fas fa-times text-danger"></i>';
                }
            })
            ->rawColumns(['action', 'payment_status', 'created_at', 'invoice_sent']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Donation>
     */
    public function query(Donation $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('donation-table')
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


            Column::make('name')->title('Donor Name'),
            Column::make('email')->title('Donor Email'),
            Column::make('phone')->title('Donor Phone'),
            Column::make('amount'),
            Column::make('donation_type'),
            Column::make('payment_method'),
            Column::make('payment_status'),
            Column::make('transaction_id'),
            Column::make('subscription_id'),
              Column::make('subscription_status'),
            Column::make('created_at'),
            Column::make('invoice_sent'),
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
        return 'Donation_' . date('YmdHis');
    }
}
