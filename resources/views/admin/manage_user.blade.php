@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Management</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.manage_user_add') }}" class="btn btn-primary btn-sm btn-icon-split">
                                <span class="icon text-white-50"><i class="fa fa-plus"></i></span>
                                <span class="text">Add</span>
                            </a>
                            <br>
                        </div>
                        <div class="col-md-9">
                            <form class="form-inline " method="get" action="/admin/manage">
                                <div class="form-group mx-sm-3 mb-2">
                                    <label for="title" class="sr-only">Name</label>
                                    <input type="text" name="name" class="form-control form-control-sm" id="title" placeholder="User Name">&nbsp;
                                    <button type="submit" class="btn btn-primary btn-sm btn-icon-split">
                                        <span class="icon text-white-50"><i class="fa fa-search"></i></span>
                                        <span class="text">Search</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Option</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Personal Meeting ID</th>
                            <th>Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr id='row_{{$user->id}}'>
                            <td>{{$user->id}}</td>
                            <td>
                                <div class="dropdown no-arrow mb-4">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mymodal" data-id="admin/manage/edit{{$user->id}}" id="menu" title="<?php echo trans('edit'); ?>">Edit</a>
                                        <a class="dropdown-item" href="#" title="delete" onclick="delete_row(<?php echo " 'user' ".','.$user->id;?>)" class="delete">Delete</a>
                                    </div>
                                </div>
                            </td>
                            <td><strong>{{$user->name}}</strong></td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->name}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{asset('assets/plugins/parsleyjs/dist/parsley.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>

    <!-- select2-->
    <script src="{{asset('assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
    <!-- select2-->


@endsection
