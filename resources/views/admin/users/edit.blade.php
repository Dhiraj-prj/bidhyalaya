@extends('layouts.master')

@section('title', 'Edit Users')

@section('content')

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="float-start">Edit Users</h4>
        </div>

        <div class="card-body">
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif

            <form action="{{ url('admin/edit-users/' . $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" value="{{ $user->name }}" name="name" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="phone">Phone Number</label>
                    <input type="text" value="{{ $user->phone }}" name="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" value="{{ $user->email }}" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="dob">Date of Birth</label>
                    <input type="date" value="{{ $user->dob }}" name="dob" class="form-control">
                </div>


                <div class="mb-3">
                    <label for="status">Active Status</label>
                    <select name="status" class="form-control">
                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Active</option>
                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="role_as">Role</label>
                    <select name="role_as" class="form-control">
                        <option value="1" {{ $user->role_as == 1 ? 'selected' : '' }}>Admin</option>
                        <option value="0" {{ $user->role_as == 0 ? 'selected' : '' }}>Registered User</option>
                    </select>
                </div>

                <div class="float-end mb-3">
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
