@extends('layouts.index')

@section('body')
    <div class="card-box pd-10 height-100-p mb-10">
        {{-- Title --}}
        <div class="p-2">
            <h6 class="title">Administrator > Master Auth Groups</h6>
        </div>
    </div>
    {{-- Button --}}
    <div class="p-2">
        <button class="btn btn-outline-primary btn-sm style1" data-toggle="modal" data-target="#createAuthGroups">+ Add
            New</button>
    </div>

    <div class="p-2">
        <table id="masterAuthGroupsTable" class="table table-striped table-hover style1 nowrap display" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th>Group</th>
                    <th>Menus</th>
                    <th>Reports</th>
                    <th style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                    <tr>
                        <td>{{ $group['group_name'] }}{{ $group['id'] }}</td>
                        <td>
                            @if ($group['group_name'] != null)
                                @php
                                    $listMenus = explode(',', $group['menus']);
                                    $countMenu = 0;
                                @endphp
                                @foreach ($listMenus as $menu)
                                    <span id="master-auth-groups-menus-reports">{{ $menu }}</span>
                                    @php
                                        $countMenu++;
                                        echo $countMenu % 6 == 0 ? '<br><br>' : '';
                                    @endphp
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($group['reports'] != null)
                                @php
                                    $listReports = explode(',', $group['reports']);
                                    $countReport = 0;
                                @endphp
                                @foreach ($listReports as $report)
                                    <span id="master-auth-groups-menus-reports">{{ $report }}</span>
                                    @php
                                        $countReport++;
                                        echo $countReport % 6 == 0 ? '<br><br>' : '';
                                    @endphp
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-outline-info btn-sm" data-toggle="modal"
                                data-target="#updateUsersAuthGroup{{ $group['id'] }}"><i class="fa fa-user"></i></button>
                            <button class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                data-target="#updateAuthGroup{{ $group['id'] }}"><i class="fa fa-edit"></i></button>
                            <a href="{{ route('admin.master-auth-groups.delete', ['id' => $group['id']]) }}"
                                class="btn btn-danger btn-sm master-auth-groups-delete" data-id="{{ $group['id'] }}"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach

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
                                    window.location.href =
                                        "{{ route('admin.master-auth-groups.delete') }}?id=" + id;
                                }
                            });
                        });
                    });
                </script>
            </tbody>
        </table>
    </div>

    <!-- Create Menu Modal -->
    <div class="modal fade createAuthGroups" id="createAuthGroups" tabindex="-1" role="dialog"
        aria-labelledby="createAuthGroups" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title align-right" id="createAuthGroupsLabel">New Auth Group</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.master-auth-groups.create') }}" method="post"
                        id="masterAuthGroupsCreateForm">
                        @csrf
                        {{-- Auth Group Name --}}
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-md-4">
                                <label for="c_auth_group_name" class="col-form-label style1">Auth Group Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control style1" name="auth_group_name"
                                    id="c_auth_group_name" placeholder="Input Auth Group Name"
                                    data-placeholder="Auth Group Name" required>
                            </div>
                        </div>

                        {{-- Menus DataTable --}}
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-md-12">
                                <label for="col-form-label style1">Menus List</label>
                            </div>
                            <div class="col-md-12">
                                <table id="menusDataTable" class="table table-striped table-hover style1 nowrap display">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAllMenusDataTable"></th>
                                            <th>Menu</th>
                                            <th>Parent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menus as $menu)
                                            <tr>
                                                <td><input type="checkbox" class="rowCheckboxMenusDataTable"></td>
                                                <td data-id="{{ $menu['id'] }}">{{ $menu['nama'] }}</td>
                                                <td>{{ $menu['parent_name'] === null ? '-' : $menu['parent_name'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Reports DataTable --}}
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-md-12">
                                <label for="col-form-label style1">Reports List</label>
                            </div>
                            <div class="col-md-12">
                                <table id="reportsDataTable" class="table table-striped table-hover style1 nowrap display">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAllReportsDataTable"></th>
                                            <th>Report</th>
                                            <th>Descripton</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reports as $report)
                                            <tr>
                                                <td><input type="checkbox" class="rowCheckboxReportsDataTable"></td>
                                                <td data-id="{{ $report['id'] }}">{{ $report['report_name'] }}</td>
                                                <td>{{ $report['description'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
                <input type="hidden" name="menus" id="masterAuthGroupsMenusSelectedRows">
                <input type="hidden" name="reports" id="masterAuthGroupsReportsSelectedRows">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                        data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($groups as $group)
        <style>
            #usersDataTable<?php echo $group['id']; ?>_filter label {
                font-size: 0px;
            }

            #usersDataTable<?php echo $group['id']; ?> th,
            #usersDataTable<?php echo $group['id']; ?> td {
                font-size: 13px;
            }

            #usersDataTable<?php echo $group['id']; ?>_info,
            #usersDataTable<?php echo $group['id']; ?>_paginate li {
                font-size: 13px;
            }

            #authGroupDataTable<?php echo $group['id']; ?>_filter label {
                font-size: 0px;
            }

            #authGroupDataTable<?php echo $group['id']; ?> th,
            #authGroupDataTable<?php echo $group['id']; ?> td {
                font-size: 13px;
            }

            #authGroupDataTable<?php echo $group['id']; ?>_info,
            #authGroupDataTable<?php echo $group['id']; ?>_paginate li {
                font-size: 13px;
            }

            #menusDataTable<?php echo $group['id']; ?>_filter label {
                font-size: 0px;
            }

            #menusDataTable<?php echo $group['id']; ?> th,
            #menusDataTable<?php echo $group['id']; ?> td {
                font-size: 13px;
            }

            #menusDataTable<?php echo $group['id']; ?>_info,
            #menusDataTable<?php echo $group['id']; ?>_paginate li {
                font-size: 13px;
            }

            #reportsDataTable<?php echo $group['id']; ?>_filter label {
                font-size: 0px;
            }

            #reportsDataTable<?php echo $group['id']; ?> th,
            #reportsDataTable<?php echo $group['id']; ?> td {
                font-size: 13px;
            }

            #reportsDataTable<?php echo $group['id']; ?>_info,
            #reportsDataTable<?php echo $group['id']; ?>_paginate li {
                font-size: 13px;
            }
        </style>

        <!-- Edit Users Modal -->
        <div class="modal fade updateUsersAuthGroup" id="updateUsersAuthGroup{{ $group['id'] }}" tabindex="-1"
            role="dialog" aria-labelledby="updateUsersAuthGroup" aria-hidden="true">
            <div class="modal-dialog modal-dialog-slideout" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title align-right" id="updateUsersAuthGroupLabel">Edit Users Group</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.master-auth-groups.update-users') }}" method="post"
                            id="masterAuthGroupsUsersForm{{ $group['id'] }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $group['id'] }}">

                            {{-- Users DataTable --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-12">
                                    <label for="col-form-label style1">Users List</label>
                                </div>
                                <div class="col-md-12">
                                    <table id="usersDataTable{{ $group['id'] }}"
                                        class="table table-striped table-hover style1 nowrap display updateUsersAuthGroup">
                                        <thead>
                                            <tr>
                                                <th>
                                                    {{-- <input type="checkbox" id="selectAllUsersDataTable{{ $group['id'] }}"> --}}
                                                </th>
                                                <th>NIK</th>
                                                <th>Name</th>
                                                <th>Branch</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="rowCheckboxUsersDataTable{{ $group['id'] }}"
                                                            @php
echo in_array($user['nik'], explode(',', $group['users'])) ? 'checked' : ''; @endphp>
                                                        <span style="display: none;">
                                                            @php
                                                                echo in_array(
                                                                    $user['nik'],
                                                                    explode(',', $group['users']),
                                                                )
                                                                    ? '1'
                                                                    : '';
                                                            @endphp
                                                        </span>
                                                    </td>
                                                    <td data-id="{{ $user['nik'] }}">{{ $user['nik'] }}</td>
                                                    <td>{{ $user['nama'] }}</td>
                                                    <td>{{ $user['kd_branch'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                    </div>
                    <input type="hidden" name="users" id="masterAuthGroupsUsersSelectedRows{{ $group['id'] }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                            data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Auth Group Modal -->
        <div class="modal fade updateAuthGroup" id="updateAuthGroup{{ $group['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="updateAuthGroup" aria-hidden="true">
            <div class="modal-dialog modal-dialog-slideout" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title align-right" id="updateAuthGroupLabel">Edit Auth Group</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.master-auth-groups.update-auth-group') }}" method="post"
                            id="masterAuthGroupsUpdateForm{{ $group['id'] }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $group['id'] }}">
                            {{-- Auth Group Name --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-4">
                                    <label for="u_auth_group_name" class="col-form-label style1">Auth Group Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control style1" name="auth_group_name"
                                        id="u_auth_group_name" placeholder="Input Auth Group Name"
                                        data-placeholder="Auth Group Name" value="{{ $group['group_name'] }}" required>
                                </div>
                            </div>

                            {{-- Menus DataTable --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-12">
                                    <label for="col-form-label style1">Menus List</label>
                                </div>
                                <div class="col-md-12">
                                    <table id="menusDataTable{{ $group['id'] }}"
                                        class="table table-striped table-hover style1 nowrap display">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox"
                                                        id="selectAllMenusDataTable{{ $group['id'] }}"></th>
                                                <th>Menu</th>
                                                <th>Parent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($menus as $menu)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="rowCheckboxMenusDataTable{{ $group['id'] }}"
                                                            @php
echo in_array($menu['nama'], explode(',', $group['menus'])) ? 'checked' : ''; @endphp>
                                                        <span style="display: none;">
                                                            @php
                                                                echo in_array(
                                                                    $menu['nama'],
                                                                    explode(',', $group['menus']),
                                                                )
                                                                    ? '1'
                                                                    : '';
                                                            @endphp
                                                        </span>
                                                    </td>
                                                    <td data-id="{{ $menu['id'] }}">{{ $menu['nama'] }}</td>
                                                    <td>{{ $menu['parent_name'] === null ? '-' : $menu['parent_name'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Reports DataTable --}}
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-12">
                                    <label for="col-form-label style1">Reports List</label>
                                </div>
                                <div class="col-md-12">
                                    <table id="reportsDataTable{{ $group['id'] }}"
                                        class="table table-striped table-hover style1 nowrap display">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox"
                                                        id="selectAllReportsDataTable{{ $group['id'] }}"></th>
                                                <th>Report</th>
                                                <th>Descripton</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reports as $report)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="rowCheckboxReportsDataTable{{ $group['id'] }}"
                                                            @php
echo in_array($report['report_name'], explode(',', $group['reports'])) ? 'checked' : ''; @endphp>
                                                        <span style="display: none;">
                                                            @php
                                                                echo in_array(
                                                                    $report['report_name'],
                                                                    explode(',', $group['reports']),
                                                                )
                                                                    ? '1'
                                                                    : '';
                                                            @endphp
                                                    </td>
                                                    <td data-id="{{ $report['id'] }}">{{ $report['report_name'] }}</td>
                                                    <td>{{ $report['description'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                    </div>
                    <input type="hidden" name="menus"
                        id="masterAuthGroupsUpdateMenusSelectedRows{{ $group['id'] }}">
                    <input type="hidden" name="reports"
                        id="masterAuthGroupsUpdateReportsSelectedRows{{ $group['id'] }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                            data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Script untuk Edit Users dan Edit Auth Group -->
        <script>
            $(document).ready(function() {
                let usersDataTable{{ $group['id'] }} = $('#usersDataTable{{ $group['id'] }}').DataTable({
                    lengthChange: false,
                    pageLength: 10,
                    order: [
                        [0, 'desc']
                    ],
                });

                let menusDataTable{{ $group['id'] }} = $('#menusDataTable{{ $group['id'] }}').DataTable({
                    lengthChange: false,
                    pageLength: 10,
                    order: [
                        [0, 'desc']
                    ],
                });

                let reportsDataTable{{ $group['id'] }} = $('#reportsDataTable{{ $group['id'] }}').DataTable({
                    lengthChange: false,
                    pageLength: 10,
                    order: [
                        [0, 'desc']
                    ],
                });


                $('#selectAllMenusDataTable{{ $group['id'] }}').on('change', function() {
                    let checkboxes = menusDataTable{{ $group['id'] }}.cells().nodes().to$().find(
                        '.rowCheckboxMenusDataTable{{ $group['id'] }}');
                    checkboxes.prop('checked', this.checked);
                });

                $('#selectAllReportsDataTable{{ $group['id'] }}').on('change', function() {
                    let checkboxes = reportsDataTable{{ $group['id'] }}.cells().nodes().to$().find(
                        '.rowCheckboxReportsDataTable{{ $group['id'] }}');
                    checkboxes.prop('checked', this.checked);
                });


                // Handle Form Submission for Edit Users Group
                $('#masterAuthGroupsUsersForm{{ $group['id'] }}').on('submit', function(event) {
                    let selectedRowsUsers = [];

                    usersDataTable{{ $group['id'] }}.rows().every(function() {
                        let row = this.node();
                        let checkbox = $(row).find(
                            '.rowCheckboxUsersDataTable{{ $group['id'] }}:checked');
                        if (checkbox.length) {
                            let rowData = {
                                id: $(row).find('td[data-id]').data('id'),
                            };
                            selectedRowsUsers.push(rowData);
                        }
                    });
                    $('#masterAuthGroupsUsersSelectedRows{{ $group['id'] }}').val(JSON.stringify(
                        selectedRowsUsers));

                });

                // Handle Form Submission for Edit Auth Group
                $('#masterAuthGroupsUpdateForm{{ $group['id'] }}').on('submit', function(event) {
                    let selectedRowsMenus = [];
                    let selectedRowsReports = [];

                    menusDataTable{{ $group['id'] }}.rows().every(function() {
                        let row = this.node();
                        let checkbox = $(row).find(
                            '.rowCheckboxMenusDataTable{{ $group['id'] }}:checked');
                        if (checkbox.length) {
                            let rowData = {
                                id: $(row).find('td[data-id]').data('id'),
                            };
                            selectedRowsMenus.push(rowData);
                        }
                    });

                    reportsDataTable{{ $group['id'] }}.rows().every(function() {
                        let row = this.node();
                        let checkbox = $(row).find(
                            '.rowCheckboxReportsDataTable{{ $group['id'] }}:checked');
                        if (checkbox.length) {
                            let rowData = {
                                id: $(row).find('td[data-id]').data('id'),
                            };
                            selectedRowsReports.push(rowData);
                        }
                    });

                    $('#masterAuthGroupsUpdateMenusSelectedRows{{ $group['id'] }}').val(JSON.stringify(
                        selectedRowsMenus));
                    $('#masterAuthGroupsUpdateReportsSelectedRows{{ $group['id'] }}').val(JSON.stringify(
                        selectedRowsReports));

                });
            });
        </script>
    @endforeach
@endsection

@section('script')
    <script>
        // Master Auth Group DataTable
        $(document).ready(function() {
            $('#masterAuthGroupsTable').DataTable({
                scrollX: true,
                lengthChange: false,
                pageLength: 10
            });

            // Initialize Menus DataTable for Add New Modal
            // Menus
            let menusDataTable = $('#menusDataTable').DataTable({
                lengthChange: false,
                pageLength: 10,
            });

            $('#selectAllMenusDataTable').on('change', function() {
                let checkboxes = menusDataTable.cells().nodes().to$().find('.rowCheckboxMenusDataTable');
                checkboxes.prop('checked', this.checked);
            });

            // Reports
            let reportsDataTable = $('#reportsDataTable').DataTable({
                lengthChange: false,
                pageLength: 10,
            });

            $('#selectAllReportsDataTable').on('change', function() {
                let checkboxes = reportsDataTable.cells().nodes().to$().find(
                    '.rowCheckboxReportsDataTable');
                checkboxes.prop('checked', this.checked);
            });

            // Handle form submission
            $('#masterAuthGroupsCreateForm').on('submit', function(event) {
                let selectedRowsMenus = [];
                let selectedRowsReports = [];

                menusDataTable.rows().every(function() {
                    let row = this.node();
                    let checkbox = $(row).find('.rowCheckboxMenusDataTable:checked');
                    if (checkbox.length) {
                        let rowData = {
                            id: $(row).find('td[data-id]').data('id'),
                        };
                        selectedRowsMenus.push(rowData);
                    }
                });

                reportsDataTable.rows().every(function() {
                    let row = this.node();
                    let checkbox = $(row).find('.rowCheckboxReportsDataTable:checked');
                    if (checkbox.length) {
                        let rowData = {
                            id: $(row).find('td[data-id]').data('id'),
                        };
                        selectedRowsReports.push(rowData);
                    }
                });

                $('#masterAuthGroupsMenusSelectedRows').val(JSON.stringify(selectedRowsMenus));
                $('#masterAuthGroupsReportsSelectedRows').val(JSON.stringify(selectedRowsReports));

            });
        });
    </script>
@endsection
