<?php
$sidenav['groups'] = 'active';
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
                            <i class="anticon anticon-unordered-list"></i>
                        </div>
                        <div class="media-body m-l-15">
                            <h6 class="mb-0">Groups</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <!-- Card View -->
                <div class="row" id="list-view">
                    <div class="col-md-12">
                        @include('layouts.notice')
                        <?php $info = $data->toArray() ?>
                        @if(!empty($info['from']))
                            <b>
                                Showing : {{ !empty($info['from'])?$info['from']:0 }} - {{ !empty($info['to'])?$info['to']:0 }} <i class="ml-3 mr-3"> of </i> {{ $info['total'] }}
                            </b>

                        @else
                            No Result
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <button type="button" class="btn btn-primary btn-tone" data-toggle="modal" data-target="#createGroup">
                                        <i class="anticon anticon-plus"></i>
                                        <span class="m-l-5">Create Group</span>
                                    </button>

                                    {{--                                    <a  type="button" href="{{ route('add_recipient.from-search', ['type'=>@$type, 'start'=>@$start,'end'=>@$end]) }}" class="btn btn-primary " data-toggle="tooltip" data-placement="top" title="Download Selected Type">Download </a>--}}
                                    {{--<a  href="#" class="btn btn-primary " data-toggle="tooltip" data-placement="top" title="Download Selected Type">Add To List</a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Names</th>
                                            <th>Members</th>
                                            <th>Created</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $group)
                                            <tr>
                                                <td>
                                                    <h6 class="mb-0">{{ $group->name }}</h6>
                                                </td>
                                                <td>{{ $group->members->count() }}</td>
                                                <td>{{ date('F d, Y', strtotime($group->created_at)) }}</td>
                                                <td class="text-right">

                                                    <a href="{{ route('group.members', $group->uuid) }}" class="btn btn-success btn-tone load_members">
                                                        <i class="fas fa-user-circle"></i>
                                                        <span class="m-l-5">Members</span>
                                                    </a>
                                                    <a href="#" onclick="event.preventDefault(); deleteItem('{{ route('group.pop', $group->uuid) }}') " class="btn btn-danger btn-tone doload">
                                                        <i class="fas fa-trash"></i>
                                                        <span class="m-l-5">Delete</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <h6 class="text-center">No Entries yet</h6>
                                                </td>
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>

                                <br>
                                {{ $data->appends(request()->input())->links() }}
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
    <!-- Button trigger modal -->

    <!-- Modal -->

    <div class="modal fade" id="createGroup">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Create Group</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="">
                        <form action="{{ route('groups.store') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fn">Name *</label>
                                    <input type="text" name="name" class="form-control" id="fn" placeholder="Name" autocomplete="off" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ln">key (optional)</label>
                                    <input type="text" name="key" class="form-control" id="ln" placeholder="Unique Key" autocomplete="off">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="em">Details (optional)</label>
                                    <textarea  name="info" class="form-control" id="title" placeholder="Details "></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="groupMembers">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Members</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="">Loading...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.load_members').on('click', function(e){
            e.preventDefault();
            let modal_body = $('#groupMembers').modal('show').find('.modal-body');
            modal_body.load($(this).attr('href'));

        });

        // $('.remove_member').on('click', function(e){
        //     e.preventDefault();
        //     $(this).children().remove();
        //     let uuid = $(this).attr('href');
        //     $(this).append(`<span>Loading...</span>`)
        //     let url = $(this).attr('href');
        //     $.get( url, function() {
        //
        //     }).done(function(data) {
        //         //delete row
        //         console.log(data);
        //         $(`.remove${uuid}`).remove();
        //
        //     }).fail(function() {
        //         $(this).append(`<i class="fas fa-trash"></i><span class="m-l-5">Delete</span>`)
        //     }).always(function() {
        //
        //     });
        // });
    </script>
@endsection
