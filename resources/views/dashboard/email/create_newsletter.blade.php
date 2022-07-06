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
            <h2 class="header-title">Create Newsletter</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('email.index') }}">Emails</a>
                    <span class="breadcrumb-item active">Newsletter</span>
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
                                    <form method="post" action="{{ route('email.create.newsletter') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email Subject</label>
                                                <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" autocomplete="off" required value="{{ old('subject') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="sender">Email Sender ('IRecharge' if left blank)</label>
                                                <input type="text" name="sender" class="form-control" id="sender" placeholder="IRecharge" autocomplete="off" value="{{ old('sender') }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Email Type</label>
                                                <select id="inputState" class="form-control email_type" name="type" required disabled>
                                                    <option selected disabled>Select Type</option>
                                                    <option value="public" selected>Bulk (Multiple Users)</option>
                                                </select>
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

                                        <br>
                                        <h4>Configure Sending / Schedule</h4>
                                        <p>Determine when you want this email to be sent.</p>
                                        <hr>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="occurrence">Occurence Type</label>
                                                <select id="occurrence" class="form-control" name="occurrence_type" required>
                                                    <option value="once" {{ old('occurrence_type')==='once'?'selected':'' }}>Once</option>
                                                    <option value="daily" {{ old('occurrence_type')==='daily'?'selected':'' }}>Daily</option>
                                                    {{-- <option value="automated" {{ old('occurrence_type')==='automated'?'selected':'' }}>Automated</option> --}}
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

                                        <br>
                                        <h4>Receiver Group</h4>
                                        <p>Select the groups you want to send to.</p>
                                        <hr>
                                        <div class="form-row">
                                            @foreach($groups as $group)
                                                <div class="form-group col-md-4">
                                                    <div class="checkbox">
                                                        <input id="{{ $group->name }}VV" type="checkbox" name="selection[]" value="{{ $group->uuid }}">
                                                        <label for="{{ $group->name }}VV">{{ $group->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="form-group mt-3">
                                            <p>Add unique people to the receivers. Enter emails separated by coma</p>
                                            <textarea class="form-control" name="inclusive" id="" cols="30" rows="2" placeholder="example@email.com, johnwick@example.com, johndoe@example.com"></textarea>
                                        </div>

                                        <div class="form-group mt-3">
                                            <p>Exclude unique people to the receivers. Enter emails separated by coma</p>
                                            <textarea class="form-control" name="exclusive" id="" cols="30" rows="2" placeholder="example@email.com, johnwick@example.com, johndoe@example.com"></textarea>
                                        </div>

                                        <hr>

                                        <div class="form-group mt-3">
                                            <div class="checkbox">
                                                <input id="gridCheck" type="checkbox" name="start_sending" {{ old('activate')==='on'?'checked':'' }}>
                                                <label for="gridCheck">Start Sending Immediately</label>
                                            </div>
                                            <small>Checking this option will ignore your schedule setting and start sending immediately</small>
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
