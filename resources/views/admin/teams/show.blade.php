@extends('layouts.admin')
@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.teams.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.team.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.team.fields.id') }}
                        </th>
                        <td>
                            {{ $team->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.team.fields.name') }}
                        </th>
                        <td>
                            {{ $team->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>



@endsection
