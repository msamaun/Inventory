@extends('admin.layouts.sidenav-layout')
@section('content')
    @include('admin.components.customer.customer-list')
    @include('admin.components.customer.customer-delete')
    @include('admin.components.customer.customer-create')
    @include('admin.components.customer.customer-update')
@endsection
