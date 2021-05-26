@extends('layouts.menu')
@section('title')
    Top Up Page
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
                <h3>Manage Products</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Pages</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Top Up</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Products Data</h5>
                    </div>

                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Balance Value</th>
                            <th>Description</th>
                            <th class="dt-no-sorting">Action</th>
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

                "ajax": "{{ url('/topup/data') }}",
                "columns": [
                    { "data": "name" },
                    { "data": 'price',  render: $.fn.dataTable.render.number( ',', '.', 3, 'Rp ' )},
                    { "data": 'balance_value',  render: $.fn.dataTable.render.number( ',', '.', 3, 'Salt Credit ' )},
                    { "data": "desc" },
                    { "data": "action" }
                ],
                columnDefs: [
                    {
                        width: "340px",
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

            $('#datatable tbody').on('click', '#buy', function (e) {
                var table = $('#datatable').DataTable();
                var data = table.row( $(this).parents('tr') ).data();
                $.ajax({
                    url: "{{ url('/topup/buy') }}/"+data.id,
                    type: "post",
                    data:{
                        "_token": "{{ csrf_token() }}",
                    },

                    success: function (response) {
                        var pesan = JSON.parse(response);
                        if(pesan.error != null){
                            toastr.options = {
                                timeOut: 3000,
                                progressBar: true,
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                showDuration: 200,
                                hideDuration: 200
                            };
                            toastr.error(pesan.error);
                            $('#datatable').DataTable().destroy();
                            loadData();
                        }else if(pesan.success != null){
                            toastr.options = {
                                timeOut: 3000,
                                progressBar: true,
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                showDuration: 200,
                                hideDuration: 200
                            };
                            toastr.success(pesan.success);
                            $('#datatable').DataTable().destroy();
                            loadData();
                            window.location.replace('{{ url('topup/checkout/') }}/'+ pesan.order_code);

                        }else {
                            $.toast({
                                heading: 'Success',
                                text: "Can't insert data, please contact your administrator",
                                showHideTransition: 'slide',
                                icon: 'success',
                                position: 'bottom-right',
                                bgColor: '#da8609'
                            });
                            $('#submit_form').attr("data-aksi","input");
                        }


                    }
                });
            } );

            $('.modal').on('hidden.bs.modal', function () {
                $("#submit_form").attr("aksi","input");
                $('#submit_form').removeAttr("iddata");
            });
        });
        $('#topup').addClass("active");
    </script>
@endsection
