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
                        <form role="form">
                            <div class="card-body">
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="name">Admin Name</label>
                                    <input type="text" name="name" value="{{ $adminDetails->name }}" class="form-control" id="name" placeholder="Enter name">
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" value="{{ $adminDetails->email }}" class="form-control" readonly>
                                </div>

                                <!-- Current Password -->
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword" placeholder="Enter Current Password">
                                </div>

                                <!-- New Password -->
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Enter New Password">
                                </div>

                                <!-- Confirm New Password -->
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm New Password">
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

            </div>
            <!-- /.row -->
        </div>

    </section>
    <!-- /.content -->
</div>
@endsection