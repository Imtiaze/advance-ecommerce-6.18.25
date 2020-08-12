@extends('layouts.admin_layout.admin_layout')

@push('custom-styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
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
        @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {!! \Session::get('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="card-header d-flex">
                <a href="{{ url('admin/add-category') }}" class="btn btn-success align-right ml-auto">Add category</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="category" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if ($category->status == 1)
                                <a class="badge badge-success updateCategoryStatus" id="category_{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)">Active</a>
                                @else
                                <a class="badge badge-danger updateCategoryStatus" id="category_{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)">Inactive</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </section>
    <!-- /.content -->
</div>
@endsection

@push('custom-scripts')
<!-- DataTables -->
<script src="{{ url('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

<script>
    $(function() {
        $("#category").DataTable();
    });

    $('.updateCategoryStatus').click(function() {
        let status    = $(this).text();
        let categoryId = $(this).attr('category_id');
        // alert(status + ' '+ categoryId);

        $.ajax({
            method: "POST",
            url: "update-category-status",
            data: {
                "_token"   : "{{ csrf_token() }}",
                'status'   : status,
                'categoryId': categoryId
            }
        })
        .done(function(response) {
            console.log(response);
            // alert(response.status + ' ' + response.sectionId);
            if (response.statusCode == 200) {
                if (response.status == 0)
                {
                    $('#category_'+response.categoryId).text('Inactive').removeClass('badge badge-success').addClass('badge badge-danger');
                }
                else {
                    $('#category_'+response.categoryId).text('Active').removeClass('badge badge-danger').addClass('badge badge-success');
                }
            }
        })
        .fail(function(response) {
            alert(response);
        });
    });
</script>
@endpush