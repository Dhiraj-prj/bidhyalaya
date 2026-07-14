@extends('layouts.app')

@section('title', $setting->meta_title)
@section('meta_description', $setting->meta_description)
@section('meta_keyword', $setting->meta_keyword)

@section('content')

<div class="py-5 bg-light">
    <div class="container">
        <div class="row">

            <!-- Programs Section -->
            <div class="col-md-9">
                <h3 class="fw-bold mb-4">All Programs</h3>

                @forelse ($programs as $program)
                    <div class="card border-0 shadow-sm mb-4 hover-scale">
                        <div class="card-body">
                            <a href="{{ url('program/'.$program->slug) }}" class="text-decoration-none text-dark">
                                <h4 class="fw-semibold">{{ $program->name }}</h4>
                            </a>
                            <div class="d-flex justify-content-between text-muted small mt-2">
                                <span>📅 {{ $program->created_at->format('d-m-y') }}</span>
                                <span>Status:
                                    @if ($program->hideStatus == 0)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Hidden</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="text-muted">No programs available</h4>
                        </div>
                    </div>
                @endforelse

                <div class="mt-4 text-center">
                    {{ $programs->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="bg-white p-4 rounded shadow-sm sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-3">Advertisement</h5>

                    <!-- Facebook Page Embed -->
                    <div class="mb-4">
                        <div class="fb-page"
                             data-href="https://www.facebook.com/Literary-Association-of-Vishwa-Adarsha-Academy-LAVAA-61555370344258/"
                             data-tabs="timeline"
                             data-width="100%"
                             data-height="300"
                             data-small-header="false"
                             data-adapt-container-width="true"
                             data-hide-cover="false"
                             data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/Literary-Association-of-Vishwa-Adarsha-Academy-LAVAA-61555370344258/" class="fb-xfbml-parse-ignore">
                                <a href="https://www.facebook.com/Literary-Association-of-Vishwa-Adarsha-Academy-LAVAA-61555370344258/">LAVAA Facebook Page</a>
                            </blockquote>
                        </div>
                    </div>

                    <!-- Static Ad Image -->
                    <div>
                        <a href="https://www.facebook.com/Literary-Association-of-Vishwa-Adarsha-Academy-LAVAA-61555370344258/">
                            <img src="https://via.placeholder.com/300x250" alt="Ad Banner" class="img-fluid rounded shadow-sm">
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Facebook SDK -->
<script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"
        nonce="random_nonce"></script>
@endsection

@push('styles')
<!-- Google Font + Custom Style -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }
    .hover-scale {
        transition: transform 0.2s ease;
    }
    .hover-scale:hover {
        transform: scale(1.02);
    }
    .card h4 {
        margin-bottom: 0;
    }
    .badge {
        font-size: 0.75rem;
    }
</style>
@endpush
