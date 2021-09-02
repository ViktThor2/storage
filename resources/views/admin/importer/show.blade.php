@extends('layouts.admin')
@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.importer.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

    <div class="card">

    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.importer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">

            <table class="table table-bordered table-striped">
                <tbody>

                    <tr>
                        <th>Név</th>
                        <td>{{ $importer->name }}</td>
                    </tr>
                    <tr>
                        <th>Cég neve</th>
                        <td>{{ $importer->company_name  }}</td>
                    </tr>
                    <tr>
                        <th>Adószám</th>
                        <td>{{ $importer->tax_number}}</td>
                    </tr>
                    <tr>
                        <th>Kapcsolattartó</th>
                        <td>{{ $importer->contact_name}}</td>
                    </tr>
                    <tr>
                        <th>Kapcsolattartó telefonszáma</th>
                        <td>{{ $importer->contact_phone}}</td>
                    </tr>
                    <tr>
                        <th>Email cím</th>
                        <td>{{ $importer->email}}</td>
                    </tr>
                    <tr>
                        <th>Cím</th>
                        <td>{{ $importer->adress}}</td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>



@endsection
