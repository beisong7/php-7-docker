<?php
    $sidenav['automate'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')

@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Auto List</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('automate') }}">Automate</a>
                    <span class="breadcrumb-item active">New </span>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Create new automated list</h4>
                                @include('layouts.notice')
                                <div class="m-t-25">
                                    <form method="post" action="{{ route('automate.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">Automate Title</label>
                                                    <input type="text" name="title" class="form-control" id="title" placeholder="Title" autocomplete="off" required value="{{ old('title') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="info">Automate Details</label>
                                                    <textarea name="info" class="form-control" id="info" autocomplete="off" required>{{ old('info') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Complete</button>
                                    </form>
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