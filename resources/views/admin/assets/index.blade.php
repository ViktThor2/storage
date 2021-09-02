@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.asset.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">

        <div class="d-flex justify-content-end">


            <form action="{{ route('admin.asset.search') }}" method="post" id="search_form">
                @csrf

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">

                        <input type="search" class="form-control"
                               placeholder="Keresés" name="search"/>

                        <div class="input-group-append">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </form>

            {!! $assets->links() !!}

        </div>

        <div class="table-responsive">
            <table id="Asset-_table" class=" table table-bordered table-striped table-hover datatable datatable-Asset">
                <thead>
                    <tr>
                        <th width="10" class="align-middle"></th>
                        <th width="5%" class="align-middle">{{ trans('cruds.asset.fields.id') }}</th>
                        <th width="25%" class="align-middle">{{ trans('cruds.asset.fields.name') }}</th>
                        <th class="align-middle">Főkategória</th>
                        <th class="align-middle">Kategória</th>
                        <th class="align-middle">Alkategória</th>
                        <th width="10%" class="align-middle">Érték</th>
                        <th width="340" class="align-middle"><a class="btn btn-success w-100" href="{{ route("admin.assets.create") }}">
                                {{ trans('global.add') }}
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $key => $asset)
                        <tr data-entry-id="{{ $asset->id }}">
                            <td></td>
                            <td>{{ $asset->id ?? '' }}</td>
                            <td>{{ $asset->name ?? '' }}</td>
                            <td>{{ $asset->category->name ?? '' }} </td>
                            <td>{{ $asset->sub_category->name ?? '' }}</td>
                            <td>{{ $asset->sub_sub_category->name ?? '' }} </td>
                            <td>{{ $asset->value ?? '' }}</td>
                            <td>
                                <a class="btn btn-sm btn-light" href="{{ route('admin.assets.history', $asset->id) }}">
                                    Élettörténet
                                </a>
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.assets.show', $asset->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.assets.edit', $asset->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mb-5">
            {!! $assets->links() !!}
        </div>

    </div>
</div>


@endsection

@section('scripts')
@parent
<script>
$(function () {

  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'

    let deleteButton = {

      text: deleteButtonTrans,
        url: "{{ route('admin.assets.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {

          var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
              return $(entry).data('entry-id')
          });

          if (ids.length === 0) {
            alert('{{ trans('global.datatables.zero_selected') }}')
            return
          }

          if (confirm('{{ trans('global.areYouSure') }}')) {
            $.ajax({
              headers: {'x-csrf-token': _token},
              method: 'POST',
              url: config.url,
              data: { ids: ids, _method: 'DELETE' }})
              .done(function () { location.reload() })
          }
        }
    }

    dtButtons.push(deleteButton)

      $.extend(true, $.fn.dataTable.defaults, {
        order: [[ 1, 'asc' ]],
        pageLength: 50,
      });

    $('.datatable-Asset:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

})

</script>
@endsection
