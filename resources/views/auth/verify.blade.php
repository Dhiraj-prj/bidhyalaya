@extends('layouts.inc.app')

@section('content')
<div class="container py-5" style="font-family: 'Segoe UI', sans-serif;">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header text-white text-center" 
                     style="background: linear-gradient(90deg, #ff6a00 0%, #ee0979 100%);">
                    <h4 class="mb-0">📧 Verify Your Email</h4>
                </div>

                <div class="card-body bg-light p-5">

                    @if (session('resent'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ __('✅ A new verification link has been sent to your email.') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <p class="mb-3">
                        {{ __('Before proceeding, please check your inbox for a verification link.') }}
                    </p>
                    <p class="mb-4">
                        {{ __('If you didn’t receive the email, you can request a new one:') }}
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning rounded-pill shadow-sm px-4">
                            🔁 {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
