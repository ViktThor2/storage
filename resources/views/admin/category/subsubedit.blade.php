@extends('layouts.admin')

@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.category.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

    <div class="card">

        <div class="card-header">
            Alkategória szerkesztése
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route("admin.subsubcategory.update", [$subsubcategory->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <label class="required" for="category">Kategória</label>
                <select class="form-control select2" name="category" id="category" required>
                    @foreach($subcategories as $id => $category)
                        <option value="{{ $category->id }}"> {{ $category->category->name ?? '' }} / {{ $category->name }} </option>
                    @endforeach
                </select>


                <div class="form-group mt-3">
                    <label class="required" for="name">Alkategória neve</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{$subsubcategory->name}}" required>
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
