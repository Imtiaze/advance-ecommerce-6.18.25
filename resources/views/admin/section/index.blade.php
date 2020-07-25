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
                    <h1>Sections</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Sectinons</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card">
            <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">
                <table id="section" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->id }}</td>
                            <td>{{ $section->name }}</td>
                            <td>
                                @if ($section->status == 1)
                                <a class="badge badge-success updateSectionStatus" id="section_{{ $section->id }}" section_id="{{ $section->id }}" href="javascript:void(0)">Active</a>
                                @else
                                <a class="badge badge-danger updateSectionStatus" id="section_{{ $section->id }}" section_id="{{ $section->id }}" href="javascript:void(0)">Inactive</a>
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
        $("#section").DataTable();
    });

    $('.updateSectionStatus').click(function() {
        let status    = $(this).text();
        let sectionId = $(this).attr('section_id');
        // alert(status + ' '+ sectionId);

        $.ajax({
            method: "POST",
            url: "update-section-status",
            data: {
                "_token"   : "{{ csrf_token() }}",
                'status'   : status,
                'sectionId': sectionId
            }
        })
        .done(function(response) {
            console.log(response);
            // alert(response.status + ' ' + response.sectionId);
            if (response.statusCode == 200) {
                if (response.status == 0)
                {
                    $('#section_'+response.sectionId).text('Inactive').removeClass('badge badge-success').addClass('badge badge-danger');
                }
                else {
                    $('#section_'+response.sectionId).text('Active').removeClass('badge badge-danger').addClass('badge badge-success');
                }
            }
        })
        .fail(function() {
            alert(response);
        });
    });
</script>
@endpush