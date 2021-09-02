@extends('layouts.admin')

@section('content')

    <a class="btn btn-info mb-2" href="{{ route('admin.doctor.index') }}">
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
                        <th>Név</th>
                        <td>{{ $doctor->name }}</td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>



@endsection
