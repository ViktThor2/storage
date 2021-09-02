@extends('emails.layouts.app')
@section('content')

    Kedves {{ auth()->user()->name }}, <br><br>

    A {{ $stock->asset->name }} elérte a kritikus mennyiséget. <br>
    Kritikus mennyiség : {{ $stock->asset->critical_stock ?? ''}} {{ $stock->asset->unit->name ?? '' }}

@endsection
