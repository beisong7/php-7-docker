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
            <h2 class="header-title">Create Email Template</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('template.index') }}">Template</a>
                    <span class="breadcrumb-item active">New Template</span>
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
                                    <form   method="post" action="{{ route('template.store')}}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Template Title</label>
                                                <input type="text" name="title" class="form-control title-field" id="subject" placeholder="Template title" autocomplete="off" required value="{{ old('title') }}">
                                            </div>
                                            <div class="form-group col-md-6">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="body_field">Template Body</label>
                                            <div class="mb-3 mt-2">
                                                <a href="#" class="btn btn-default btn-sm" onclick="event.preventDefault(); clearTemplate()">Clear Template</a>
                                                <a href="#" class="btn btn-default btn-sm" onclick="event.preventDefault(); mainTemplate()">Add Sample Template</a>
                                            </div>
                                            <textarea id="body_field" cols="" rows="24" type="text" name="content" class="form-control myfield ">{{ old('body') }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Create Template</button>
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
            $('.submit').on('click', function (e) {
                tinyMCE.triggerSave();
                let _title = $('.title-field').val();
                let _content = $('#body_field').val();
                console.log(_title, _content);
                if(_title.length < 1){
                    alert('title field missing')
                }else if(_content.length < 1) {
                    alert('content field missing')
                }else{
                    saveToServer(_title, _content);
                }
            })
        })



        function saveToServer(_title, _content) {
            $.post('{{ route('template.make') }}',
                {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    title: _title,
                    content: _content
                })
                .done(function(data){
                    console.log(data);
                    if(data.success){
                        alert('New Template added');
                        window.location = '{{ route('template.index') }}'
                    }
                })
                .fail(function(data){
                    console.log(data);

                });
        }
    </script>

@endsection