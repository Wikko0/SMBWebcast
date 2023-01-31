@extends('layouts.manager')
@section('content')
    <form action="/admin/add" method="POST">
        @csrf
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add User</h6>
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
                            <label class="control-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter user full name" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter email" />
                        </div>

                        <div class="form-group">
                            <label class="control-label">Login Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter login password" />
                        </div>


                        <div class="form-group">
                            <label class="control-label">User Role</label>
                            <select class="form-control" name="role" required>
                                <option value="manager">Manager</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Team</label>
                            <input type="text" name="team" class="form-control" placeholder="Enter team name" />
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
