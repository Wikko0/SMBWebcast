@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Logo & Image Setting</h6>
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
        <form method="post" action="/admin/logo-settings" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="control-label col-sm-3"></label>
                    <div class="col-sm-9">
                        @if(!empty($images->logo))
                            <img id="website_logo" src="{{asset($images->logo)}}"  alt="logo" >
                        @else
                            <img id="website_logo" src="{{asset('img/logo.png')}}"  alt="logo" >
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-sm-3">Website Logo</label>
                    <div class="col-sm-9">
                        <input type="file" onchange="showImg(this,'website_logo');" name="logo" class="filestyle" accept="image/*">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="control-label col-sm-3"></label>
                    <div class="col-sm-9">
                        @if(!empty($images->image))
                            <img id="backdrop_image" src="{{asset($images->image)}}"  alt="backdrop_image" style="max-width: 440px" >
                        @else
                            <img id="backdrop_image" src="{{asset('img/login-bg.jpg')}}"  alt="backdrop_image" style="max-width: 440px" >
                        @endif

                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-sm-3">Loading Page Image</label>
                    <div class="col-sm-9">
                        <input type="file" onchange="showImg(this,'backdrop_image');" name="image" class="filestyle" accept="image/*">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="control-label col-sm-3"></label>
                    <div class="col-sm-9">
                        @if(!empty($images->favicon))
                            <img id="website_favicon" src="{{asset($images->favicon)}}"  alt="favicon" >
                        @else
                            <img id="backdrop_image" src="{{asset('favicon.ico')}}"  alt="backdrop_image" style="max-width: 440px" >
                        @endif

                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-sm-3">Favicon</label>
                    <div class="col-sm-9">
                        <input type="file" onchange="showImg(this,'website_favicon');" name="favicon" class="filestyle" accept="image/*">
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


    <!-- file select-->
    <script src="{{asset('plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
    <!-- file select-->



    <!--instant image dispaly-->
    <script type="text/javascript">
        function showImg(input,id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#'+id).attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <!--end instant image dispaly-->

@endsection
