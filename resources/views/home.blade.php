@extends('layouts.inc.app')
<link rel="shortcut icon" href="{{ asset('images/fevicon.ico') }}" type="image/x-icon">


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>

                    @else
                    <div class="alert alert-success" role="alert">
                        {{ __('You are logged in!') }}

                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
