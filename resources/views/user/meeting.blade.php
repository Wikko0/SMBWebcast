@extends('layouts.user')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Meetings</h6>
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
                    <div class="col-md-9">
                        <div class="form-group mx-sm-3 mb-2 form-inline">
                            <form method="get" action="/user/meeting">
                                <label for="title" class="sr-only">Meeting Title</label>
                                <input type="text" name="meeting_code" class="form-control form-control-sm" id="title" placeholder="Meeting Title">&nbsp;
                                <button type="submit" class="btn btn-primary btn-sm btn-icon-split">
                                    <span class="icon text-white-50"><i class="fa fa-search"></i></span>
                                    <span class="text">Search</span>
                                </button>
                            </form>
                            <form class="ml-5" method="post" action="/join">
                                @csrf
                                <label for="title" class="sr-only">Meeting ID</label>
                                <input type="text" name="meeting_id" class="form-control form-control-sm" id="title" placeholder="Meeting ID">&nbsp;
                                <input type="text" name="password" class="form-control form-control-sm" id="title" placeholder="Password">&nbsp;
                                <button type="submit" class="btn btn-primary btn-sm btn-icon-split">
                                    <span class="icon text-white-50"><i class="fa fa-camera"></i></span>
                                    <span class="text">Join</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Meeting Title</th>
                            <th>Meeting ID</th>
                            <th>Created by</th>
                            <th>Created At</th>
                            <th>Moderator Link</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($meetings as $meeting)
                        <tr id='row_{{$meeting->id}}'>
                            <td>{{$meeting->id}}</td>

                            <td><strong>{{$meeting->title}}</strong></td>
                            <td>{{$meeting->meeting_id}}</td>
                            <td>{{$meeting->created_by}}</td>
                            <td>{{$meeting->created_at}}</td>
                            <td>

                                <form class="user" action="/user/join_meeting" method="post">
                                    @csrf
                                    <div class="dropdown no-arrow mb-4">
                                        <input type="hidden" name="meeting_id" value="{{$meeting->meeting_id}}" required class="form-control form-control-user" placeholder="Enter Meeting ID">

                                    <button type="submit" class="btn btn-primary btn-user btn-block">Join</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
