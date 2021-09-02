@extends('layouts.admin')

@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.chair.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

<div class="card">

    <div class="card-header">
        {{ trans('global.show') }}
    </div>

    <div class="card-body">
        <div class="form-group">

            <table class="table table-bordered table-striped">
                <tbody>

                    <tr>
                        <th>Munkaállomás neve</th>
                        <td>{{ $chair->name ?? ''}}</td>
                    </tr>
                    <tr>
                        <th>Rendelő neve</th>
                        <td>{{ $chair->team->name ?? '' }}</td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>



@endsection
