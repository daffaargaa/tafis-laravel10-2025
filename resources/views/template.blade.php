@extends('layouts.index')

@section('body')
<div class="card-box pd-10 height-100-p mb-10">
    {{-- Title --}}
    <div class="p-2">
        <h6 class="title">Administrator > Judul Menu</h6>
    </div>
</div>
{{-- Button --}}
<div class="p-2">
    <button class="btn btn-outline-primary btn-sm style1" data-toggle="modal" data-target="#namaModal">+ Add New</button>
</div>

<div class="p-2">
    <table id="namaTabel" class="table table-striped table-hover style1 nowrap display" width="100%">
        <thead class="thead-dark">
            <tr>
                <th>Column</th>
                <th style="width: 15%;">Action</th>
            </tr>
        </thead>
        <tbody>
            <td>Column</td>
            <td>
                <button class="btn btn-outline-secondary btn-sm"></button>
            </td>

            <script>
                // Delete Confirmation
                document.querySelectorAll(".master-auth-groups-delete").forEach(item => {
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
                                window.location.href = "{{ route('admin.master-auth-groups.delete') }}?id=" + id;
                            }
                        });
                    });
                });
            </script>
        </tbody>
    </table>
</div>

<!-- Create Menu Modal -->
<div class="modal fade createAuthGroups" id="namaModal" tabindex="-1" role="dialog" aria-labelledby="createAuthGroups" aria-hidden="true">
	<div class="modal-dialog modal-dialog-slideout" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title align-right" id="createAuthGroupsLabel">Judul</h5>
			</div>
			<div class="modal-body">
			
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary btn-sm">Submit</button>
				<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-dismiss="modal">Close</button>
			</div>

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