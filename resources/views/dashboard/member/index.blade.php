<?php
    $sidenav['member'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header no-gutters">
            <div class="row align-items-md-center">
                <div class="col-md-6">
                    <div class="media m-v-10">
                        <div class="avatar avatar-cyan avatar-icon avatar-square">
                            <i class="anticon anticon-unordered-list"></i>
                        </div>
                        <div class="media-body m-l-15">
                            <h6 class="mb-0">Members Found ({{ $data->count()  }})</h6>
                            <span>{{ $type?ucfirst($type):'All' }} Records</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        @include('layouts.notice')
                        <?php $info = $data->toArray() ?>
                        @if(!empty($info['from']))
                            <b>
                                Showing : {{ !empty($info['from'])?$info['from']:0 }} - {{ !empty($info['to'])?$info['to']:0 }} <i class="ml-3 mr-3"> of </i> {{ $info['total'] }}
                            </b>

                        @else
                            No Result
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('member.index') }}" method="get" class="ml-3 float-right" style="display: inline-flex;">

                                    <button class="btn btn-sm btn-default" disabled="disabled">From</button>
                                    <input type="date" name="start" value="{{ @$start }}" class="form-control mr-3" style="width: 170px">
                                    <button class="btn btn-sm btn-default" disabled="disabled">To</button>
                                    <input type="date" name="end" value="{{ @$end }}" class="form-control mr-3" style="width: 170px">
                                    <button class="btn btn-sm btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="Update current type with date of registration selected">Update</button>
                                </form>

                                <div>
                                    <button type="button" class="btn btn-primary btn-tone" data-toggle="modal" data-target="#createMember">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Create Member</span>
                                    </button>

{{--                                    <a  type="button" href="{{ route('add_recipient.from-search', ['type'=>@$type, 'start'=>@$start,'end'=>@$end]) }}" class="btn btn-primary " data-toggle="tooltip" data-placement="top" title="Download Selected Type">Download </a>--}}
                                    {{--<a  href="#" class="btn btn-primary " data-toggle="tooltip" data-placement="top" title="Download Selected Type">Add To List</a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Names</th>
                                            <th>Email</th>
                                            <th>Created</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $member)
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <h6 class="mb-0">{{ $member->names }}</h6>
                                                    </div>
                                                </td>
                                                <td>{{ $member->email }}</td>
                                                <td>{{ date('F d, Y', strtotime($member->created_at)) }}</td>
                                                <td class="text-right">

                                                    <a href="#" class="btn btn-success btn-tone doload" data-mid="{{ $member->uuid }}">
                                                        <i class="anticon anticon-plus"></i>
                                                        <span class="m-l-5">Add To Group</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <h6 class="text-center">No Entries yet</h6>
                                                </td>
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>

                                <br>
                                {{ $data->appends(request()->input())->links() }}
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
    <!-- Button trigger modal -->

    <!-- Modal -->

    <div class="modal fade" id="createMember">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Create Member</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="">
                        <form action="{{ route('member.store') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fn">First Name *</label>
                                    <input type="text" name="first_name" class="form-control" id="fn" placeholder="First Name" autocomplete="off" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ln">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id="ln" placeholder="Last Name" autocomplete="off">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="em">Email Address *</label>
                                    <input type="email" name="email" class="form-control" id="title" placeholder="Email Address" autocomplete="off" required>
                                </div>

                                <div class="col-12"></div>

                                @foreach($groups as $group)
                                    <div class="form-group col-md-6">
                                        <div class="checkbox">
                                            <input id="{{ $group->name }}CB" type="checkbox" name="group[]" value="{{ $group->uuid }}">
                                            <label for="{{ $group->name }}CB">{{ $group->name }}</label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMemberToGroup">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Select List</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.to.group') }}" method="post" id="inject_member">
                        @csrf
                        <div class="form-row">
                            @foreach($groups as $group)
                                <div class="form-group col-md-6">
                                    <div class="checkbox">
                                        <input id="{{ $group->name }}VV" type="checkbox" name="selection[]" value="{{ $group->uuid }}">
                                        <label for="{{ $group->name }}VV">{{ $group->name }}</label>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <button type="submit" class="btn btn-primary">Add</button>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/pages/profile.js') }}"></script>
    <script>
        $('.doload').on('click', function(e){
            e.preventDefault();
            // $('#addMemberToGroup').modal('show');

            let modal_body = $('#addMemberToGroup').modal('show');
            modal_body
                .find('#inject_member')
                .append(`<input type="hidden" name="member_id" value="${$(this).attr('data-mid')}" />`);

            // let modal_body = $('#addMemberToGroup').modal('show').find('.modal-body');
            // modal_body.children().remove();
            // modal_body.append(`<p class="text-center">Loading...</p>`);
            // modal_body.load($(this).attr('href'));
        });
    </script>
@endsection
