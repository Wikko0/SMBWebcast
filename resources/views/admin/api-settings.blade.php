@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">PlugnPaid Settings</h6>
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
        <form method="post" action="/admin/api-settings">
            @csrf
         <!-- panel  -->
                <!-- panel  -->
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">PlugnPaid API</label>
                        <div class="col-sm-9">
                            <input type="hidden"  value="{{$api->id}}" name="id"/>
                            <input type="text"  value="{{$api->plugnpaid_api}}" name="plugnpaid_api" class="form-control" required  />
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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Google Sheets Integration</h6>
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
            <form method="post" action="/admin/api-google">
            @csrf
            <!-- panel  -->
                <!-- panel  -->
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Google Sheets - Client ID</label>
                        <div class="col-sm-9">
                            <input type="hidden"  value="{{$google->id}}" name="id"/>
                            <input type="text"  value="{{$google->google_client_id}}" name="google_client_id" class="form-control" required  />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Google Sheets - Client Secret</label>
                        <div class="col-sm-9">
                            <input type="text"  value="{{$google->google_client_secret}}" name="google_client_secret" class="form-control" required  />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Google Sheets - Spreadsheet</label>
                        <div class="col-sm-9">
                            <input type="text"  value="{{$google->spreadsheet}}" name="spreadsheet" class="form-control" required  />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Google Sheets - Sheet Name</label>
                        <div class="col-sm-9">
                            <input type="text"  value="{{$google->sheet_name}}" name="sheet_name" class="form-control" required  />
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



@endsection
