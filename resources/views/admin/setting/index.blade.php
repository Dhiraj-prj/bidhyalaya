@extends('layouts.master')

@section('title','Settings')
@section('content')

<div>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Settings</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard/Settings</li>
        </ol>

        <!-- Display success or error messages -->
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <!-- Form to edit settings -->
        <form action="{{ url('admin/settings') }}" method="POST" enctype="multipart/form-data">
        @csrf
    @method('PUT')

            <!-- Website Name -->
            <div class="form-group">
                <label for="website_name">Website Name</label>
                <input type="text" class="form-control" id="website_name" name="website_name" value="{{ old('website_name', $setting->website_name) }}" required>
            </div>

            <!-- Meta Title -->
            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}" required>
            </div>

            <!-- Meta Keyword -->
            <div class="form-group">
                <label for="meta_keyword">Meta Keyword</label>
                <input type="text" class="form-control" id="meta_keyword" name="meta_keyword" value="{{ old('meta_keyword', $setting->meta_keyword) }}" required>
            </div>

            <!-- Meta Description -->
            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea class="form-control" id="meta_description" name="meta_description" rows="4" required>{{ old('meta_description', $setting->meta_description) }}</textarea>
            </div>

            <!-- Website Logo -->
            <div class="form-group">
                <label for="website_logo">Website Logo</label>
                <input type="file" class="form-control" id="website_logo" name="website_logo" onchange="updateFileName('website_logo')">
                @if($setting->logo)
                    <div>
                        <p>Current Logo: <span id="current-logo-name">{{ $setting->logo }}</span></p>
                        <img src="{{ asset('uploads/settings/' . $setting->logo) }}" alt="Current Logo" class="mb-3" width="100">
                    </div>
                @endif
            </div>

            <!-- Website Favicon -->
            <div class="form-group">
                <label for="website_favicon">Website Favicon</label>
                <input type="file" class="form-control" id="website_favicon" name="website_favicon" onchange="updateFileName('website_favicon')">
                @if($setting->fevicon)
                    <div>
                        <p>Current Favicon: <span id="current-favicon-name">{{ $setting->fevicon }}</span></p>
                        <img src="{{ asset('uploads/settings/' . $setting->fevicon) }}" alt="Current Favicon" class="mb-3" width="50">
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary float-end mb-3">Save Changes</button>
        </form>
    </div>
</div>

<script>
    function updateFileName(inputId) {
        var input = document.getElementById(inputId);
        var fileName = input.files[0] ? input.files[0].name : '';

        if(inputId === 'website_logo') {
            document.getElementById('current-logo-name').textContent = fileName || '{{ $setting->logo }}';
        } else if(inputId === 'website_favicon') {
            document.getElementById('current-favicon-name').textContent = fileName || '{{ $setting->fevicon }}';
        }
    }
</script>

@endsection
