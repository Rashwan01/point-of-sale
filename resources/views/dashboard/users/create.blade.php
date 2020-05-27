@extends("layouts.dashboard.app")

@section("content")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">@lang("site.dashboard")</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">@lang("site.home")</a></li>
            <li class="breadcrumb-item "><a href="{{route('dashboard.user.index')}}">@lang("site.users")</a></li>
            <li class="breadcrumb-item active">@lang("site.add")</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title float-left">@lang("site.addUser")</h3>
            </div>

            @include("layouts.dashboard.errors")
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action = "{{route('dashboard.user.store')}}" enctype="multipart/form-data">
              @csrf
              @method('post')
              <div class="card-body">
                <div class="form-group">
                  <label for="FirstNameInput">@lang("site.first_name")</label>
                  <input name="first_name" type="text" class="form-control" id="FirstNameInput" value = " {{old('first_name') }}">
                </div>
                <div class="form-group">
                  <label for="LastNameInput">@lang("site.last_name")</label>
                  <input name="last_name" type="text" class="form-control" id="LastNameInput" value =" {{old('last_name') }}" >
                </div>
                <div class="form-group">
                  <label for="EmailInput">@lang("site.email")</label>
                  <input name="email" type="email" class="form-control" id="EmailInput"  value ="{{old('email') }}">
                </div>
                <div class="form-group">
                  <label for="PasswordInput">@lang("site.password")</label>
                  <input name="password" type="password" class="form-control" id="PasswordInput" >
                </div>
                <div class="form-group">
                  <label for="PasswordConfirmationInput">@lang("site.password_confirmation")</label>
                  <input name="password_confirmation" type="password" class="form-control" id="PasswordConfirmationInput" >
                </div>

                <div class="form-group">
                  <label for="image">@lang("site.image")</label>
                  <input name="image" type="file" class="form-control " id="image" >
                </div>

                <div class="form-group">
              <img id="image-preivew" src="/uploads/user_image/default.jpg" class="rounded-circle" width="150px" height="150px" style="border:2px solid#777">
                </div>
                <div class="form-group">

                  <div class="card-body">
                    <h4>@lang('site.permission')</h4>
                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                      <?php 
                      $models = ['users','categories','products','clients','orders'];
                      $maps = ['create',"read","update","delete"];
                      ?>
                      @foreach($models as $index=>$model)
                      <!-- tabs-->
                      <li class="nav-item ">
                        <a class="nav-link {{ $index == 0 ? 'active':''}}" id="{{$model}}-tab" data-toggle="pill" href="#{{$model}}" role="tab" aria-controls="{{$model}}" aria-selected="true">@lang('site.'.$model )</a>
                      </li>
                      <!-- tabs-->
                      @endforeach




                    </ul>
                    <div class="tab-content" id="custom-content-below-tabContent">
                     @foreach($models as $index=>$model)
                     <div class="tab-pane fade show  {{ $index == 0 ? 'active':''}} " id="{{$model}}" role="tabpanel" aria-labelledby="{{$model}}-tab">
                      <div class="form-group mt-5">
                        @foreach($maps as $map)
                        <!-- start check box scope-->
                        <div class="custom-control custom-checkbox">
                          <input
                          class="custom-control-input"
                          type="checkbox"
                          name="permissions[]"
                          value="{{$map.'-'.$model}}"
                          id="createcheckbox{{$map}}{{$model}}"
                          >
                          <label for="createcheckbox{{$map}}{{$model}}" class="custom-control-label">@lang('site.'.$map)</label>
                        </div>

                        @endforeach
                        <!-- end check box scope-->

                      </div>

                    </div>
                    @endforeach




                  </div>
                </div>
              </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">@lang('site.add')</button>
            </div>
          </form>
        </div>
        <!-- /.card -->



      </div>
    </div>

    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
