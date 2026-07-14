@extends('layouts.master')

@section('title', 'Posts')

@section('content')

<div>
    <div class="container-fluid px-4">

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="float-start">View Posts</h4>
                <a href="{{url('admin/add-post')}}" class="btn btn-primary float-end btn-sm"> Add Post</a>
            </div>

            <div class="card-body">

                @if (@session('message'))
                    <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (@session('destroy_message'))
                    <div id="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('destroy_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered table-stripped display table-fixed" style="border-top: 1px solid #dee2e6;">
                        <thead>
                            <tr>
                                <th style="width: 10%;">S.N.</th>
                                <th style="width: 30%;">Post Title</th>
                                <th style="width: 15%;">program</th>
                                <th style="width: 10%;">Level</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 15%;">Created by</th>
                                <th style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($posts as $index => $post)
                            <tr>

                                <td>{{ $index + 1 }}</td>
                                <td>{{ $post->name }}</td>
                                <td>{{ $post->program->name ?? 'N/A' }}</td>
                                <td>{{ $post->subprogram }}</td>
                                <td>{{ $post->status == '1' ? "Published" : "Draft" }}</td>
                                <td>{{ $post->Created_by->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ url('admin/edit-post/' . $post->id) }}">
                                        <button class="btn btn-success"><i class="fas fa-edit"></i></button>
                                    </a>
                                    <a href="{{ url('admin/delete-post/' . $post->id) }}" onclick="return confirm('Are you sure you want to delete this post?')">
                                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Hide success message after 3 seconds
    setTimeout(function() {
        var successMessage = document.getElementById("successMessage");
        if (successMessage) {
            successMessage.style.display = "none";
        }
    }, 3000);  // 3000ms = 3 seconds

    // Hide error message after 3 seconds
    setTimeout(function() {
        var errorMessage = document.getElementById("errorMessage");
        if (errorMessage) {
            errorMessage.style.display = "none";
        }
    }, 3000);  // 3000ms = 3 seconds
</script>

@endsection

@push('styles')
    <style>
        .alert {
            position: relative;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            transition: all 0.5s ease-in-out;
            font-size: 16px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .alert i {
            margin-right: 10px;
        }

        .alert-dismissible .close {
            position: absolute;
            top: 5px;
            right: 10px;
            padding: 1px;
            color: inherit;
            font-size: 20px;
            background: none;
            border: none;
        }

        .alert-success {
            animation: fadeInSuccess 1s ease-in-out;
        }

        .alert-danger {
            animation: fadeInError 1s ease-in-out;
        }

        @keyframes fadeInSuccess {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes fadeInError {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
@endpush
