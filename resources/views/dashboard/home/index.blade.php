<?php
    $sidenav['dashboard'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header no-gutters">
            <div class="d-md-flex align-items-md-center justify-content-between">
                <div class="media m-v-10 align-items-center">
                    <div class="avatar avatar-image avatar-lg">
                        <img src="{{ $person->image }}" alt="">
                    </div>
                    <div class="media-body m-l-15">
                        <h4 class="m-b-0">Welcome back, {{ $person->first_name }}!</h4>

                    </div>
                </div>
                <div class="d-md-flex align-items-center d-none">

                    <div class="media align-items-center m-r-40 m-v-5">
                        <div class="font-size-27">
                            <i class="text-primary anticon anticon-profile"></i>
                        </div>
                        <div class="d-flex align-items-center m-l-10">
                            <h2 class="m-b-0 m-r-5">{{ $ongoing }}</h2>
                            <span class="text-gray">Ongoing List</span>
                        </div>
                    </div>

                    <div class="media align-items-center m-r-40 m-v-5">
                        <div class="font-size-27">
                            <i class="text-success  anticon anticon-mail"></i>
                        </div>
                        <div class="d-flex align-items-center m-l-10">
                                <h2 class="m-b-0 m-r-5">{{ $pending }}</h2>
                            <span class="text-gray">Pending List</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Emails Sent</h5>
                        </div>
                        <div class="d-md-flex justify-content-space m-t-50">
                            <div class="completion-chart p-r-10" style="width: 100%">
                                <canvas class="chart" id="completion-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Create Email</h5>
                            <div>
                                <a href="{{ route('email.index') }}" class="btn btn-default btn-sm">List Emails</a>
                            </div>
                        </div>
                        <div class="m-t-30">
                            <p class="text-muted">
                                Create emails to be sent
                            </p>
                            <a href="{{ route('email.create') }}" class="btn btn-primary btn-sm">Create Now</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">API EMAILS</h5>
                        </div>
                        <br>
                        <h6 class="text-center">Total </h6>
                        <p class="text-center">{{ $all_api }}</p>
                        <hr>
                        <h6 class="text-center">Sent </h6>
                        <p class="text-center">{{ $all_api }}</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Active Task List</h5>
                            <div>
                                <a href="{{ route('maillist.create') }}" class="btn btn-primary btn-sm">New Email List</a>
                                <a href="{{ route('maillist.index') }}" class="btn btn-primary btn-sm">Mail Lists</a>
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
                                                        <i class="anticon anticon-{{ $list->status==='inactive'?'close':'check' }}-o text-{{ $list->bgColor }}"></i>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Wrapper END -->
@endsection

@section('vendor_js')
    <?php $version=1.01 ?>
    <script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset("assets/js/pages/dashboard-project.js?v={$version}") }}"></script>
    <script>

    </script>
@endsection