@extends('layouts.admin_layout.admin_layout')

@push('custom-styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ url('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Categories</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <!-- Name -->
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter category name">
                                        </div>

                                        <!-- Section -->
                                        <div class="form-group">
                                            <label>Section</label>
                                            <select class="form-control select2" style="width: 100%;" name="section">
                                                <option selected="selected">Select Section</option>
                                                <option>Alaska</option>
                                                <option>California</option>
                                                <option>Delaware</option>
                                                <option>Tennessee</option>
                                                <option>Texas</option>
                                                <option>Washington</option>
                                            </select>
                                        </div>

                                        <!-- Category -->
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control select2" style="width: 100%;" name="category">
                                                <option selected="selected">Main Category</option>
                                                <option>Alaska</option>
                                                <option>California</option>
                                                <option>Delaware</option>
                                                <option>Tennessee</option>
                                                <option>Texas</option>
                                                <option>Washington</option>
                                            </select>
                                        </div>

                                        <!-- Description -->
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" rows="3" placeholder="Category description ..."></textarea>
                                        </div>

                                        <!-- Meta Title -->
                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <textarea class="form-control" name="meta_title" rows="3" placeholder="Enter meta title..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <!-- Discount -->
                                        <div class="form-group">
                                            <label for="discount">Discount</label>
                                            <input type="number" name="discount" class="form-control" id="discount" placeholder="0.00">
                                        </div>

                                        <!-- Image -->
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2" style="width: 100%;" name="status">
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="form-group">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta description ..."></textarea>
                                        </div>

                                        <!-- Meta Keywords -->
                                        <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <textarea class="form-control" name="meta_keywords" rows="3" placeholder="Meta keywords ..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@push('custom-scripts')

<!-- bs-custom-file-input -->
<script src="{{ url('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ url('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
@endpush