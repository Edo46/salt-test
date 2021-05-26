@extends('layouts.menu')
@section('title')
    Manage Products
@endsection
@section('css')
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
                        <li class="breadcrumb-item active" aria-current="page">Manage Products</li>
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

                    <div class="card-body">
                        <button type="button" class="btn btn-primary btn-md legitRipple" data-toggle="modal" data-target="#input_form">
                            Add
                            <span class="legitRipple-ripple" style="left: 36.5385%; top: 52.7778%; transform: translate3d(-50%, -50%, 0px); transition-duration: 0.2s, 0.5s; width: 211.643%;"></span>
                        </button>
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

        <div id="input_form" class="modal fade">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Insert new product</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="form_input">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group mb-4 col-md-6">
                                    <label for="formGroupExampleInput">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" id="name" name="name" required>
                                </div>

                                <div class="form-group mb-4 col-md-6">
                                    <label for="formGroupExampleInput">Price</label>
                                    <input type="text" class="form-control" placeholder="Price" id="price" name="price" required>
                                </div>

                                <div class="form-group mb-4 col-md-6">
                                    <label for="formGroupExampleInput">Balance Value</label>
                                    <input type="text" class="form-control" placeholder="Balance Value" id="balance_value" name="balance_value" required>
                                </div>

                                <div class="form-group mb-4 col-md-6">
                                    <label for="formGroupExampleInput">Description</label>
                                    <input type="text" class="form-control" placeholder="Description" id="desc" name="desc" required>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Tutup<span class="legitRipple-ripple" style="left: 59.2894%; top: 39.4737%; transform: translate3d(-50%, -50%, 0px); width: 225.475%; opacity: 0;"></span></button>
                        <button type="button" class="btn btn-primary legitRipple" aksi="input" id="submit_form">Simpan</button>
                    </div>
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

                "ajax": "{{ url('/manage-products/data') }}",
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

        function resetForm() {
            $('#form_input input[type="text"]').val("");
        }

        $(window).on('load', function () {
            loadData();

            $('#submit_form').click(function () {
                var aksi = $("#submit_form").attr("aksi");
                if(aksi=="input"){
                    $.ajax({
                        url: "{{ url('/manage-products/input') }}",
                        type: "post",
                        data: new FormData($('#form_input')[0]),
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,

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
                                resetForm();
                                $('#input_form').modal('toggle');
                                $('#datatable').DataTable().destroy();
                                loadData();
                            }else {
                                $.toast({
                                    heading: 'Success',
                                    text: "Can't insert data, please contact your administrator",
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    position: 'bottom-right',
                                    bgColor: '#da8609'
                                });
                            }


                        }
                    });
                }else if(aksi=="edit"){
                    var id_data = $("#submit_form").attr("iddata");
                    $.ajax({
                        url: "{{ url('/manage-products/edit') }}/"+id_data,
                        type: "post",
                        data: new FormData($('#form_input')[0]),
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,

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
                                resetForm();
                                $('#input_form').modal('toggle');
                                $('#datatable').DataTable().destroy();
                                loadData();

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
                }
            });

            $('#datatable tbody').on('click', '#edit', function (e) {
                var table = $('#datatable').DataTable();
                var data = table.row( $(this).parents('tr') ).data();
                $('#name').val(data.name).change();
                $('#price').val(data.price).change();
                $('#balance_value').val(data.balance_value).change();
                $('#desc').val(data.desc).change();
                $("#submit_form").attr("aksi","edit");
                $('#submit_form').attr("iddata",data.id);
                $('#input_form').modal('toggle');
            } );

            $('#datatable tbody').on('click', '#delete', function (e) {
                var table = $('#datatable').DataTable();
                var data = table.row( $(this).parents('tr') ).data();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ url('/manage-products/delete/') }}/" + data.id,
                            type: "post",
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            cache: false,
                            success: function (response) {
                                var pesan = JSON.parse(response);
                                swal(
                                    "Deleted!",
                                    pesan.success,
                                    "success"
                                );
                                table.destroy();
                                loadData();
                            },
                            failure: function (response) {
                                var pesan = JSON.parse(response);
                                swal(
                                    "Error!",
                                    pesan.error,
                                    "error"
                                )
                            }
                        });
                    } else {
                        swal("Your imaginary file is safe!", {
                            icon: "error",
                        });
                    }
                });
            });

            $('.modal').on('hidden.bs.modal', function () {
                resetForm();
                $("#submit_form").attr("aksi","input");
                $('#submit_form').removeAttr("iddata");
            });
        });
        $('#manage-products').addClass("active");
    </script>
@endsection
