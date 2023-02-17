@extends('layouts.manager')
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

        <!-- panel  -->
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="/manager/profile/update" enctype="multipart/form-data">
                        @csrf
                        @if($profile->image)
                            <div class="profile-info-name text-center col-sm-6"><img id="profile_image"
                                                                                     src="{{asset($profile->image)}}"
                                                                                     class="thumb-lg img-circle img-thumbnail"
                                                                                     alt="/">
                                @else
                                    <div class="profile-info-name text-center col-sm-6"><img id="profile_image"
                                                                                             src="{{asset('img/user.jpg')}}"
                                                                                             class="thumb-lg img-circle img-thumbnail"
                                                                                             alt="/">
                                        @endif
                                        <h4 class="m-b-5"><b>{{$profile->name}}</b></h4>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Change Photo</label>
                                        <div class="col-sm-6">
                                            <input type="file" onchange="showImg(this);" name="photo" class="filestyle"
                                                   data-input="false" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-6">
                                            <input type="hidden" value="{{$profile->id}}" name="id"/>
                                            <input type="text" value="{{$profile->name}}" name="name"
                                                   class="form-control" required placeholder="Enter Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-6">
                                            <input type="email" value="{{$profile->email}}" name="email"
                                                   class="form-control" required placeholder="Enter email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Team name</label>
                                        <div class="col-sm-6">
                                            <input type="text" value="{{$team->name}}" name="team" class="form-control"
                                                   required placeholder="Enter team"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                                        <button type="submit" class="btn btn-primary"><span class="btn-label"><i
                                                    class="fa fa-refresh"></i></span>Update
                                        </button>
                                    </div>

                    </form>
                </div>
            </div>

        </div>

    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Billing History</h6>
        </div>
        <div class="card-body">

                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Your Plan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$billing->product_name}}" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Amount Total</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$billing->currency. ' ' .$billing->product_price}}" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Payment Method</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{ucfirst($billing->payment_method)}}" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{ucfirst($billing->status)}}" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Expires</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$time}}" readonly/>
                            </div>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9 m-t-15">
                            <a href="{{$billing->cancellation_link}}" target="_blank">
                                <button type="button" class="btn btn-primary">
                      <span class="btn-label">
                        <i class="fa fa-refresh"></i>
                      </span>
                                    Cancel Subscribe
                                </button>
                            </a>

                            <a href="{{$billing->cancellation_link}}" target="_blank">
                                <button type="button" class="btn btn-primary">
                      <span class="btn-label">
                        <i class="fa fa-refresh"></i>
                      </span>
                                    Subscribe
                                </button>
                            </a>
                        </div>


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
                                <input type="password" name="password" class="form-control" required
                                       placeholder="Enter current password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">New Password</label>
                            <div class="col-sm-6">
                                <input type="password" id="new_password" name="new_password" class="form-control"
                                       required placeholder="Enter new password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Retype New Password</label>
                            <div class="col-sm-6">
                                <input type="password" data-parsley-equalto="#new_password" name="retype_new_password"
                                       class="form-control" required placeholder="Enter new password"/>
                            </div>
                        </div>
                        <div class="col-sm-offset-3 col-sm-9 m-t-15">
                            <button type="submit" class="btn btn-primary"><span class="btn-label"><i
                                        class="fa fa-refresh"></i></span> Change Now
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Delete Profile</h6>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('manager.delete', ['id' => Auth::id()]) }}">
                @csrf
                @method('DELETE')
                <div class="row">
                    <div class="col-md-12">
                        <p>Are you sure you want to delete your profile?</p>
                        <div class="col-sm-offset-3 col-sm-9 m-t-15">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                                <span class="btn-label"><i class="fa fa-trash"></i></span> Delete Profile
                            </button>
                            <a href="{{ url('/manager') }}" class="btn btn-default">
                                <span class="btn-label"><i class="fa fa-arrow-left"></i></span> Back
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Profile</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete your profile?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger"><span class="btn-label"><i
                                            class="fa fa-trash"></i></span> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
