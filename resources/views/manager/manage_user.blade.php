@extends('layouts.manager')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Management</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                    </button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    <ul>{{session('success')}}</ul>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                    </button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                    @foreach ($errors->all() as $error)
                        <ul>{{ $error }}</ul>
                    @endforeach
                </div>
            @endif
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
                            <form class="form-inline " method="get" action="/manager/manage">
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
                                        <a class="dropdown-item" href="/admin/manage/edit/{{$user->id}}">Edit</a>
                                        <a class="dropdown-item" href="/admin/manage/delete/{{$user->id}}">Delete</a>
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





@endsection
