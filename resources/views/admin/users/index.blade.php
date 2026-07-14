@extends('layouts.master')

@section('title','users')

@section('content')
<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="float-start">View Users</h4>
        </div>

        <div class="card-body">
            <!-- Success Message -->
            @if (@session('message'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-striped display table-fixed" style="border-top: 1px solid #dee2e6;">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->role_as == '1' ? "Admin" : "Registered User" }}</td>
                            <td>{{ $item->status == 0 ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-info" onclick="viewUserDetails({{ $item->id }})">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ url('admin/edit-users/'.$item->id) }}">
                                    <button class="btn btn-success"><i class="fas fa-edit"></i></button>
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

<!-- User Details Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="user-name"></span></p>
                <p><strong>Email:</strong> <span id="user-email"></span></p>
                <p><strong>Phone:</strong> <span id="user-phone"></span></p>
                <p><strong>Date of Birth:</strong> <span id="user-dob"></span></p>
                <p><strong>Role:</strong> <span id="user-role"></span></p>
                <p><strong>Status:</strong> <span id="user-status"></span></p>
                <p><strong>Joined At:</strong> <span id="user-created-at"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript and AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function viewUserDetails(userId) {
        $.ajax({
            url: '/admin/get-user-details/' + userId,  // Adjust the URL as needed
            type: 'GET',
            success: function(data) {
                if (data.success) {
                    // Populate the modal with user data
                    $('#user-name').text(data.user.name);
                    $('#user-email').text(data.user.email);
                    $('#user-phone').text(data.user.phone);
                    $('#user-dob').text(data.user.dob);
                    $('#user-role').text(data.user.role_as == 1 ? 'Admin' : 'Registered User');
                    $('#user-status').text(data.user.status == 0 ? 'Active' : 'Inactive');
                    $('#user-created-at').text(data.user.created_at);

                    // Show the modal using Bootstrap 5 method
                    var modal = new bootstrap.Modal(document.getElementById('userModal'));
                    modal.show();
                } else {
                    alert('User not found!');
                }
            },
            error: function() {
                alert('Error fetching user details.');
            }
        });
    }

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
