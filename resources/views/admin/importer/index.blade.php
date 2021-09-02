@extends('layouts.admin')

@section('content')

    <div class="card">

        <div class="card-header">
            {{ trans('cruds.importer.title_singular') }}
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-end">

                <form action="{{ route('admin.importer.search') }}" method="post" id="search_form">
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

                {!! $importers->links() !!}

            </div>

            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Importers">

                    <thead>
                    <tr>
                        <th></th>
                        <th class="align-middle"> Név </th>
                        <th class="align-middle"> Cégnév </th>
                        <th class="align-middle"> Kapcsolattartó </th>
                        <th class="align-middle"> Elérhetőségek  </th>
                        <th class="align-middle"> Cím </th>
                        <th width="240"><a class="btn btn-success w-100" href="{{ route("admin.importer.create") }}">
                                {{ trans('global.add') }}
                            </a>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($importers as $key => $importer)
                        <tr data-entry-id="{{ $importer->id }}">
                            <td></td>
                            <td> {{ $importer->name ?? ''}} </td>
                            <td> {{ $importer->company_name ?? ''}} </td>
                            <td> {{ $importer->contact_name ?? ''}} </td>
                            <td> {{ $importer->email ?? ''}} <br>
                                {{ $importer->contact_phone ?? ''}} </td>
                            <td> {{ $importer->adress ?? ''}} </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.importer.show', $importer->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.importer.edit', $importer->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                <form action="{{ route('admin.importer.destroy', $importer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                {!! $importers->links() !!}
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
                url: "{{ route('admin.importer.massDestroy') }}",
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
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            $('.datatable-Importers:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
