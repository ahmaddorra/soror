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
                </tr>
            </thead>
            <tbody></tbody>
        </table>
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

        $(document).ready(function() {
            var table = $('#table').DataTable( {
                autoWidth: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ajax: {
                    "url": "{{ route('client.pharmacies.index')}}",
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

        });
    </script>
@endpush
