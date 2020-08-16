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
                        <form role="form" id="categoryAddForm" action="{{ url('admin/add-category') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <!-- Name -->
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter category name" value="{{ old('name') }}">
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        </div>

                                        <!-- Section -->
                                        <div class="form-group">
                                            <label>Section</label>
                                            <select class="form-control select2 @error('section') is-invalid @enderror" style="width: 100%;" name="section" id="section">
                                                <option value="">Select Section</option>
                                                @foreach($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('section') }}</span>
                                        </div>

                                        <!-- Category -->
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control select2" style="width: 100%;" name="category" id="category">
                                                <option value="">Main Category</option>
                                            </select>
                                        </div>

                                        <!-- Description -->
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" rows="3" placeholder="Category description ...">{{ old('description') }}</textarea>
                                        </div>

                                        <!-- Meta Title -->
                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <textarea class="form-control" name="meta_title" rows="3" placeholder="Enter meta title..." >{{ old('meta_title') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <!-- Discount -->
                                        <div class="form-group">
                                            <label for="discount">Discount</label>
                                            <input type="text" name="discount" class="form-control @error('discount') is-invalid @enderror" id="discount" placeholder="0.00"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" value="{{ old('discount') }}">
                                            <span class="text-danger">{{ $errors->first('discount') }}</span>
                                        </div>

                                        <!-- Image -->
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text " id="">Upload</span>
                                                </div>
                                            </div>
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
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
                                            <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta description ...">{{ old('meta_description') }}</textarea>
                                        </div>

                                        <!-- Meta Keywords -->
                                        <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <textarea class="form-control" name="meta_keywords" rows="3" placeholder="Meta keywords ...">{{ old('meta_keywords') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add Category</button>
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
    $(document).ready(function() 
    {
        bsCustomFileInput.init();
    });
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2(
    {
        theme: 'bootstrap4'
    });

    $('#section').on('change', function() 
    {
        let sectionId = $(this).val();

        $.ajax(
        {
            method: "POST",
            url: "get-categories-by-section-wise",
            data: {
                "_token": "{{ csrf_token() }}",
                'sectionId': sectionId
            }
        })
        .done(function(response) 
        {
            // console.log(response); return false;
            if (response.success.status == 200) 
            {
                $options = '';

                $.each( response.success.categories, function( key, category ) {
                    $options += `
                        <option value="${category.id}">${category.name}</option>
                    `;
                });
                $('#category').html($options);                             
            } 
            else if (response.success.status == 400)
            {
                $('#category').html(`<option value="">Main Category</option>`);          
            }
        })
        .fail(function() {
            alert(response);
        });
    });
</script>
@endpush