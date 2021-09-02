@extends('layouts.admin')
@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.importer.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

<div class="card">

    <div class="card-header">
        Új beszállító
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route("admin.importer.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="required" for="name">Név</label>
                <input class="form-control" type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label class="required" for="company_name">Cég neve</label>
                <input class="form-control" type="text" name="company_name" id="company_name" required>
            </div>

            <div class="form-group">
                <label class="required" for="tax_number">Adószám</label>
                <input class="form-control" type="number" name="tax_number" id="tax_number" required>
            </div>

            <div class="form-group">
                <label class="required" for="contact_name">Kapcsolattartó</label>
                <input class="form-control" type="text" name="contact_name" id="contact_name" required>
            </div>

            <div class="form-group">
                <label class="required" for="contact_phone">Kapcsolattartó telefonszáma</label>
                <input class="form-control" type="text" name="contact_phone" id="contact_phone" required>
            </div>

            <div class="form-group">
                <label class="required" for="email">Email cím</label>
                <input class="form-control" type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label class="required" for="adress">Cím</label>
                <input class="form-control" type="text" name="adress" id="adress" required>
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
