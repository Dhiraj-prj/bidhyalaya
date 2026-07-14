@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="row">

        {{-- Total Categories --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-lg border-left-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tags fa-3x text-primary me-3"></i>
                        <div>
                            <h5 class="card-title text-primary">Total programs</h5>
                            <h2 class="font-weight-bold">{{ $categories }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-light">
                    <a class="small text-primary stretched-link" href="{{url('admin/program')}}">View Details</a>
                    <div class="small text-primary"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        {{-- Total Posts --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-lg border-left-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-alt fa-3x text-success me-3"></i>
                        <div>
                            <h5 class="card-title text-success">Total Posts</h5>
                            <h2 class="font-weight-bold">{{ $posts }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-light">
                    <a class="small text-primary stretched-link" href="{{url('admin/post')}}">View Details</a>
                    <div class="small text-primary"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        {{-- Total Users --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-lg border-left-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users fa-3x text-warning me-3"></i>
                        <div>
                            <h5 class="card-title text-warning">Total Users</h5>
                            <h2 class="font-weight-bold">{{ $users }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-light">
                    <a class="small text-primary stretched-link" href="{{url('admin/users')}}">View Details</a>
                    <div class="small text-primary"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        {{-- Total Admins --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow-lg border-left-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-shield fa-3x text-danger me-3"></i>
                        <div>
                            <h5 class="card-title text-danger">Total Admins</h5>
                            <h2 class="font-weight-bold">{{ $admins }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-light">
                    <a class="small text-primary stretched-link" href="{{url('admin/users')}}">View Details</a>
                    <div class="small text-primary"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Activity --}}
    <div class="row">
        <div class="col-xl-6">
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    Recent Posts
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        @forelse($recentPosts as $post)
                            <li class="list-group-item">
                                {{ $post->name }}
                                <span class="text-muted"> - {{ $post->created_at->diffForHumans() }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No recent posts available.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-success text-white">
                    Recent Users
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($recentUsers as $user)
                            <li class="list-group-item">{{ $user->name }} - {{ $user->created_at->diffForHumans() }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifications --}}
    <div class="row">
        <div class="col-xl-12">
            @if($pendingPosts > 0)
                <div class="alert alert-warning">
                    {{ $pendingPosts }} posts are pending approval.
                </div>
            @endif
            @if($pendingUsers > 0)
                <div class="alert alert-danger">
                    {{ $pendingUsers }} users are pending approval.
                </div>
            @endif
        </div>
    </div>

    {{-- Chart --}}
    <div class="card shadow-lg mt-4">
        <div class="card-header bg-info text-white">
            Posts by Program
        </div>
        <div class="card-body">
            <canvas id="ProgramChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ProgramChart').getContext('2d');
    const ProgramChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($categoriesData->pluck('name')),
            datasets: [{
                label: 'Posts per Program',
                data: @json($categoriesData->pluck('posts_count')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
