@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.transaction.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">

        <div class="d-flex justify-content-end">
            {!! $transactions->links() !!}
        </div>

        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Transaction">
                <thead>
                    <tr>
                        <th> Id </th>
                        <th> Eszköz </th>
                        <th> Beszállító </th>
                        <th> Raktár </th>
                        <th> Munkaállomás </th>
                        <th> Mennyiség </th>
                        <th> Művelet </th>
                        <th> Orvos </th>
                        <th> Készítő </th>
                        <th> Dátum </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('company')->transactions as $transaction)
                        <tr data-entry-id="{{ $transaction->id }}">
                            <td> {{ $transaction->id ?? '' }}</td>
                            <td> {{ $transaction->asset->name ?? '' }} </td>
                            <td> {{ $transaction->importer->name ?? ''}}</td>
                            <td> {{ $transaction->team->name ?? ''}}</td>
                            <td> {{ $transaction->chair->name ?? '' }}</td>
                            <td> {{ $transaction->stock ?? '' }} {{ $transaction->asset->unit->name ?? '' }} </td>
                            <td> {{ $transaction->action->name ?? ''}}</td>
                            <td> {{ $transaction->doctor->name ?? '' }}</td>
                            <td> {{ $transaction->user->name ?? '' }} </td>
                            <td> {{ $transaction->created_at ?? '' }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mb-5">
            {!! $transactions->links() !!}
        </div>

    </div>
</div>



@endsection

@section('scripts')
@parent
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    $.extend(true, $.fn.dataTable.defaults, {
        order: [[ 0, 'desc' ]],
        pageLength: 100,
        columnDefs: [{
          orderable: true,
          className: '',
          targets: 0
      }]
    });

    $('.datatable-Transaction:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
    });

})
</script>
@endsection
