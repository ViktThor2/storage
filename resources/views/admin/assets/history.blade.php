@extends('layouts.admin')
@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.assets.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.asset.title_singular') }} élettörténet
    </div>

    <div class="card-body mb-5">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Asset">
                <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th width="20%">Felhasználó</th>
                        <th>Beszállító</th>
                        <th>Rendelő</th>
                        <th>Munkaállomás</th>
                        <th>Művelet</th>
                        <th>Mennyiség</th>
                        <th>Dátum</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($asset->transactions as $transaction)
                        <tr data-entry-id="{{$transaction->id}}">
                            <td></td>
                            <td>{{ $transaction->id }}</td>
                            <td>
                                {{ $transaction->user->name ?? ''}}
                                ({{ $transaction->user->email ?? ''}})
                            </td>
                            <td>{{ $transaction->importer->name ?? ''}}</td>
                            <td>{{ $transaction->team->name ?? ''}}</td>
                            <td>{{ $transaction->chair->name ?? ''}}</td>
                            <td>{{ $transaction->action->name ?? '' }}</td>
                            <td>{{ $transaction->stock ?? ''}} {{ $transaction->asset->unit->name ?? ''}}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Asset:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
