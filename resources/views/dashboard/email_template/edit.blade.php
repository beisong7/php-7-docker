<?php
    $sidenav['template'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Edit Email Template</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('template.index') }}">Template</a>
                    <span class="breadcrumb-item active">Edit Template - {{ $template->title }}</span>
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
                                <h4>Create new Template</h4>
                                @include('layouts.notice')
                                <div class="m-t-25">
                                    <form method="post" action="{{ route('template.update', $template->uuid) }}" >
                                        @csrf
                                        {{ method_field('put') }}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Template Title</label>
                                                <input type="text" name="title" class="form-control" id="subject" placeholder="Template title" autocomplete="off" required value="{{ $template->title }}">
                                            </div>
                                            <div class="form-group col-md-6">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAddress">Template</label>
                                            <div class="mb-3 mt-2">
                                                <a href="#" class="btn btn-default btn-sm" onclick="event.preventDefault(); clearTemplate()">Clear Template</a>
                                                <a href="#" class="btn btn-default btn-sm" onclick="event.preventDefault(); mainTemplate()">Add Sample Template</a>
                                            </div>
                                            <textarea cols="" rows="24" type="text" name="content" class="form-control myfield">{!! $template->body !!}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update Template</button>
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
    @include('dashboard.layout.tinymyce')
    {{--<script src="{{ asset('assets/js/pages/profile.js') }}"></script>--}}
    @include('dashboard.email.template.script')
    <script>
        $(document).ready(function () {
            $('.email_type').on('change', function(){
                let val = $(this).val();
                let field = $('.email_field');
                if(val==='private'){
                    field.show();
                }else{
                    field.hide();
                }
            })

        })
    </script>

@endsection