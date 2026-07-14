@extends('layouts.master')

@section('content')

<div class="container-fluid px-4">

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="float-start">Add Posts</h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif

            <!-- Form to create a post -->
            <form method="POST" action="{{ url('admin/add-post') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Post Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="program">Program</label>
                    <select id="program" name="Program_id" class="form-control">
                        <option value="">Select Program</option>
                        @foreach($programs as $Program)
                            <option value="{{ $Program->id }}">{{ $Program->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="subProgram">Level</label>
                    <select id="subProgram" name="subProgram" class="form-control">
                    </select>
                </div>

                <div class="form-group">
                    <label for="postType">Post Type</label>
                    <div class="custom-select-wrapper">
                        <select name="postType" id="postType" class="form-select custom-select">
                            <option value="note">Note</option>
                            <option value="pastQuestions">Past Questions</option>
                            <option value="syllabus">Syllabus</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="">Slug</label>
                    <input type="text" name="slug" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="">Description</label>
                    <textarea id="mySummernote" name="description" rows="5" class="form-control"></textarea>
                </div>

                <!-- File Upload Section -->
                <h4>Attach Files</h4>
                <div id="fileInputsWrapper">
                    <div class="form-group file-input-group">
                        <label for="files">Attach Files (multiple)</label>
                        <input type="file" class="form-control-file" name="files[]" id="files" multiple>
                        <button type="button" class="btn btn-danger btn-sm remove-file-btn" style="display:none;">Cancel</button>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="addFileInputBtn">Add More Files</button>

                <h4>SEO Tags</h4>
                <div class="mb-3">
                    <label for="">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description" rows="4" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="">Meta Keywords</label>
                    <input type="text" name="meta_keyword" class="form-control">
                </div>

                <h4>Status</h4>
                <div class="row">
                    <div class="col-mod-4">
                        <div class="mb-3">
                            <input type="checkbox" name="hideStatus">
                            <label for="">Hide Post</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>

    </div>

</div>

<!-- Script to handle dynamic level fetching -->
<script>
    // Listen for changes in the Program dropdown
    document.getElementById('program').addEventListener('change', function () {
        var ProgramId = this.value;  // Get selected Program ID
        var subProgramSelect = document.getElementById('subProgram');

        // Clear previous levels
        subProgramSelect.innerHTML = '<option value="">Select Level</option>';

        // If no Program is selected, stop the process
        if (!ProgramId) return;

        // Fetch levels for the selected Program
        fetch(`/admin/get-levels/${ProgramId}`)
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
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
            .catch(error => {
                console.error('Error fetching levels:', error);
                subProgramSelect.innerHTML = '<option value="">Error fetching levels</option>';
            });
    });

    // Add more file input fields
    document.getElementById('addFileInputBtn').addEventListener('click', function () {
        var newFileInputGroup = document.createElement('div');
        newFileInputGroup.classList.add('form-group', 'file-input-group');
        newFileInputGroup.innerHTML = `
            <label for="files">Attach Files (multiple)</label>
            <input type="file" class="form-control-file" name="files[]" id="files" multiple>
            <button type="button" class="btn btn-danger btn-sm remove-file-btn">Cancel</button>
        `;
        document.getElementById('fileInputsWrapper').appendChild(newFileInputGroup);

        // Show the cancel button when a new file input is added
        const cancelButton = newFileInputGroup.querySelector('.remove-file-btn');
        cancelButton.style.display = 'inline-block';
    });

    // Remove the file input field
    document.getElementById('fileInputsWrapper').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-file-btn')) {
            e.target.closest('.file-input-group').remove();
        }
    });
</script>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
