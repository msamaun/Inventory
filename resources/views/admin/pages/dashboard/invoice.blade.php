@extends('admin.layouts.sidenav-layout')
@section('content')
    @include('admin.components.invoice.invoice-list')
    @include('admin.components.invoice.invoice-delete')
    @include('admin.components.invoice.invoice-details')
@endsection
