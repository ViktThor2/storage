@extends('layouts.admin')
@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.assets.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.asset.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">

            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th> {{ trans('cruds.asset.fields.id') }} </th>
                        <td> {{ $asset->id }} </td>
                    </tr>
                    <tr>
                        <th> {{ trans('cruds.asset.fields.name') }} </th>
                        <td> {{ $asset->name ?? ''}} </td>
                    </tr>
                    <tr>
                        <th> {{ trans('cruds.asset.fields.description') }} </th>
                        <td> {{ $asset->description ?? ''}} </td>
                    </tr>
                    <tr>
                        <th>Aktuális készlet</th>
                        <td>
                            @foreach($asset->stocks as $id => $stock)
                                {{ $stock->team->name ?? ''}}  {{ $stock->current_stock ?? '' }} {{ $stock->asset->unit->name ?? '' }} <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Kritikus mennyiség</th>
                        <td>{{ $asset->critical_stock ?? ''}} {{ $asset->unit->name ?? ''}}</td>
                    </tr>
                    <tr>
                        <th>Érték</th>
                        <td>{{ $asset->value ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Főkategória</th>
                        <td>{{ $asset->category->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Kategória</th>
                        <td>{{ $asset->sub_category->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Alkategória</th>
                        <td>{{ $asset->sub_sub_category->name ?? '' }}</td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>
</div>


@endsection
