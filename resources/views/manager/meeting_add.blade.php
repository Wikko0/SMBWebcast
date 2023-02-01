@extends('layouts.manager')
@section('content')
    <form action="/manager/meeting/add" method="POST">
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
