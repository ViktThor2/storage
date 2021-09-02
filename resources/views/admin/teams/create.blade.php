@extends('layouts.admin')
@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.teams.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

    <div class="card">
    <div class="card-header">
        {{ trans('global.create') }} rendelő
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.teams.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="required" for="company">Cég</label>
                <select class="form-control select2" name="company" id="company" required>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">  {{ $company->name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.team.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.name_helper') }}</span>
            </div>

            <div class="form-group d-flex justify-content-end">
                <button class="btn btn-success" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>

        </form>
    </div>
</div>



@endsection
