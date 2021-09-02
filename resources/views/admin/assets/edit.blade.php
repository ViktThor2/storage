@extends('layouts.admin')
@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.assets.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

    <div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.asset.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.assets.update", [$asset->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.asset.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $asset->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="value">Érték</label>
                <input type="number" class="form-control" name="value" id="value" value="{{ $asset->value ?? '' }}">
            </div>

            <div class="form-group">
                <label for="team_id">Mennyiségi egység</label>
                <select class="form-control select2" name="unit_id" id="unit_id">
                    @foreach($units as $id => $unit)
                        <option value="{{ $unit->id }}"> {{ $unit->name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="critical_stock">Kritikus mennyiség</label>
                <input type="number" class="form-control" name="critical_stock" id="critical_stock" value="{{ $asset->critical_stock ?? ''}}" >
            </div>

            <div class="form-group mt-2">
                <label for="category">Kategória ( Egy szint megadása elegendő )</label>
                <select class="form-control select2" name="category" id="category">
                    <option value="" selected>{{ $asset->category->name ?? ''}}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id ?? ''}}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select class="form-control select2" name="subcategory" id="subcategory">
                    <option value="" selected>{{ $asset->sub_category->name ?? '' }}</option>
                    @foreach($categories as $category)
                        @foreach($category->sub_categories as $subcategory)
                            <option value="{{ $subcategory->id }}">
                                {{ $category->name }}  /  {{ $subcategory->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>

                <select class="form-control select2" name="subsubcategory" id="subsubcategory">
                    <option value="" selected>{{ $asset->sub_sub_category->name ?? ''}}</option>
                    @foreach($categories as $category)
                        @foreach($category->sub_categories as $subcategory)
                            @foreach($subcategory->sub_sub_categories as $subsubcategory)
                                <option value="{{ $subsubcategory->id }}">
                                    {{ $category->name }}  /  {{ $subcategory->name }} / {{ $subsubcategory->name }}
                                </option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">{{ trans('cruds.asset.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $asset->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.description_helper') }}</span>
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
