@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">System Settings</h6>
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
        <form method="post" action="/admin/settings">
            @csrf
         <!-- panel  -->
                <!-- panel  -->
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">App Name</label>
                        <div class="col-sm-9">
                            <input type="hidden"  value="{{$settings->id}}" name="id"/>
                            <input type="text"  value="{{$settings->app_name}}" name="app_name" class="form-control" required  />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Jitsi Server URL</label>
                        <div class="col-sm-9">
                            <input type="text"  value="{{$settings->jitsi_url}}" name="jitsi_url" class="form-control" required  />
                            <p><small>Upstreaming server address.You can use your own server by self host software download from here:</small></p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label"><strong>Privacy Policy URL FOR ANDROID</strong></label>
                        <div class="col-sm-9">
                            <input type="text"  value="{{env('APP_URL').$settings->policy_url}}" readonly class="form-control" required data-parsley-length="[14, 128]" />
                            <p><small>Copy &amp; paste this URL to app source code.</small></p>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Meeting ID Prefix</label>
                        <div class="col-sm-9">
                            <input type="text"  value="{{$settings->meeting_id}}" name="meeting_prefix" class="form-control" required  />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Email Address</label>
                        <div class="col-sm-9">
                            <input type="text"  value="{{$settings->address}}" name="address" class="form-control" required  />
                             </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-9">
                            <input type="number"  value="{{$settings->phone}}" name="phone" class="form-control" data-parsley-length="[10, 14]"  />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Privacy &amp; Policy</label>
                        <div class="col-sm-9">
                            <textarea name="policy_text" id="privacy_policy_text" rows="10" class="form-control">{{$settings->policy}}</textarea>
                            <p><small>HTML is allowed</small></p>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50"><i class="fa fa-check"></i></span>
                        <span class="text">Save Changes</span>
                    </button>
                </div>
        </form>
                </div>
        </div>
    </div>
    </div>

    <script type="text/javascript" src="{{asset('plugins/parsleyjs/dist/parsley.min.js')}}"></script>
    <script src="{{asset('plugins/summernote/dist/summernote.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#privacy_policy_text').summernote({
                height: 200, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });
            $('form').parsley();
        });
    </script>


@endsection
