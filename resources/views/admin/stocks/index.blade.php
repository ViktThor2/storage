@extends('layouts.admin')
@section('content')

    <div class="card">

        <div class="card-header">
            {{ trans('cruds.stock.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-end">

                <form action="{{ route('admin.stock.search') }}" method="post" id="search_form">
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

                <table class=" table table-bordered table-striped table-hover datatable datatable-Stock">

                    <thead>
                    <tr>
                        <th width="5">Id</th>
                        <th width="35%">Eszközök</th>
                        @foreach($teams as $team)
                            <th id="{{ $team->id }}">{{ $team->company->name  ?? ''}}  <br> {{ $team->name }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $item)
                        <tr>
                            <td> {{$item['id'] }} </td>
                            <td> {{ $item['name'] }} </td>
                            @foreach($item['stock'] as $stock)
                                <td> {{ $stock }}  {{ $item['unit'] ?? ''}}</td>
                            @endforeach
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

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[ 1, 'asc' ]],
                pageLength: 100,
                columnDefs: [{
                    orderable: true,
                    className: '',
                    targets: 0
                }]
            });
            $('.datatable-Stock:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
