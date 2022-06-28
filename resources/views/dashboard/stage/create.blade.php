<?php
    $sidenav['automate'] = 'active';
?>
@extends('layouts.app')

@section('vendor_css')

@endsection

@section('content')
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Stage Setup</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('automate') }}">Automate</a>
                    <a class="breadcrumb-item" href="{{ route('automate.manage', $auto->uuid) }}">{{ $auto->title }}</a>
                    <span class="breadcrumb-item active">New Stage</span>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        @include('layouts.notice')
                        <div class="card">
                            <div class="card-body">
                                <h4>Create New Automated Stage</h4>
                                <div class="m-t-25">
                                    <form method="post" action="{{ route('automate.stage.store', $auto->uuid) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Stage Title</label>
                                                    <input type="text" name="title" class="form-control" id="title" placeholder="Title" autocomplete="off" required value="{{ old('title') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputState">Email List [title | date added]</label>
                                                <select id="inputState" class="form-control" name="list_id" required>
                                                    <option selected disabled>Select Mail List</option>
                                                    @foreach($lists as $list)
                                                        <option value="{{ $list->uuid }}" {{ old('list_id')===$list->uuid?'selected':'' }}>{{ "{$list->title} | ".date("F d, Y", strtotime($list->updated_at)) }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">List Filter</label>
                                                <select id="inputEmail4" class="form-control" name="list_filter" required>
                                                    <option value="" selected>Select One Filter</option>
                                                    <option value="active" {{ old('list_filter')==='active'?'selected':'' }}>Active</option>
                                                    <option value="inactive" {{ old('list_filter')==='inactive'?'selected':'' }}>Inactive</option>
                                                    <option value="member" {{ old('list_filter')==='member'?'selected':'' }}>Members</option>
                                                    <option value="non member" {{ old('list_filter')==='non member'?'selected':'' }}>Non Members</option>
                                                    <option value="v non-member" {{ old('list_filter')==='v non-member'?'selected':'' }}>Email Verified Non-Member</option>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Create Stage</button>
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

    <script>
        $(document).ready(function () {

        })
    </script>

@endsection