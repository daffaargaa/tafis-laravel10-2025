@extends('layouts.index')

@section('body')
<div class="card-box pd-10 height-100-p mb-10">
    {{-- Title --}}
    <div class="p-2">
        <h6 class="title">Administrator > Master Menus</h6>
    </div>
</div>
{{-- Button --}}
<div class="p-2">
    <button class="btn btn-outline-primary btn-sm style1" data-toggle="modal" data-target="#createMenus">+ Add New</button>
</div>
<div class="p-2">
    <table id="masterMenusTable" class="table table-striped table-hover style1 nowrap display" width="100%">
        <thead class="thead-dark">
            <tr>
                <th>Header</th>
                <th>Name</th>
                <th>URL</th>
                <th>Parent</th>
                <th>Order</th>
                <th>Icon</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($menus)
            @foreach ($menus as $menu)
            <tr>
                <td>{{ $menu['header'] }}</td>
                <td>{{ $menu['nama'] }}</td>
                <td>{{ $menu['url'] }}</td>
                <td>{{ $menu['parent_name'] }}</td>
                <td>{{ $menu['urutan'] }}</td>
                <td><i class="micon {{ $menu['ikon'] }}" style="font-size: 24px;"></i></td>
                <td>{{ $menu['tipe'] }}</td>
                <td>
                    <button class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#updateMenus{{ $menu['id'] }}"><i class="fa fa-edit"></i></button>
                    <a href="{{ route('admin.master-menus.delete', ['id' => $menu['id']]) }}" class="btn btn-danger btn-sm master-menus-delete" data-id="{{ $menu['id'] }}"><i class="fa fa-trash"></i></a>
                </td>
            </tr>

            <!-- Edit Menu Modal -->
            <div class="modal fade updateMenus" id="updateMenus{{ $menu['id'] }}" tabindex="-1" role="dialog" aria-labelledby="updateMenus" aria-hidden="true">
                <div class="modal-dialog modal-dialog-slideout" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title align-right" id="updateMenusLabel">Edit Menu</h5>
                        </div>
                        <div class="modal-body">
                        <form action="{{ route('admin.master-menus.update') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $menu['id'] }}" >
                            {{-- Tipe --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_type{{ $menu['id'] }}" class="col-form-label style1">Type</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" name="type" value="{{ $menu['tipe'] }}">
                                    <select class="form-control style1" name="type" id="u_type{{ $menu['id'] }}" disabled>
                                        <option value="{{ $menu['tipe'] }}" hidden selected>{{ ucfirst($menu['tipe']) }}</option>
                                        <option value="header">Header</option>
                                        <option value="submenu">Submenu</option>
                                        <option value="menu">Menu</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Header --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_header{{ $menu['id'] }}" class="col-form-label style1">Header</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control style1" name="header" id="u_header{{ $menu['id'] }}" placeholder="Input Header" value="{{ $menu['header'] }}" required>
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_name{{ $menu['id'] }}" class="col-form-label style1">Menu Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control style1" name="name" id="u_name{{ $menu['id'] }}" placeholder="Input Name" value="{{ $menu['nama'] }}" required>
                                </div>
                            </div>

                            {{-- Url --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_url{{ $menu['id'] }}" class="col-form-label style1">URL</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control style1" name="url" id="u_url{{ $menu['id'] }}" placeholder="Input URL" value="{{ $menu['url'] }}" required>
                                </div>
                            </div>

                            {{-- Parent --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_parent_id{{ $menu['id'] }}" class="col-form-label style1">Parent</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control style1" name="parent_id" id="u_parent_id{{ $menu['id'] }}">
                                        <option value="{{ $menu['parent_id'] }}" hidden selected>{{ $menu['parent_name'] }}</option>
                                        @if ($parents)
                                        @foreach ($parents as $parent)
                                            <option value="{{ $parent['id'] }}">{{ $parent['header'] }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            {{-- Order --}} 
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_order{{ $menu['id'] }}" class="col-form-label style1">Order</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" class="form-control style1" name="order" id="u_order{{ $menu['id'] }}" placeholder="Input Order" value="{{ $menu['urutan'] }}" required>
                                </div>
                            </div>

                            {{-- Icon --}} 
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_icon{{ $menu['id'] }}" class="col-form-label style1">Icon</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control style1" name="icon" id="u_icon{{ $menu['id'] }}" placeholder="Input Icon Class" value="{{ $menu['ikon'] }}" required>
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

            <script>
                const uType{{ $menu['id'] }} = document.getElementById("u_type{{ $menu['id'] }}");
                const uHeader{{ $menu['id'] }} = document.getElementById("u_header{{ $menu['id'] }}");
                const uName{{ $menu['id'] }} = document.getElementById("u_name{{ $menu['id'] }}");
                const uUrl{{ $menu['id'] }} = document.getElementById("u_url{{ $menu['id'] }}");
                const uParentId{{ $menu['id'] }} = document.getElementById("u_parent_id{{ $menu['id'] }}");
                const uOrder{{ $menu['id'] }} = document.getElementById("u_order{{ $menu['id'] }}");
                const uIcon{{ $menu['id'] }} = document.getElementById("u_icon{{ $menu['id'] }}");
                
                if (uType{{ $menu['id'] }}.value === 'header') {
                    uHeader{{ $menu['id'] }}.disabled = false;
                    uName{{ $menu['id'] }}.disabled = true;
                    uUrl{{ $menu['id'] }}.disabled = true;
                    uParentId{{ $menu['id'] }}.disabled = true;
                    uOrder{{ $menu['id'] }}.disabled = true;

                    uName{{ $menu['id'] }}.placeholder = '';
                    uUrl{{ $menu['id'] }}.placeholder = '';
                    uParentId{{ $menu['id'] }}.placeholder = '';
                    uOrder{{ $menu['id'] }}.placeholder = '';
                }
                else if (uType{{ $menu['id'] }}.value === 'submenu') {
                    uHeader{{ $menu['id'] }}.disabled = true;
                    uName{{ $menu['id'] }}.disabled = false;
                    uUrl{{ $menu['id'] }}.disabled = false;
                    uParentId{{ $menu['id'] }}.disabled = false;
                    uOrder{{ $menu['id'] }}.disabled = false;

                    uHeader{{ $menu['id'] }}.placeholder = '';
                }
                else {
                    uHeader{{ $menu['id'] }}.disabled = true;
                    uName{{ $menu['id'] }}.disabled = false;
                    uUrl{{ $menu['id'] }}.disabled = false;
                    uParentId{{ $menu['id'] }}.disabled = true;
                    uOrder{{ $menu['id'] }}.disabled = true;

                    uHeader{{ $menu['id'] }}.placeholder = '';
                    uParentId{{ $menu['id'] }}.placeholder = '';
                    uOrder{{ $menu['id'] }}.placeholder = '';
                }

                uType{{ $menu['id'] }}.addEventListener("change", () => {
                    const toggleDisabled = (elements, state) => {
                        elements.forEach(element => element.disabled = state);
                    };

                    if (uType{{ $menu['id'] }}.value === 'header') {
                        toggleDisabled([uHeader{{ $menu['id'] }}], false);
                        toggleDisabled([uName{{ $menu['id'] }}, uUrl{{ $menu['id'] }}, uParentId{{ $menu['id'] }}, uOrder{{ $menu['id'] }}], true);
                    } else if (uType{{ $menu['id'] }}.value === 'submenu') {
                        toggleDisabled([uHeader{{ $menu['id'] }}], true);
                        toggleDisabled([uName{{ $menu['id'] }}, uUrl{{ $menu['id'] }}, uParentId{{ $menu['id'] }}, uOrder{{ $menu['id'] }}], false);
                    } else {
                        toggleDisabled([uHeader{{ $menu['id'] }}, uParentId{{ $menu['id'] }}, uOrder{{ $menu['id'] }}], true);
                        toggleDisabled([uName{{ $menu['id'] }}], uUrl{{ $menu['id'] }}, false);
                    }
                });

                // Delete Confirmation
                document.querySelectorAll(".master-menus-delete").forEach(item => {
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
                                window.location.href = "{{ route('admin.master-menus.delete') }}?id=" + id;
                            }
                        });
                    });
                });
                
            </script>
            <!-- End Edit Menu Modal -->



            @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- Create Menu Modal -->
<div class="modal fade createMenus" id="createMenus" tabindex="-1" role="dialog" aria-labelledby="createMenus" aria-hidden="true">
	<div class="modal-dialog modal-dialog-slideout" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title align-right" id="createMenusLabel">New Menu</h5>
			</div>
			<div class="modal-body">
			<form action="{{ route('admin.master-menus.create') }}" method="post">
                @csrf
                {{-- Tipe --}}
				<div class="row g-3 align-items-center mb-3">
					<div class="col-md-4">
						<label for="c_type" class="col-form-label style1">Type</label>
					</div>
					<div class="col-md-8">
						<select class="form-control style1" name="type" id="c_type" required>
							<option selected hidden>Select Type</option>
							<option value="header">Header</option>
							<option value="submenu">Submenu</option>
							<option value="menu">Menu</option>
						</select>
					</div>
				</div>

                {{-- Header --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_header" class="col-form-label style1">Header</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control style1" name="header" id="c_header" placeholder="Input Header" data-placeholder="Header" required>
                    </div>
                </div>

                {{-- Name --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_name" class="col-form-label style1">Menu Name</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control style1" name="name" id="c_name" placeholder="Input Name" data-placeholder="Name" required>
                    </div>
                </div>

                {{-- Url --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_url" class="col-form-label style1">URL</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control style1" name="url" id="c_url" placeholder="Input URL" data-placeholder="URL" required>
                    </div>
                </div>

                {{-- Parent --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_parent_id" class="col-form-label style1">Parent</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control style1" name="parent_id" id="c_parent_id">
                            <option hidden selected>Select Parent</option>
                            @if ($parents)
                            @foreach ($parents as $parent)
                                <option value="{{ $parent['id'] }}">{{ $parent['header'] }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                {{-- Order --}} 
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_order" class="col-form-label style1">Order</label>
                    </div>
                    <div class="col-md-8">
                        <input type="number" class="form-control style1" name="order" id="c_order" placeholder="Input Order" data-placeholder="Order" required>
                    </div>
                </div>

                {{-- Icon --}} 
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="c_icon" class="col-form-label style1">Icon</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control style1" name="icon" id="c_icon" placeholder="Input Icon Class" data-placeholder="Icon" required>
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
        const cType = document.getElementById("c_type");
        const cHeader = document.getElementById("c_header");
        const cName = document.getElementById("c_name");
        const cUrl = document.getElementById("c_url");
        const cParentId = document.getElementById("c_parent_id");
        const cOrder = document.getElementById("c_order");
        const cIcon = document.getElementById("c_icon");

        cType.addEventListener("change", () => {
            const toggleDisabled = (elements, state) => {
                elements.forEach(element => element.disabled = state);
            };

            const togglePlaceholder = (elements, state) => {

                if (!state) {
                    elements.forEach(element => element.placeholder = '');
                }
                else {
                    elements.forEach(element => {
                        let dataPlaceholder = element.getAttribute('data-placeholder');
                        element.placeholder = "Input " + dataPlaceholder;
                    });
                }
            }
            
            // Belajar Front End
            if (cType.value === 'header') {

                cParentId.selectedIndex = 0;

                togglePlaceholder([cHeader], true);
                togglePlaceholder([cName, cUrl, cParentId, cOrder], false);

                toggleDisabled([cHeader], false);
                toggleDisabled([cName, cUrl, cParentId, cOrder], true);

            } else if (cType.value === 'submenu') {

                togglePlaceholder([cHeader], false);
                togglePlaceholder([cName, cUrl, cParentId, cOrder], true);

                toggleDisabled([cHeader], true);
                toggleDisabled([cName, cUrl, cParentId, cOrder], false);

            } else {

                cParentId.selectedIndex = 0;

                togglePlaceholder([cHeader, cParentId, cOrder], false);
                togglePlaceholder([cName, cUrl], true);

                toggleDisabled([cHeader, cParentId, cOrder], true);
                toggleDisabled([cName, cUrl], false);

            }

            cParentId.options[0].text = cParentId.disabled === true ? "" : "Select Parent";
        });
        
        // DataTable Initialization
        $(document).ready(function() {
             $('#masterMenusTable').DataTable({
                scrollX: true,
                order: [
                    [0, 'desc'], 
                    [3, 'asc']
                ],
                lengthChange: false,
                pageLength: 100,
             });
         });
    </script>
@endsection