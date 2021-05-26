@extends('layouts.menu')
@section('title')
    Admin and Dashboard Template
@endsection
@section('css')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ url('assets/vendors/prism/prism.css') }}" type="text/css">
@endsection
@section('content')
    <div class="content ">

        <div class="page-header">
            <div>
                <h3>Checkout</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Pages</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-50">
                            <div class="invoice">
                                <div class="d-md-flex justify-content-between align-items-center">
                                    <h2 class="font-weight-bold d-flex align-items-center">
                                        <img src="{{ url('assets/assets/media/image/dark-logo.png') }}" alt="dark logo">
                                    </h2>
                                    <h3 class="text-xs-left m-b-0">Invoice {{ $checkout->order_code }}</h3>
                                </div>
                                <hr class="m-t-b-50">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <b>PT. Ako Media Asia</b>
                                        </p>
                                        <p>1, 6 Jalan Lapangan Bola, RT.7/RW.1, Kb. Jeruk, <br>Kec. Kb. Jeruk, Kota Jakarta Barat, <br>Daerah Khusus Ibukota Jakarta 11530</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-right">
                                            <b>Invoice to</b>
                                        </p>
                                        <p class="text-right">{{ $checkout->user->name }},<br> {{ $checkout->user->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-4 mt-4">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-right">Price</th>
                                            <th class="text-right">Salt Credit</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="text-right">
                                            <td class="text-left">{{ $checkout->product->name }}</td>
                                            <td>@currency($checkout->product->price)</td>
                                            <td>@salt($checkout->product->balance_value)</td>
                                            <td>@currency($checkout->total)</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <h4 class="font-weight-800">Total : @currency($checkout->total)</h4>
                                </div>
                                <p class="text-center small text-muted  m-t-50">
                        <span class="row">
                            <span class="col-md-6 offset-3">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, at.
                            </span>
                        </span>
                                </p>
                            </div>
                            <div class="text-right d-print-none">
                                <hr class="my-5">
                                <a href="#" class="btn btn-primary" onclick="finish()">Finish Order</a>
                                <a href="#" class="btn btn-danger" onclick="cancel()">Cancel Order</a>
                                <a href="javascript:window.print()" class="btn btn-success ml-2">Print</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="{{ url('assets/vendors/prism/prism.js') }}"></script>
    <script src="{{ url('assets/assets/js/examples/toast.js') }}"></script>
    <script type="text/javascript">
        function finish(){
            $.ajax({
                url: "{{ url('/topup/checkout-process') }}/"+{{ $checkout->order_code }},
                type: "post",
                data:{
                    "_token": "{{ csrf_token() }}",
                    "status": 'verified',
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
                        window.location.replace('{{ url('topup') }}')
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
        }

        function cancel(){
            $.ajax({
                url: "{{ url('/topup/checkout-process') }}/"+{{ $checkout->order_code }},
                type: "post",
                data:{
                    "_token": "{{ csrf_token() }}",
                    "status": 'canceled',
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
                        window.location.replace('{{ url('topup') }}')
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
        }
        $('#dashboard').addClass("active");
    </script>
@endsection
