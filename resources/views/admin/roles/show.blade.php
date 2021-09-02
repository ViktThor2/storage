@extends('layouts.admin')
@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.roles.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.role.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.role.fields.id') }}</th>
                        <td>{{ $role->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.role.fields.title') }}</th>
                        <td>{{ $role->title }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.role.fields.permissions') }}</th>
                        <td>
                            @foreach($role->permissions as $key => $permissions)
                                <span class="label label-info">{{ $permissions->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
