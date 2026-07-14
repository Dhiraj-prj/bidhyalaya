@extends('layouts.inc.app')

@section('content')
<div class="container py-5" style="font-family: 'Segoe UI', sans-serif;">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Error Handling --}}
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endforeach
            @endif

            @if(session('message'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient text-white text-center" 
                     style="background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);">
                    <h4 class="mb-0">🔐 Welcome Back - Please Log In</h4>
                </div>

                <div class="card-body bg-light p-5">

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" 
                                   class="form-control shadow-sm rounded-3 @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" 
                                   class="form-control shadow-sm rounded-3 @error('password') is-invalid @enderror" 
                                   name="password" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="btn btn-outline-secondary rounded-pill shadow-sm">
                                   {{ __('Create a New Account') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
