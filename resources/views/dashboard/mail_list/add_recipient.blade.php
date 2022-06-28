<?php
    $sidenav['mail_list'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Add Recipients</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('maillist.index') }}">Add Recipients</a>
                    <span class="breadcrumb-item active">Add Recipients to <b>{{ $list->title }}</b></span>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Add recipients to {{ $list->title }} mail list</h4>
                                <p class="text-muted">
                                    <small>Click on a selection to add its items to this Mail List</small>
                                </p>
                                <hr>
                                @include('layouts.notice')
                                <div class="m-t-25">
                                    <p class="text-muted">Member Groups</p>
                                    <a href="#" class="btn btn-primary btn-tone mb-3">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add All Registered</span>
                                    </a>

                                    <a href="#" class="btn btn-primary btn-tone mb-3" title="Email Valid Members">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add All Valid Members</span>
                                    </a>
                                    <a href="#" class="btn btn-primary btn-tone mb-3" title="Non Email Valid Members">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add All Non Valid Members</span>
                                    </a>
                                    <a href="#" class="btn btn-primary btn-tone mb-3" title="Members with subscriptions">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add All Paid Members</span>
                                    </a>

                                    <a href="#" class="btn btn-primary btn-tone mb-3" title="Members with subscriptions">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add No Passport Members</span>
                                    </a>

                                    <p class="text-muted mt-4">Portfolio 9 Group</p>
                                    <a href="#" class="btn btn-primary btn-tone">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add All Registered</span>
                                    </a>

                                    <a href="#" class="btn btn-primary btn-tone">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add All Non Members</span>
                                    </a>

                                    <p class="text-muted mt-4">NYIF Group</p>
                                    <a href="#" class="btn btn-primary btn-tone">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add All Registered</span>
                                    </a>

                                    <a href="#" class="btn btn-primary btn-tone">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add All Non Members</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Content Wrapper END -->
@endsection

@section('vendor_js')

    <script>
        $(document).ready(function () {

        })
    </script>

@endsection