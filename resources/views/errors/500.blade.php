
@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code')
    Page or Meeting Doesn't Exist.<br>
@endsection
@section('message')
    Please enter your meeting ID and optionally a password to try again.<br>
<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
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



                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


                                    <form class="user" action="/join" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="meeting_id" required class="form-control form-control-user" placeholder="Enter Meeting ID" value="{{ old('meeting_id')??Cookie::get('last_meeting_id') }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Enter Meeting Password(optional)" value="{{ old('password')??Cookie::get('meeting_password')}}">
                                            <div class="my-2"></div>

                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Join Now</button>
                                    </form>



                                </div>
                            </div>
                            <hr>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
