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
            <li class="breadcrumb-item "><a href="{{route('dashboard.categories.index')}}">@lang("site.categorys")</a></li>
            <li class="breadcrumb-item active">@lang("site.edit")</li>
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
              <h3 class="card-title float-left">@lang("site.editCategory")</h3>



            </div>

            @include("layouts.dashboard.errors")
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action = "{{route('dashboard.categories.update',$category->id)}}" enctype="multipart/form-data">
              @csrf
              @method('put')
              <div class="card-body">
               @foreach(config('translatable.locales') as $local)

               <div class="card-body">
                <div class="form-group">
                  <label for="nameInput">@lang('site.'.$local.'.name')</label>
                  <input name="{{$local}}[name]" type="text" class="form-control" id="nameInput" value = "{{$category->translate($local)->name}}">
                </div>
              </div>
              @endforeach
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
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
