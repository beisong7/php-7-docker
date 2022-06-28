<?php
    $sidenav['emails'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Create Email</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('email.index') }}">Emails</a>
                    <span class="breadcrumb-item active">New Email</span>
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
                                <h4>Create new Email</h4>
                                @include('layouts.notice')
                                <div class="m-t-25">
                                    <form method="post" action="{{ route('email.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email Subject</label>
                                                <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" autocomplete="off" required value="{{ old('subject') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="sender">Email Sender ('NYCC Membership' if left blank)</label>
                                                <input type="text" name="sender" class="form-control" id="sender" placeholder="NYCC Membership" autocomplete="off" required value="{{ old('sender') }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Email Type</label>
                                                <select id="inputState" class="form-control email_type" name="type" required>
                                                    <option selected disabled>Select Type</option>
                                                    <option value="private"{{ old('type')==='private'?'selected':'' }} >Private (Single Recipient)</option>
                                                    <option value="public" {{ old('type')==='public'?'selected':'' }}>Bulk (Mail List Recipient)</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4 email_field" style="display: {{ old('type')==='private'?'block':'none' }}">
                                                <label for="inputPassword4">Recipient Email</label>
                                                <input type="email" name="email" class="form-control" placeholder="Recipient Email" autocomplete="off" value="{{ old('email') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">Title Tag</label>
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Title" autocomplete="off" required value="{{ old('title') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAddress">Email Body</label>
                                            <div class="mb-3 mt-2">
                                                <a href="#" class="btn btn-default btn-sm" onclick="event.preventDefault(); clearTemplate()">Clear Email</a>
                                                <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addTemplate">
                                                    Add From Template
                                                </a>
                                            </div>
                                            <p class="text-muted"><b>NOTE:</b> for bulk message, use <b>__name__</b> which becomes the member's name. <b>Do Not Use</b> this approach for private email</p>
                                            <textarea cols="" rows="24" type="text" name="body" class="form-control myfield">{!! !empty(old('body'))?old('body'):$template !!}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <div class="checkbox">
                                                <input id="gridCheck" type="checkbox" name="activate" {{ old('activate')==='on'?'checked':'' }}>
                                                <label for="gridCheck">Activate Immediately</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create Email</button>
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
    <!-- Modal -->
    <div class="modal fade" id="addTemplate">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Select List</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                        @foreach($templates as $item)
                            <div class="row">
                                <div class="col">
                                    <b class="text-uppercase">{{ $item->title }}</b>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary btn-tone float-right add-template" data-payload="{{ $item->body }}" data-dismiss="modal">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Use Template</span>
                                    </button>
                                </div>
                            </div>
                            <hr>
                        @endforeach


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


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