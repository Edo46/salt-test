@extends('layouts.mainapp')
@section('menu')
<ul>
    <li>
        <a id="dashboard" href={{ url('home') }}>
            <span class="nav-link-icon">
                <i data-feather="pie-chart"></i>
            </span>
            <span>Dashboard</span>
        </a>
        @if(\Auth::user()->role === 1)
        <a id="manage-products" href={{ url('manage-products') }}>
            <span class="nav-link-icon">
                <i data-feather="shopping-cart"></i>
            </span>
            <span>Products</span>
        </a>
        @endif

        <a id="topup" href={{ url('topup') }}>
            <span class="nav-link-icon">
                <i data-feather="shopping-cart"></i>
            </span>
            <span>Top Up</span>
        </a>

        <a id="transaction-history" href={{ url('transaction-history') }}>
            <span class="nav-link-icon">
                <i data-feather="rotate-cw"></i>
            </span>
            <span>Transaction-history</span>
        </a>
        @if(\Auth::user()->role === 1)
        <a id="manage-users" href={{ url('manage-users') }}>
            <span class="nav-link-icon">
                <i data-feather="users"></i>
            </span>
            <span>Users</span>
        </a>
        @endif
    </li>
</ul>
@endsection
