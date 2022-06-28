<?php
    $sidenav['tasks'] = 'active';
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
                            <h6 class="mb-0">Task Lists </h6>
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
            <div class="col-lg-11 mx-auto">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @include('layouts.notice')
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Active Task List</h5>
                                    <div>

                                    </div>
                                </div>
                                <div class="table-responsive m-t-30">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Mail List Title</th>
                                            <th>Email (subject)</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($lists as $list)
                                            <tr>
                                                <td>
                                                    <p>
                                                        <b><span class="text-dark">{{ $list->title }}</span></b>
                                                        <span class="badge badge-pill badge-dark font-size-10">{{ $list->daily?'repeat':'once' }} </span>
                                                    </p>

                                                </td>
                                                <td>{{ !empty($list->email)?$list->email->subject:'No Email|fix' }}</td>
                                                <td>
                                                    <span class="badge badge-pill badge-{{ $list->badge }} font-size-12">{{ $list->status }} </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress progress-sm w-100 m-b-0">
                                                            <div title="{{ $list->progress }}% oompleted" class="progress-bar bg-{{ $list->bgColor }}" role="progressbar" style="width: {{ $list->progress }}%"></div>
                                                        </div>
                                                        <div class="m-l-10">
                                                            @if($list->status==='ongoing')
                                                                {{ $list->progress }}%
                                                            @else
                                                                <i class="anticon anticon-check-o text-{{ $list->bgColor }}"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-default"><i class="fas fa-tools"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <div class="media align-items-center">
                                                        <div class="m-l-10">
                                                            <span>No List Items.</span>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforelse


                                        <!--
                                <tr>
                                    <td>
                                        <div class="media align-items-center">
                                            <div class="m-l-10">
                                                <span>Member Portal Update</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span>Valid Members</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-blue font-size-12">In Progress</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-sm w-100 m-b-0">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 76%"></div>
                                            </div>
                                            <div class="m-l-10">
                                                76%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-default"><i class="fas fa-tools"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="media align-items-center">
                                            <div class="m-l-10">
                                                <span>Membership Fee Update</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span>Valid Members</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-red font-size-12">Stopped</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-sm w-100 m-b-0">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 28%"></div>
                                            </div>
                                            <div class="m-l-10">
                                                <i class="anticon anticon-close-o text-danger"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-default"><i class="fas fa-tools"></i></a>
                                    </td>
                                </tr>

                                -->

                                        </tbody>
                                    </table>
                                </div>

                                <br>
                                {{ $lists->links() }}
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