@extends('layouts.admin')

@section('content')

    <div class="card">

        <div class="card-header">
            Kategóriák
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-end">
                {!! $categories->links() !!}
            </div>

            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Category-SubCategory-SubSubCategory">

                    <thead>
                    <tr>
                        <th></th>
                        <th class="align-middle"> Főkategória neve </th>
                        <th class="align-middle"> Kategória neve </th>
                        <th class="align-middle"> Alkategória neve </th>

                        <th width="180" class="align-middle">
                            <a class="btn btn-success w-100" href="{{ route("admin.category.create") }}">
                                {{ trans('global.add') }}
                            </a>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($categories as $key => $category)
                        <tr data-entry-id="{{ $category->id }}">
                            <td></td>
                            <td> {{ $category->name }}</td>
                            <td></td>
                            <td></td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.category.edit', $category->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>                        </tr>

                        @foreach($category->sub_categories as $sub)
                            <tr data-entry-id="{{ $sub->id }}">
                                <td></td>
                                <td> {{ $category->name ?? ''}} </td>
                                <td> {{ $sub->name }}  </td>
                                <td></td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.subcategory.edit', $sub->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form action="{{ route('admin.subcategory.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                </td>
                            </tr>

                            @foreach($sub->sub_sub_categories as $sscat)
                                <tr data-entry-id="{{ $sscat->id }}">
                                    <td></td>
                                    <td> {{ $category->name }} </td>
                                    <td> {{ $sub->name }}</td>
                                    <td> {{ $sscat->name }}  </td>

                                <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.subsubcategory.edit', $sscat->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                <form action="{{ route('admin.subsubcategory.destroy', $sscat->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>
                            </tr>
                            @endforeach
                    @endforeach
                    @endforeach
                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-end">
                {!! $categories->links() !!}
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script>
        $(function () {

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            $('.datatable-Category-SubCategory-SubSubCategory:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
