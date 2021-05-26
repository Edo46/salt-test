@extends('layouts.menu')
@section('title')
    Transaction History
@endsection
@section('css')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ url('assets/vendors/dataTable/datatables.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/vendors/prism/prism.css') }}" type="text/css">
@endsection
@section('content')
    <div class="content ">

        <div class="page-header">
            <div>
                <h3>Transaction History</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Pages</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Transaction History</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Transaction History Data</h5>
                    </div>

                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Balance Value</th>
                            <th>Status</th>
                            <th>Transaction Date</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- DataTable -->
    <script src="{{ url('assets/vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ url('assets/assets/js/examples/datatable.js') }}"></script>
    <!-- Prism -->
    <script src="{{ url('assets/vendors/prism/prism.js') }}"></script>
    <script src="{{ url('assets/assets/js/examples/toast.js') }}"></script>
    <script src="{{ url('assets/assets/js/examples/sweet-alert.js') }}"></script>

    <!-- Javascript -->
    <script type="text/javascript">
        function loadData() {
            $('#datatable').DataTable({

                "ajax": "{{ url('/transaction-history/data') }}",
                "columns": [
                    { "data": "product.name" },
                    { "data": 'product.price',  render: $.fn.dataTable.render.number( ',', '.', 3, 'Rp ' )},
                    { "data": 'product.balance_value',  render: $.fn.dataTable.render.number( ',', '.', 3, 'Salt Credit ' )},
                    { "data": "status" },
                    { "data": "buydate" },
                ],
                columnDefs: [
                    {
                        width: "300px",
                        targets: [0, 1, 2, 3]
                    },
                    {
                        orderable: false,
                        width: "80px",
                        targets: [4]
                    }
                ],
                scrollX: true,
                scrollY: '350px',
                scrollCollapse: true,
                responsive: false,
                dom: '<"datatable-header"fl><"datatable-scroll datatable-scroll-wrap"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    searchPlaceholder: 'Type to Search...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                },
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-square");
                },
            });
        }

        $(window).on('load', function () {
            loadData();

            $('.modal').on('hidden.bs.modal', function () {
                $("#submit_form").attr("aksi","input");
                $('#submit_form').removeAttr("iddata");
            });
        });
        $('#transaction-history').addClass("active");
    </script>
@endsection
