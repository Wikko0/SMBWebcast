@extends('layouts.user')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update profile information</h6>
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
        <form method="post" action="/user/profile/update" enctype="multipart/form-data">
            @csrf
         <!-- panel  -->
            <div class="row">
                <div class="col-md-12">
                    @if($profile->image)
                    <div class="profile-info-name text-center col-sm-6"> <img id="profile_image" src="{{asset('storage/'.$profile->image)}}" class="thumb-lg img-circle img-thumbnail" alt="/" >
                        @else
                    <div class="profile-info-name text-center col-sm-6"> <img id="profile_image" src="{{asset('img/user.jpg')}}" class="thumb-lg img-circle img-thumbnail" alt="/" >
                    @endif
                                <h4 class="m-b-5"><b>{{$profile->name}}</b></h4>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Change Photo</label>
                        <div class="col-sm-6">
                            <input type="file" onchange="showImg(this);" name="photo" class="filestyle" data-input="false" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-6">
                            <input type="hidden"  value="{{$profile->id}}" name="id"/>
                            <input type="text"  value="{{$profile->name}}" name="name" class="form-control" required placeholder="Enter Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="email"  value="{{$profile->email}}" name="email" class="form-control" required placeholder="Enter email" />
                        </div>
                    </div>
                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                        <button type="submit" class="btn btn-primary"><span class="btn-label"><i class="fa fa-refresh"></i></span>Update </button>
                    </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
        </div>
        <div class="card-body">
            <form method="post" action="/manager/profile/changepassword">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Current Password</label>
                        <div class="col-sm-6">
                            <input type="password"  name="password" class="form-control" required placeholder="Enter current password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-6">
                            <input type="password"  id="new_password" name="new_password" class="form-control" required placeholder="Enter new password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Retype New Password</label>
                        <div class="col-sm-6">
                            <input type="password"  data-parsley-equalto="#new_password" name="retype_new_password" class="form-control" required placeholder="Enter new password" />
                        </div>
                    </div>
                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                        <button type="submit" class="btn btn-primary"><span class="btn-label"><i class="fa fa-refresh"></i></span> Change Now</button>
                    </div>

                </form>
                </div>
            </div>
        </div>
    </div>



    <!--instant image dispaly-->
    <script type="text/javascript">
        function showImg(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#profile_image')
                        .attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <!--end instant image dispaly-->


@endsection
