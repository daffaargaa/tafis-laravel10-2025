@extends('layouts.index')

@section('body')
<div class="card-box pd-10 height-100-p mb-10">
    {{-- Title --}}
    <div class="p-2">
        <h6 class="title">Administrator > Master Reports</h6>
    </div>
</div>
{{-- Button --}}
<div class="p-2">
    <button class="btn btn-outline-primary btn-sm style1" data-toggle="modal" data-target="#createMasterReport">+ Add New</button>
</div>

<div class="p-2">
    <table id="namaTabel" class="table table-striped table-hover style1 nowrap display" width="100%">
        <thead class="thead-dark">
            <tr>
                <th>Report Name</th>
                <th>Description</th>
                <th>Connection</th>
                <th style="width: 15%;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
            <tr>
                <td>{{ $report['report_name'] }}</td>
                <td>{{ $report['description'] }}</td>
                <td>{{ $report['connection'] }}</td>
                <td>
                    <button class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#updateMasterReport{{ $report['id'] }}"><i class="fa fa-edit"></i></button>
                    <a href="{{ route('admin.master-reports.delete', ['id' => $report['id']]) }}" class="btn btn-danger btn-sm master-reports-delete" data-id="{{ $report['id'] }}" ><i class="fa fa-trash"></i></a>
                </td>
            </tr>

            <!-- Edit Master Report Modal -->
            <div class="modal fade updateMasterReport" id="updateMasterReport{{ $report['id'] }}" tabindex="-1" role="dialog" aria-labelledby="updateMasterReport" aria-hidden="true">
                <div class="modal-dialog modal-dialog-slideout" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title align-right" id="updateMasterReportLabel">Edit Report</h5>
                        </div>
                        <div class="modal-body">
                        <form action="{{ route('admin.master-reports.update') }}" method="post" id="masterReportsUpdateForm">
                            <input type="hidden" name="id" value="{{ $report['id'] }}">
                            @csrf
                            {{-- Report Name --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_report_name" class="col-form-label style1">Report Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control style1" name="report_name" id="u_report_name" placeholder="Input Report Name" data-placeholder="Report Name" value="{{ $report['report_name'] }}" required>
                                </div>                                
                            </div>

                            {{-- Description --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_description" class="col-form-label style1">Description</label>
                                </div>
                                <div class="col-md-8">
                                    <textarea class="form-control style1" name="description" id="u_description" cols="30" rows="10" placeholder="Input Description" required>{{ $report['description'] }}</textarea>
                                </div>                                
                            </div>

                            {{-- Connection --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_connection" class="col-form-label style1">Connection</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control style1" name="connection" id="u_connection">
                                        <option value="{{ $report['connection'] }}" hidden selected>{{ $report['connection'] }}</option>
                                        <option value="DW">DW</option>
                                        <option value="OIS">OIS</option>
                                    </select>
                                </div>                                
                            </div>

                            {{-- Query --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_query" class="col-form-label style1">Query</label>
                                </div>
                                <div class="col-md-8">
                                    <textarea class="form-control style1" name="query" id="u_query" cols="30" rows="10" placeholder="Input Query" required>{{ $report['query'] }}</textarea>
                                </div>                                
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            @endforeach

            <script>
                // Delete Confirmation
                document.querySelectorAll(".master-reports-delete").forEach(item => {
                    item.addEventListener('click', function(event) {
                        event.preventDefault();
                        const id = this.getAttribute('data-id');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You will not be able to recover this menu item!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            // If user confirms deletion, proceed with the deletion
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('admin.master-reports.delete') }}?id=" + id;
                            }
                        });
                    });
                });
            </script>
        </tbody>
    </table>
</div>

<!-- Create Report Modal -->
<div class="modal fade createMasterReport" id="createMasterReport" tabindex="-1" role="dialog" aria-labelledby="createMasterReport" aria-hidden="true">
	<div class="modal-dialog modal-dialog-slideout" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title align-right" id="createMasterReportsLabel">New Report</h5>
			</div>
			<div class="modal-body">
            <form action="{{ route('admin.master-reports.create') }}" method="post" id="masterReportsCreateForm">
                @csrf
                {{-- Report Name --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_report_name" class="col-form-label style1">Report Name</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control style1" name="report_name" id="c_report_name" placeholder="Input Report Name" data-placeholder="Report Name" required>
                    </div>                                
                </div>

                {{-- Description --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_description" class="col-form-label style1">Description</label>
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control style1" name="description" id="c_description" cols="30" rows="10" placeholder="Input Description" required></textarea>
                    </div>                                
                </div>

                {{-- Connection --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_connection" class="col-form-label style1">Connection</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control style1" name="connection" id="c_connection">
                            <option hidden selected>Select Connection</option>
                            <option value="DW">DW</option>
                            <option value="OIS">OIS</option>
                        </select>
                    </div>                                
                </div>

                {{-- Query --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_query" class="col-form-label style1">Query</label>
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control style1" name="query" id="c_query" cols="30" rows="10" placeholder="Input Query" required></textarea>
                    </div>                                
                </div>

            </div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary btn-sm">Submit</button>
				<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-dismiss="modal">Close</button>
			</div>
        </form>
		</div>
	</div>
</div>
@endsection

@section('script')
    <script>
        // Master Auth Group DataTable
        $(document).ready(function() {
             $('#namaTabel').DataTable({
                scrollX: true,
                lengthChange: false,
                pageLength: 100,
             });
        });
    </script>
@endsection