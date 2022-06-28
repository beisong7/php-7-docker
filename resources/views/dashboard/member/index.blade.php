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
                        <div class="card">
                            <div class="card-body">
                                <?php $info = $data->toArray() ?>
                                @if(!empty($info['from']))
                                    <b>
                                        Showing : {{ !empty($info['from'])?$info['from']:0 }} - {{ !empty($info['to'])?$info['to']:0 }} <i class="ml-3 mr-3"> of </i> {{ $info['total'] }}
                                    </b>

                                @else
                                    No Result
                                @endif

                                <form action="{{ route('member.index') }}" method="get" class="ml-3 float-right" style="display: inline-flex;">
                                    <input type="hidden" name="type" value="{{ @$type }}">
                                    <button class="btn btn-sm btn-default" disabled="disabled">From</button>
                                    <input type="date" name="start" value="{{ @$start }}" class="form-control mr-3" style="width: 170px">
                                    <button class="btn btn-sm btn-default" disabled="disabled">To</button>
                                    <input type="date" name="end" value="{{ @$end }}" class="form-control mr-3" style="width: 170px">
                                    <button class="btn btn-sm btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="Update current type with date of registration selected">Update</button>
                                </form>

                                <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            TYPE <i class="mdi mdi-chevron-down ml-1"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <a href="{{ route('member.index') }}" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="All accounts, no date filter"> All (clear) </a>
                                            <a href="{{ route('member.index', ['start'=>@$start, 'end'=>@$end]) }}" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="All accounts"> All </a>
                                            <a href="{{ route('member.index', ['type'=>'active', 'start'=>@$start, 'end'=>@$end]) }}" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="All accounts with email verified"> Active </a>
                                            <a href="{{ route('member.index', ['type'=>'inactive', 'start'=>@$start, 'end'=>@$end]) }}" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="All yet to verify email"> Inactive </a>
                                            <a href="{{ route('member.index', ['type'=>'member', 'start'=>@$start, 'end'=>@$end]) }}" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="All accounts that has made payment"> Member </a>
                                            <a href="{{ route('member.index', ['type'=>'non member', 'start'=>@$start, 'end'=>@$end]) }}" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="All accounts with no membership"> Non - Member </a>
                                            <a href="{{ route('member.index', ['type'=>'v non-member', 'start'=>@$start, 'end'=>@$end]) }}" class="dropdown-item" data-toggle="tooltip" data-placement="top" title="non member email Verified"> V-Non-Member </a>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-tone" data-toggle="modal" data-target="#addToList">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Add To List</span>
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
                                            <th>Registered</th>
                                            <th>Status</th>
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
                                                <td>{{ $member->trueStatus }}</td>
                                                <td class="text-right">

                                                    <a href="{{ route('member.to-list', $member->uuid) }}" class="btn btn-success btn-tone doload">
                                                        <!--
                                                        data-toggle="modal" data-target="#addMemberToList"
                                                         -->
                                                        <i class="anticon anticon-plus"></i>
                                                        <span class="m-l-5">Add To List</span>
                                                    </a>
                                                    {{--
                                                    <a href="#" class="btn btn-primary btn-tone">
                                                        <i class="anticon anticon-mail"></i>
                                                        <span class="m-l-5">Send Email</span>
                                                    </a>
                                                    --}}

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
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
    <div class="modal fade" id="addToList">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Select List</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    @foreach($lists as $list)
                        <b class="text-uppercase">{{ $list->title }}</b>
                        <small class="badge badge-dark">{{ $list->type }}</small>

                        <a href="{{ route('add_recipient.from-search', ['id'=>$list->uuid, 'type'=>@$type, 'start'=>@$start,'end'=>@$end]) }}" class="btn btn-primary btn-tone float-right">
                            <i class="anticon anticon-plus"></i>
                            <span class="m-l-5">Add Here</span>
                        </a>
                        <hr>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMemberToList">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Select List</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Loading...</p>
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
            let modal_body = $('#addMemberToList').modal('show').find('.modal-body');
            modal_body.children().remove();
            modal_body.append(`<p class="text-center">Loading...</p>`);
            modal_body.load($(this).attr('href'));
        });
    </script>
@endsection