@extends('layouts.menu')
@section('title')
    Admin and Dashboard Template
@endsection
@section('content')
    <div class="content ">

        <div class="page-header">
            <div>
                <h3>Dashboard</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Pages</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Welcome {{ \Auth::user()->name }}</h6>
                        <p>This is a blank page</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $('#dashboard').addClass("active");
    </script>
@endsection
