@extends('layouts.app')
@push('css')
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/scroller/2.0.5/css/scroller.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchbuilder/1.3.0/css/searchBuilder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css" rel="stylesheet">

@endpush
@section('content')
    <div class="container">

        <button type="button" class="btn btn-primary float-end mb-5" data-bs-toggle="modal" data-bs-target="#addPharmacy">
            New Pharmacy
        </button>

        <table id="table" class="display nowrap  table table-responsive">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>location</th>
                    <th>address</th>
                    <th>delivery</th>
                    <th>Images</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="addPharmacy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Pharmacy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="add-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude">
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="delivery" name="delivery">
                            <label class="form-check-label" for="delivery">Has Delivery</label>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-add" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="editPharmacy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pharmacy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="edit-form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="edit_longitude" name="longitude">
                        </div>
                        <div class="mb-3">
                            <label for="edit_latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="edit_latitude" name="latitude">
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="edit_phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="edit_images" class="form-label">Images</label>
                            <input type="file" class="form-control" id="edit_images" name="images[]" multiple>
                        </div>
                        <div class="mb-3">
                            <label for="edit_logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="edit_logo" name="logo">
                        </div>
                        <div class="mb-3">
                            <label for="edit_address" class="form-label">Address</label>
                            <textarea class="form-control" id="edit_address" name="address"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="edit_delivery" name="delivery">
                            <label class="form-check-label" for="edit_delivery">Has Delivery</label>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-edit" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script>
        function renderLogo(data){
            return '<img src="'+data+'" height="90" width="90" />'
        }

        function renderImages(data, row){
            let imgs = ""
            if (data != "") {
                data.split(';').forEach((image, index)=>{
                    imgs += "<a data-lightbox='image"+row.id+"'  href="+image+">Image "+index+"</a>   "
                })

            }
            return imgs;
        }


        function renderDeliveryOpt(data){
            return data ? "yes" : "no"
        }

        function renderLocation(data){
            return data[0]+", "+data[1]
        }

        function renderAction(row){
            return `<button type='button' class='edit-pharmacy btn btn-success' data-id='${row.id}'
                                                                                data-name='${row.name}'
                                                                                data-address='${row.address}'
                                                                                data-phone='${row.phone}'
                                                                                data-longitude='${(row.location[0])}'
                                                                                data-latitude='${row.location[1]}'
                                                                                data-delivery='${row.delivery}'
>
                                Edit</button>
                    <button type='button' class='delete-pharmacy btn btn-danger' data-id='${row.id}'>Delete</button>`
        }


        $(document).ready(function() {
            var table = $('#table').DataTable( {
                autoWidth: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ajax: {
                    "url": "{{ route('admin.pharmacies.index')}}",
                    "dataType": "json",
                    "type": "GET",
                },

                select: false,
                buttons: [
                    {
                        text: '<i class="bi bi-clipboard-check"></i>' ,extend: "copy", titleAttr: "copy",
                        className: "export-btn",
                        exportOptions: {
                            columns: "th:not(:last-child)"
                        }
                    },
                    {
                        text: '<i class="bi bi-file-earmark-excel"></i>' ,extend: "excel", titleAttr: "excel",
                        className: "export-btn",
                        exportOptions: {
                            columns: "th:not(:last-child)"
                        }
                    },
                    {
                        text: '<i class="bi bi-file-earmark-spreadsheet"></i>' ,extend: "csvHtml5", titleAttr: "CSV",
                        className: "export-btn",
                        exportOptions: {
                            columns: "th:not(:last-child)"
                        }
                    },
                    {
                        text: '<i class="bi bi-file-ppt"></i>' ,extend: "pdf", titleAttr: "PDF",
                        className: "export-btn",
                        exportOptions: {
                            columns: "th:not(:last-child)"
                        }
                    },
                    {
                        text: '<i class="bi bi-printer"></i>' ,extend: "print", titleAttr: "print",
                        className: "export-btn",
                        exportOptions: {
                            columns: "th:not(:last-child)"
                        }
                    },
                ],
                columns: [
                    {
                        data: 'logo', name: 'logo', sortable: false, orderable: false,
                        searchable: true, render: function (data){ return renderLogo(data)}
                    },
                    {
                        data: 'name', name: 'name', sortable: true, orderable: true, searchable: true,
                    },
                    {
                        data: 'location', name: 'location', sortable: false, orderable: false,
                        searchable: false, render: function (data){ return renderLocation(data)}
                    },
                    {
                        data: 'address', name: 'address', sortable: false, orderable: false, searchable: false
                    },
                    {
                        data: 'delivery', name: 'delivery', sortable: false, orderable: false,
                        searchable: false, render: function (data){ return renderDeliveryOpt(data)}
                    },
                    {
                        data: 'images', name: 'images', sortable: false, orderable: false,
                        searchable: false, render: function (data, display, row){ return renderImages(data, row)}
                    },
                    {
                        data: 'phone', name: 'phone', sortable: true, orderable: true, searchable: true
                    },
                    {
                        data: 'action', name: 'action', sortable: false, orderable: false, searchable: false,
                        render: function (data, display, row){ return renderAction(row)}

                    }
                ],
                pagingType: "simple_numbers",
                language:
                    {
                        paginate: {
                            previous: '<i class="bi bi-arrow-left"></i>',
                            next: '<i class="bi bi-arrow-right"></i>'
                        },
                        processing: "***"
                    }
            });

            $('#btn-add').on('click', function (e) {
                e.preventDefault()
                let formData = new FormData($('#add-form')[0])
                $.ajax({
                    url: "{{route('admin.pharmacies.store')}}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#add-form').reset()
                        Swal.fire('success', 'Added Successfully', 'success')
                    },
                    error: function (response) {
                        Swal.fire('error', 'error Adding', 'error')
                    }
                })
            })
            var editRoute = ""
            $('#table').on('click', '.edit-pharmacy', function (e) {
                e.preventDefault()
                $('#editPharmacy').modal('show')
                $('#edit_name').val($(this).data('name'))
                $('#edit_address').val($(this).data('address'))
                $('#edit_phone').val($(this).data('phone'))
                $('#edit_longitude').val($(this).data('longitude'))
                $('#edit_latitude').val($(this).data('latitude'))
                $('edit_delivery').prop('checked', $(this).data('delivery') == 1)
                let id = $(this).data('id');
                let route = "{{route('admin.pharmacies.update', ':id')}}";
                editRoute = route.replace(':id', id)

            })
            $('#btn-edit').on('click', function (e) {
                e.preventDefault()
                let formData = new FormData($('#edit-form')[0])

                $.ajax({
                    url: editRoute,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#add-form').reset()
                        Swal.fire('success', 'Added Successfully', 'success')
                    },
                    error: function (response) {
                        Swal.fire('error', 'error Adding', 'error')
                    }
                })
            })
            $('#table').on('click', '.delete-pharmacy', function (e) {

                e.preventDefault()
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete?",
                    icon: "warning",
                    cancelButtonColor: '#d33',
                    showCancelButton: true
                }).then((willDelete) => {
                    if (!willDelete.isConfirmed) {
                        return false;
                    } else {
                        let id = $(this).data('id');
                        let route = "{{route('admin.pharmacies.destroy', ':id')}}";
                        route = route.replace(':id', id)
                        $.ajax({
                            url: route,
                            dataType: "JSON",
                            type: "POST",
                            data: {
                                _token: "{{csrf_token()}}",
                                _method: 'delete',
                                id: id
                            },
                            success: function () {
                                Swal.fire('success', 'Deleted Successfully', 'success')
                                table.ajax.reload();
                            }
                        })
                    }
            })
        });
        });
    </script>
@endpush
