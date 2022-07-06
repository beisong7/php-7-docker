<?php
    $sidenav['emails'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')

@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header no-gutters">
            <div class="row align-items-md-center">
                <div class="col-md-4">
                    <div class="media m-v-10">
                        <div class="avatar avatar-cyan avatar-icon avatar-square">
                            <i class="anticon anticon-mail"></i>
                        </div>
                        <div class="media-body m-l-15">
                            <h6 class="mb-0">Emails ({{ count($emails) }})</h6>
                            <span class="text-gray font-size-13">All Emails</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="text-md-right m-v-10">

                        <a href="{{ route('email.newsletter') }}" class="btn btn-default">
                            <i class="anticon anticon-mail"></i> Quick Newsletter
                        </a>
                        <a href="{{ route('email.create') }}" class="btn btn-default">
                            <i class="anticon anticon-mail"></i> New Email
                        </a>
                        <a href="{{ route('template.index') }}" class="btn btn-default">
                            <i class="anticon anticon-box-plot"></i> Templates
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
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th title="Private or Non Private" class="text-center">Type</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($emails as $email)
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <h6 class="mb-0">{{ $email->subject }}</h6>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <p class="mb-0">{{ $email->private?'Private':'Bulk' }}</p>
                                                    @if($email->private)
                                                        <small class="text-muted">{{ $email->recipient }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $email->author->names }}</td>
                                                <td>
                                                    {{ $email->active?'Active':'Inactive' }}
                                                    @if(!empty($email->error_message))
                                                        <i title="{{ $email->error_message }}" class="ml-2 fa fa-info-circle text-warning"></i>
                                                    @endif
                                                </td>
                                                <td class="text-right">

                                                    <a href="{{ route('email.edit', $email->uuid) }}" class="btn btn-primary btn-tone">
                                                        <i class="anticon anticon-edit"></i>
                                                        <span class="m-l-5">Edit</span>
                                                    </a>
                                                    <a href="{{ route('email.toggle', $email->uuid) }}" class="btn btn-tone {{ $email->active?'btn-warning':'btn-info' }}">
                                                        <i class="anticon anticon-{{ $email->active?'close':'check' }}"></i>
                                                        <span class="m-l-5">{{ $email->active?'Disable':'Enable' }}</span>
                                                    </a>
                                                    <button class="btn btn-tone btn-danger" onclick="deleteItem('{{ route('email.pop', $email->uuid) }}')">
                                                        <i class="fas fa-trash"></i>
                                                        <span class="m-l-5">Delete</span>
                                                    </button>

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
    <script>
        function deleteItem(url) {
            var answer = prompt("Are you sure you want to delete this email? type 'yes' to continue");
            if (answer === "yes") {
                window.location = url;
            }else{

            }
        }
    </script>
@endsection
