@extends('layouts.admin')
@section('content')
    <form action="/admin/meeting/add" method="POST">
        @csrf
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Meeting</h6>
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

                    <!-- modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Meeting Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter meeting title" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Meeting ID</label>
                            <input type="text" name="meeting_id" class="form-control" placeholder="Enter meeting ID" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Meeting Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password (optional)" />
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="checkbox" value="1" id="defaultCheck1" >
                            <label class="form-check-label" for="defaultCheck1">
                                Enable Microphone for All Attendees.
                                <br>
                                <sub>Only recommended for smaller meetings where users can assume participants will be responsible for using their microphones. Otherwise, it's recommended to leave this function off. Moderators can still unmute or mute participants.</sub>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="desktop" value="1" id="defaultCheck2" >
                            <label class="form-check-label" for="defaultCheck2">
                                Enable Desktop Sharing for All Attendees.
                                <br>
                                <sub>Only recommended for smaller meetings where users can assume participants will be responsible with sharing their desktops. Otherwise, it's recommended to leave this function off. Moderators and team users can edit this setting while a meeting is in session, which would require an attendee to refresh their screen to view the option.</sub>
                            </label>
                        </div>
                    </div>

                    <!-- modal footer -->
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50"><i class="fa fa-plus"></i></span>
                            <span class="text">Create</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </form>
@endsection
