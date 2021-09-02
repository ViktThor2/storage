@extends('layouts.admin')
@section('content')

    <div class="card">

        <div class="card-header">
            Felhasználás
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-end">

                <form action="{{ route('admin.stock.out.search') }}" method="post" id="search_form">
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

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Stock">

                    <thead>
                    <tr>
                        <th> Eszközök </th>
                        <th width="25%"> Munkaállomás </th>
                        <th width="20%"> Orvosok </th>
                        <th width="5%"> Mennyiség </th>
                        <th width="5%"></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($assets as $key => $asset)
                        <tr>
                            <form action="{{ route('admin.stock.transaction.remove', $asset->id) }}" method="POST" style="display: inline-block;" class="form-inline">

                                <td>{{ $asset->name }}</td>

                                <td>
                                    <select class="form-control select2" name="chair_id" id="chair_id">
                                        @foreach($asset->stocks as $stock)
                                            @foreach($stock->team->chairs as $chair)
                                                @if( isset($chair->team->company->id) && $chair->team->company->id == session('company')->id )
                                                    <option value="{{ $chair->id }}">
                                                            {{ $chair->team->name ?? ''}} : {{ $stock->current_stock ?: 0 }} {{ $asset->unit->name ?? ''}} / {{ $chair->name ?? ''}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="doctor_id" id="doctor_id">
                                        @foreach($doctors as $id => $doctor)
                                            <option value="{{ $doctor->id }}"> {{ $doctor->name }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="number" name="stock" class="form-control" min="1">
                                </td>
                                <td>
                                    <input type="submit" class="btn btn-success mt-2" value="Felhasznál">
                                    <input type="submit" class="btn btn-danger mt-2" formaction="{{ route('admin.stock.transaction.discard', $asset->id) }}" value="Selejtezés">
                                </td>

                            </form>

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
                order: [[ 1, 'desc' ]],
                pageLength: 50,
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
