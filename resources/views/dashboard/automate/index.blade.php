<?php
    $sidenav['automate'] = 'active';
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
                            <i class="anticon anticon-control"></i>
                        </div>
                        <div class="media-body m-l-15">
                            <h6 class="mb-0">Automated List</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right m-v-10">
                        <a href="{{ route('automate.create') }}" id="list-view-btn" type="button" class="btn btn-default">
                            <i class="anticon anticon-ordered-list"></i> New Auto List
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
                                            <th>Stages</th>
                                            <th>Status</th>
                                            <th>Author</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($automates as $item)
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <h6 class="mb-0">{{ $item->title }}</h6>
                                                    </div>
                                                </td>
                                                <td>{{ $item->stages->count() }} stage(s)</td>
                                                <td>{{ $item->active?'Active':'Inactive' }}</td>
                                                <td>
                                                    {{ @$item->author->names }}
                                                </td>

                                                <td class="">

                                                    {{--
                                                    <a href="{{ route('mail.list.add_recipient', $item->uuid) }}" class="btn btn-success btn-tone">
                                                        <i class="anticon anticon-plus"></i>
                                                        <span class="m-l-5">Add Recipients</span>
                                                    </a>
                                                    --}}

                                                    <a href="{{ route('automate.toggle', $item->uuid) }}" class="btn btn-{{ $item->active?'danger':'success' }} btn-tone">
                                                        <i class="anticon anticon-close"></i>
                                                        <span class="m-l-5">{{ $item->active?'Disable':'Activate' }}</span>
                                                    </a>

                                                    <a href="{{ route('automate.edit', $item->uuid) }}" class="btn btn-info btn-tone">
                                                        <i class="anticon anticon-edit"></i>
                                                        <span class="m-l-5">Edit</span>
                                                    </a>

                                                    <a href="{{ route('automate.manage', $item->uuid) }}" class="btn btn-primary btn-tone">
                                                        <i class="anticon anticon-setting"></i>
                                                        <span class="m-l-5">Manage</span>
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
                                {{ $automates->links() }}
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