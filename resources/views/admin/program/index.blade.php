@extends('layouts.master')

@section('title','program')

@section('content')

<div>
    <div class="container-fluid px-4">

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="float-start">View program</h4>
                <a href="{{url('admin/add-program')}}" class="btn btn-primary float-end btn-sm"> Add program</a>
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
                            <tr style="margin-top:10ox;">
                                <th style="width: 10%;">S.N.</th>
                                <th style="width: 30%;">Program Name</th>
                                <th style="width: 10%;">Level Type</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 10%;">Created by</th>
                                <th style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Program as $index => $item)
                            <tr>
                                <td>{{ $index + 1}}</td>
                                <td>{{ $item->name}}</td>
                                <td>{{ $item->levelType == '1' ? "Semester" : "Year"}}</td>
                                <td>{{ $item->status == '1' ? "Hidden" : "Shown"}}</td>
                                <td>{{ $item->Created_by->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{url('admin/edit-program/'.$item->id)}}"><button class="btn btn-success"><i class="fas fa-edit"></i></button></a>
                                    <a href="{{('delete-program/'.$item->id)}}" onclick="return confirm('Are you sure you want to delete this program?')"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
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
