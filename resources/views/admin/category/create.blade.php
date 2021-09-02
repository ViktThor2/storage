@extends('layouts.admin')

@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.category.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

<div class="card">

    <div class="card-header">
        Új Főkategória
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route("admin.category.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group mt-2">
                <label class="required" for="name">Név</label>
                <input class="form-control" type="text" name="name" id="name" required>
            </div>

            <div class="form-group d-flex justify-content-end">
                <button class="btn btn-success" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>

        </form>

    </div>
</div>

    <div class="card">

        <div class="card-header">
            Új Kategória
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route("admin.subcategory.store") }}" enctype="multipart/form-data">
                @csrf

                <label class="required" for="category">Főkategória</label>
                <select class="form-control select2" name="category" id="category" required>
                    @foreach($categories as $id => $category)
                        <option value="{{ $category->id }}"> {{ $category->name }} </option>
                    @endforeach
                </select>

                <div class="form-group mt-2">
                    <label class="required" for="name">Név</label>
                    <input class="form-control" type="text" name="name" id="name" required>
                </div>

                <div class="form-group d-flex justify-content-end">
                    <button class="btn btn-success" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>

            </form>

        </div>
    </div>


    <div class="card">

        <div class="card-header">
            Új Alkategória
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route("admin.subsubcategory.store") }}" enctype="multipart/form-data">
                @csrf

                <label class="required" for="category">Kategória</label>
                <select class="form-control select2" name="category" id="category" required>
                    @foreach($subcategories as $id => $category)
                        <option value="{{ $category->id }}"> {{ $category->category->name ?? '' }} / {{ $category->name }} </option>
                    @endforeach
                </select>

                <div class="form-group mt-3">
                    <label class="required" for="name">Főkategória neve</label>
                    <input class="form-control" type="text" name="name" id="name" required>
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
