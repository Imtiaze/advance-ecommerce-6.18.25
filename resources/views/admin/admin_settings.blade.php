@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {!! \Session::get('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @elseif (\Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {!! \Session::get('error') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="adminSettingForm" method="POST" action="{{ url('admin/update-admin-password') }}">
                            @csrf
                            <div class="card-body">

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" value="{{ $adminDetails->email }}" class="form-control" readonly>
                                </div>

                                <!-- Type -->
                                <div class="form-group">
                                    <label for="email">Type</label>
                                    <input type="text" value="{{ $adminDetails->type }}" class="form-control" readonly>
                                </div>

                                <!-- Current Password -->
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" name="currentPassword" class="form-control" id="currentPassword" placeholder="Enter Current Password">
                                    <span class="password-check"></span>
                                </div>

                                <!-- New Password -->
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter New Password">
                                    @error('password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm New Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm New Password">
                                    @error('password_confirmation')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <div class="col-md-6">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if (empty($adminDetails->image))
                                <img class="profile-user-img img-fluid img-circle" src="{{ url('images/admin_image/avatar5.png')}}" alt="User profile picture">
                                @else
                                <img class="profile-user-img img-fluid img-circle" src="{{ url('images/admin_image/profile/' . $adminDetails->image)}}" alt="User profile picture">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $adminDetails->name }}</h3>

                            <!-- <p class="text-muted text-center">Software Engineer</p> -->

                            <hr>

                            <form role="form" method="POST" action="{{ url('admin/update-admin-details') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{ $adminDetails->name }}" class="form-control @error('name') is-invalid @enderror" id="name">
                                    @error('name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" name="mobile" value="{{ $adminDetails->mobile }}" class="form-control" id="mobile">
                                </div>
                                <div class="form-group">
                                    <label for="photo">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="photo" class="custom-file-input @error('photo') is-invalid @enderror" id="photo">
                                            <label class="custom-file-label" for="photo">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">Upload</span>
                                        </div>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block"><b>Update Profile</b></button>
                            </form>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.row -->
            </div>

    </section>
    <!-- /.content -->
</div>
@endsection


@push('custom-scripts')

<!-- bs-custom-file-input -->
<script src="{{ url('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });

    $(document).ready(function() {
        $('#currentPassword').on('keyup', '', function() {
            let currentPassword = $(this).val();
            // console.log(currentPassword);

            $.ajax({
                    method: "POST",
                    url: "check-current-password",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'currentPassword': currentPassword
                    }
                })
                .done(function(response) {
                    // console.log(response);
                    if (response.success.status == true) {
                        $('.password-check').html('<strong class="text-success">' + response.success.message + '</strong>');
                    } else {
                        $('.password-check').html('<strong class="text-danger">' + response.success.message + '</strong>');
                    }
                })
                .fail(function() {
                    alert(response);
                });
        });
    });
</script>
@endpush