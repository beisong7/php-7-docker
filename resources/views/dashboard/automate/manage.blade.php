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
            <h2 class="header-title">Automate Stage</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('automate') }}">Automate</a>
                    <a class="breadcrumb-item" href="#">{{ $auto->title }}</a>
                    <span class="breadcrumb-item active">Manage</span>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('layouts.notice')
            </div>
            <div class="col-md-4">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-body">
                                <span class="text-capitalize"><b>Automate Details</b></span>
                                <a href="#" class="btn btn-danger btn-tone btn-sm  float-right" onclick="deleteItem('{{ route('automate.delete', $auto->uuid) }}')"><i class="fas fa-trash"></i></a>
                                <hr>
                                <div class="m-t-25">
                                    <h6>{{ $auto->title }}</h6>
                                    <p>{{ $auto->info }}</p>
                                </div>
                                <hr>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('automate.toggle.all', ['uuid'=>$auto->uuid,'action'=>'disable']) }}" class="btn btn-sm btn-warning btn-tone">Disable all Stage</a>
                                    <a href="{{ route('automate.toggle.all', ['uuid'=>$auto->uuid,'action'=>'enable']) }}" class="btn btn-sm btn-success btn-tone">Enable all Stage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <span class="text-capitalize"><b>Manage Stages</b></span>
                        <div class="m-t-25">

                            <div class="row ">
                                @foreach($auto->stagesByPos as $stage)
                                    <div class="col-md-4">
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <p class="mb-0">{{ $stage->title }} <span style="font-size: 7px" class="badge badge-{{ $stage->active?'primary':'danger' }}">{{ $stage->active?'live':'off' }}</span></p>
                                                    <p class="mb-0"><small>{{ @$stage->mailList->title }}</small></p>
                                                    <hr class="mt-0">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('automate.stage.toggle', $stage->uuid) }}" class="btn btn-{{ $stage->active?'danger':'success' }} btn-tone btn-sm" data-toggle="tooltip" data-placement="top" title="{{ $stage->active?'Click to Disable':'Click to Activate' }}">
                                                            {{ $stage->active?'Disable':'Activate' }}
                                                        </a>
                                                        <a href="{{ route('automate.stage.edit', $stage->uuid) }}" class="btn btn-warning btn-tone btn-sm">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    <div class="col-md-4">
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <p>Add a stage to <br> {{ $auto->title }}</p>
                                                    <a href="{{ route('automate.stage.create', $auto->uuid) }}" class="btn btn-tone btn-success">
                                                        <i class="fas fa-plus"></i>
                                                        ADD STAGE
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
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

        function deleteItem(url) {
            var answer = prompt("Are you sure you want to delete this item? type 'yes' to continue");
            if (answer === "yes") {
                window.location = url;
            }else{

            }
        }
    </script>

@endsection