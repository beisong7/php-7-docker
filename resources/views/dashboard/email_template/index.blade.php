<?php
    $sidenav['template'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')

@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header no-gutters">
            <div class="row align-items-md-center">
                <div class="col-md-6">
                    <div class="media m-v-10">
                        <div class="avatar avatar-cyan avatar-icon avatar-square">
                            <i class="anticon anticon-mail"></i>
                        </div>
                        <div class="media-body m-l-15">
                            <h6 class="mb-0">Template ({{ count($templates) }})</h6>
                            <span class="text-gray font-size-13">All Emails</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right m-v-10">

                        <a href="{{ route('template.create') }}" class="btn btn-default">
                            <i class="anticon anticon-mail"></i> New Template
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
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Created</th>
                                            <th>Current Default</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($templates as $template)
                                            <tr>
                                                <td>{{ $template->title }}</td>
                                                <td>{{ $template->author->names }}</td>
                                                <td>{{ date('M d, Y', strtotime($template->created_at)) }}</td>
                                                <td>{{ $template->current?'Yes':'No' }}</td>
                                                <td class="text-right">

                                                    <a href="{{ route('template.edit', $template->uuid) }}" class="btn btn-primary btn-tone">
                                                        <i class="anticon anticon-edit"></i>
                                                        <span class="m-l-5">Edit</span>
                                                    </a>
                                                    <a href="{{ route('template.toggle', $template->uuid) }}" class="btn btn-tone {{ $template->current?'btn-warning':'btn-success' }}">
                                                        <i class="anticon anticon-{{ $template->current?'close':'check' }}"></i>
                                                        <span class="m-l-5">{{ $template->current?'Unset':'Set Default' }}</span>
                                                    </a>
                                                    <a href="#" onclick="event.preventDefault(); popItem('{{ route('template.pop', $template->uuid) }}')" class="btn btn-danger btn-tone">
                                                        <i class="anticon anticon-close"></i>
                                                        <span class="m-l-5">Delete</span>
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
        function popItem(url) {
            var answer = prompt("Are you sure you want to delete this template? type 'yes' to continue");
            if (answer === "yes") {
                window.location = url;
            }else{

            }
        }
    </script>
@endsection