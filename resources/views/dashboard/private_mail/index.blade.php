<?php
    $sidenav['private_mail'] = 'active';
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
                            <h6 class="mb-0">Private E-mails </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right m-v-10">
                        <a href="{{ route('email.create') }}" id="list-view-btn" type="button" class="btn btn-default">
                            <i class="anticon anticon-ordered-list"></i> New Email
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
                                            <th>Sender</th>
                                            <th>Subject</th>
                                            <th>Recipient</th>
                                            <th>Mail Status</th>
                                            <th>Status</th>
                                            <th class="">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($emails as $email)
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <h6 class="mb-0">{{ !empty($email->sender)?$email->sender:'Org Name' }}</h6>
                                                    </div>
                                                </td>
                                                <td>{{ $email->subject }}</td>
                                                <td>{{ $email->recipient }}</td>
                                                <td>{{ $email->sent?'Sent':'Pending' }}</td>
                                                <td>{{ $email->active?'Active':'Inactive' }}</td>
                                                <td class="">
                                                    @if($email->active)
                                                        <a href="{{ route('mail.send', $email->uuid) }}" class="btn btn-success btn-tone">
                                                            <i class="anticon anticon-play-circle"></i>
                                                            <span class="m-l-5">{{ $email->sent?'Resend':'Send' }}</span>
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('email.toggle', $email->uuid) }}" class="btn btn-{{ $email->active?'danger':'primary' }} btn-tone">
                                                        <i class="anticon anticon-close"></i>
                                                        <span class="m-l-5">{{ $email->active?'Disable':'Activate' }}</span>
                                                    </a>

                                                    <a href="{{ route('email.edit', $email->uuid) }}" class="btn btn-info btn-tone">
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
                                {{ $emails->links() }}
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

<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> dev
