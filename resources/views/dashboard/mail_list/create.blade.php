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
            <h2 class="header-title">Create Mail List</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('maillist.index') }}">Maillist</a>
                    <span class="breadcrumb-item active">New List</span>
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
                                <h4>Create new mail list</h4>
                                @include('layouts.notice')
                                <div class="m-t-25">
                                    <form method="post" action="{{ route('maillist.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">List Title</label>
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Title" autocomplete="off" required value="{{ old('title') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="occurrence">Occurence Type</label>
                                                <select id="occurrence" class="form-control" name="occurrence_type" required>
                                                    <option value="once" {{ old('occurrence_type')==='once'?'selected':'' }}>Once</option>
                                                    <option value="daily" {{ old('occurrence_type')==='daily'?'selected':'' }}>Daily</option>
                                                    <option value="automated" {{ old('occurrence_type')==='automated'?'selected':'' }}>Automated</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="occurrence">Select Days</label>

                                                <div class="d-flex">
                                                    <div class="checkbox ml-2">
                                                        <input id="sunday" type="checkbox" name="sunday" {{ old('sunday')==='on'?'checked':'' }}>
                                                        <label for="sunday">Sunday</label>
                                                    </div>
                                                    <div class="checkbox ml-2">
                                                        <input id="monday" type="checkbox" name="monday" {{ old('monday')==='on'?'checked':'' }}>
                                                        <label for="monday">Monday</label>
                                                    </div>

                                                    <div class="checkbox ml-2">
                                                        <input id="tuesday" type="checkbox" name="tuesday" {{ old('tuesday')==='on'?'checked':'' }}>
                                                        <label for="tuesday">Tuesday</label>
                                                    </div>

                                                    <div class="checkbox ml-2">
                                                        <input id="wednesday" type="checkbox" name="wednesday" {{ old('wednesday')==='on'?'checked':'' }}>
                                                        <label for="wednesday">Wednesday</label>
                                                    </div>

                                                    <div class="checkbox ml-2">
                                                        <input id="thursday" type="checkbox" name="thursday" {{ old('thursday')==='on'?'checked':'' }}>
                                                        <label for="thursday">Thursday</label>
                                                    </div>

                                                    <div class="checkbox ml-2">
                                                        <input id="friday" type="checkbox" name="friday" {{ old('friday')==='on'?'checked':'' }}>
                                                        <label for="friday">Friday</label>
                                                    </div>

                                                    <div class="checkbox ml-2">
                                                        <input id="saturday" type="checkbox" name="saturday" {{ old('saturday')==='on'?'checked':'' }}>
                                                        <label for="saturday">Saturday</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Select Hour</label>
                                                <select id="occurence" class="form-control" name="hour" required>
                                                    <?php $hourz = 0 ?>
                                                        <option value="" selected disabled>Select Hour</option>
                                                    @while($hourz < 24)
                                                        <option value="{{ sprintf('%02d', $hourz) }}" {{ old('hour')===sprintf('%02d', $hourz)?'selected':'' }} >{{ sprintf('%02d', $hourz) }}</option>
                                                        <?php $hourz++ ?>
                                                    @endwhile
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="occurence">Select Minute</label>
                                                <select id="occurence" class="form-control" name="minutes" required>
                                                    <?php $minutez = 0 ?>
                                                        <option value="" selected disabled>Select Minute</option>
                                                    @while($minutez < 60)
                                                            <option value="{{ sprintf('%02d', $minutez) }}" {{ old('minutes')===sprintf('%02d', $minutez)?'selected':'' }}>{{ sprintf('%02d', $minutez) }}</option>
                                                        <?php $minutez++ ?>
                                                    @endwhile
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Email [subject | title | date added]</label>
                                                <select id="inputState" class="form-control" name="email_id" required>
                                                    <option selected disabled>Select Email</option>
                                                    @foreach($mails as $mail)
                                                        <option value="{{ $mail->uuid }}" {{ old('email_id')===$mail->uuid?'selected':'' }}>{{ "{$mail->subject} | {$mail->title} | ".date("F d, Y", strtotime($mail->created_at)) }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Create List</button>
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