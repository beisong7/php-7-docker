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

        <div class="page-header">
            <h2 class="header-title">Mail Lists recipients</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>Dashboard</a>
                    <a class="breadcrumb-item" href="{{ route('maillist.index') }}">Maillist</a>
                    <span class="breadcrumb-item active">{{ $list->title }} Recipients</span>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    @if($recipients->count()>0)
                                        <a href="#" onclick="event.preventDefault(); removeRecipients('{{ route('mail-list.del-all.items', $list->uuid) }}')" class="btn btn-danger btn-tone float-right">
                                            <i class="anticon anticon-delete"></i>
                                            Remove All
                                        </a>
                                    @endif
                                    <a href="{{ route('member.index') }}" class="btn btn-primary btn-tone float-right mr-3">
                                        <i class="anticon anticon-plus"></i>
                                        Add Members
                                    </a>

                                        <a href="{{ route('add.one.to.mail-list', $list->uuid) }}" class="doload btn btn-success btn-tone mr-3 ">
                                            <span class="m-l-5" title="Add recipient directly">
                                                <i class="anticon anticon-plus"></i>
                                                Add Generic Members
                                            </span>
                                        </a>
                                </div>
                                <br>

                                @include('layouts.notice')
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Email</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($recipients as $recipient)
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <h6 class="mb-0">{{ $recipient->first_name }}</h6>
                                                    </div>
                                                </td>
                                                <td>{{ $recipient->email }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('mail-list.remove_recipient', ['list_id'=>$list->uuid, 'recipient_id'=>$recipient->uuid]) }}" class="btn btn-danger btn-tone">
                                                        <i class="anticon anticon-delete"></i>
                                                        <span class="m-l-5">Remove</span>
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
                                {{ $recipients->links() }}
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
    <div class="modal fade" id="addMemberToList">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add member to List</h5>
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
        function removeRecipients(url) {
            var answer = prompt("Are you sure you want to remove all recipients? type 'yes' to continue");
            if (answer === "yes") {
                window.location = url
            }else{

            }
        }
    </script>

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