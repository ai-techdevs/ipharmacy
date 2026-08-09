@push('third_party_stylesheets')
    @include('admin.layouts.datatables_css')
@endpush

<div class="card-body px-4">
    <div class="table-responsive">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-sm']) !!}
    </div>
</div>

@push('third_party_scripts')
    @include('admin.layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
