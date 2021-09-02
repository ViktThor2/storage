@extends('layouts.admin')

@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.unit.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

<div class="card">

    <div class="card-header">
        Új mennyiségi egység
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route("admin.unit.store") }}" enctype="multipart/form-data">
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



@endsection
