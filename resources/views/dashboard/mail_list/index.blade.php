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
        <div class="page-header no-gutters">
            <div class="row align-items-md-center">
                <div class="col-md-6">
                    <div class="media m-v-10">
                        <div class="avatar avatar-cyan avatar-icon avatar-square">
                            <i class="anticon anticon-unordered-list"></i>
                        </div>
                        <div class="media-body m-l-15">
                            <h6 class="mb-0">Mail Lists ({{ count($lists) }})</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right m-v-10">
                        <a href="{{ route('maillist.create') }}" id="list-view-btn" type="button" class="btn btn-default">
                            <i class="anticon anticon-ordered-list"></i> New List
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @include('layouts.notice')
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Email(subject)</th>
                                            <th>Model</th>
                                            <th>Recipients</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($lists as $list)
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <h6 class="mb-0">{{ $list->title }}</h6>
                                                    </div>
                                                </td>
                                                <td>{{ !empty($list->email)?$list->email->subject:'No Email|fix' }}</td>
                                                <td>{{ $list->type }}</td>
                                                <td>
                                                    <span class="badge badge-dark">{{ $list->recipients }}</span>
                                                    @if($list->type!=='automated')
                                                        <a href="{{ route('maillist.recipients', $list->uuid) }}" class="btn btn-info btn-tone btn-sm">
                                                            <span class="m-l-5">Preview</span>
                                                        </a>
                                                    @endif



                                                </td>
                                                <td>{{ $list->status }} | {{ $list->active?"running":"not running" }}</td>
                                                <td class="text-right">

                                                    {{--
                                                    <a href="{{ route('mail.list.add_recipient', $list->uuid) }}" class="btn btn-success btn-tone">
                                                        <i class="anticon anticon-plus"></i>
                                                        <span class="m-l-5">Add Recipients</span>
                                                    </a>
                                                    --}}
                                                    @if($list->type!=='automated')
                                                        @if($list->status==='pending' or $list->status==='active')
                                                            <a href="{{ route('mail-list.run', $list->uuid) }}" class="btn btn-warning btn-tone">
                                                                <i class="anticon anticon-play-circle"></i>
                                                                <span class="m-l-5">Run</span>
                                                            </a>
                                                        @endif
                                                    @endif


                                                    <a href="{{ route('mail-list.toggle', $list->uuid) }}" class="btn btn-{{ $list->active?'danger':'primary' }} btn-tone">
                                                        <i class="anticon anticon-close"></i>
                                                        <span class="m-l-5">{{ $list->active?'Disable':'Activate' }}</span>
                                                    </a>

                                                    <a href="{{ route('maillist.edit', $list->uuid) }}" class="btn btn-info btn-tone">
                                                        <i class="anticon anticon-edit"></i>
                                                        <span class="m-l-5">Edit</span>
                                                    </a>

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
                                {{ $lists->appends(request()->input())->links() }}
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


    <script src="{{ asset('assets/js/pages/profile.js') }}"></script>

@endsection
