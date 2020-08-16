@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <pre> {{ $turns }} </pre>
            </div>
        </div>
    </div>
</div>
@endsection
