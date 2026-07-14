@extends('layouts.master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="float-start">Edit Post</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif

            <!-- Form to edit a post -->
            <form method="POST" action="{{ url('admin/edit-post', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Post Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $post->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="program">Program</label>
                    <select id="program" name="Program_id" class="form-control">
                        <option value="">Select Program</option>
                        @foreach($programs as $Program)
                            <option value="{{ $Program->id }}" {{ $Program->id == old('Program_id', $post->Program_id) ? 'selected' : '' }}>
                                {{ $Program->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="subProgram">Level</label>
                    <select id="subProgram" name="subProgram" class="form-control">
                        <!-- Levels will be dynamically loaded based on Program selection -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="postType">Post Type</label>
                    <select name="postType" id="postType" class="form-select">
                        <option value="note" {{ old('postType', $post->postType) == 'note' ? 'selected' : '' }}>Note</option>
                        <option value="pastQuestions" {{ old('postType', $post->postType) == 'pastQuestions' ? 'selected' : '' }}>Past Questions</option>
                        <option value="syllabus" {{ old('postType', $post->postType) == 'syllabus' ? 'selected' : '' }}>Syllabus</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}">
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea id="mySummernote" name="description" rows="5" class="form-control">{{ old('description', $post->description) }}</textarea>
                </div>

                <!-- File Upload Section -->
                <h4>Attach Files</h4>
                <div id="fileInputsWrapper" class="row">
                    @if($post->files && count($post->files) > 0)
                        <p>Files attached:</p>
                        @foreach($post->files as $file)
                            <div class="col-md-4 file-item" id="file-row-{{ $file->id }}">
                                <div class="file-box">
                                    <p>{{ $file->file_path }}</p>
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-file-btn" data-file-id="{{ $file->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No files attached yet.</p>
                    @endif

                    <div class="form-group file-input-group col-md-4">
                        <label for="files">Attach New Files</label>
                        <input type="file" class="form-control-file" name="files[]" multiple>
                    </div>
                </div>

                <h4>SEO Tags</h4>
                <div class="mb-3">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title) }}">
                </div>

                <div class="mb-3">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" rows="4" class="form-control">{{ old('meta_description', $post->meta_description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="meta_keyword">Meta Keywords</label>
                    <input type="text" name="meta_keyword" class="form-control" value="{{ old('meta_keyword', $post->meta_keyword) }}">
                </div>

                <h4>Status</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <input type="checkbox" name="hideStatus" {{ old('status', $post->status) ? 'checked' : '' }}>
                            <label for="status">Hide Post</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Post</button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.getElementById('program').addEventListener('change', function () {
        var ProgramId = this.value;
        var subProgramSelect = document.getElementById('subProgram');
        subProgramSelect.innerHTML = '<option value="">Select Level</option>';

        if (!ProgramId) return;

        fetch(`/admin/get-levels/${ProgramId}`)
            .then(response => response.json())
            .then(data => {
                subProgramSelect.innerHTML = '<option value="">Select Level</option>';
                if (data.length > 0) {
                    data.forEach(level => {
                        var option = document.createElement('option');
                        option.value = level.id;
                        option.textContent = level.name;
                        subProgramSelect.appendChild(option);
                    });
                } else {
                    subProgramSelect.innerHTML = '<option value="">No levels available</option>';
                }
            })
            .catch(error => console.error('Error fetching levels:', error));
    });

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("delete-file-btn")) {
            let fileId = e.target.getAttribute("data-file-id");

            if (!confirm("Are you sure you want to delete this file?")) return;

            fetch(`/admin/delete-file/${fileId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ _method: "DELETE" })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`file-row-${fileId}`).remove();
                } else {
                    alert("Error removing file: " + data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });
</script>

<!-- FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

@endsection
