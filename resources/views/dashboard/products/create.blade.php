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
              <h3 class="card-title float-left">@lang("site.addProduct")</h3>
            </div>

            @include("layouts.dashboard.errors")
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action = "{{route('dashboard.products.store')}}" enctype="multipart/form-data">
              @csrf
              @method('post')



              <div class="card-body">

                <!-- start category_id scope-->
                <div class="form-group">
                  <label for="category_id">@lang("site.category")</label>
                  <select name="category_id" class="form-control" id="category_id">
                    <option value="">@lang("site.choose_one") </option>
                    @foreach($categories  as $category)
                    <option value="{{$category->id}}" @if(old("category_id") == $category->id) selected @endif>{{$category->name}} </option>
                    @endforeach
                  </select>
                </div>
                <!-- end category_id scope-->
                @foreach(config('translatable.locales') as $local)
                <!-- start name scope-->
                <div class="form-group">
                  <label for="nameInput{{$local}}">@lang('site.'.$local.'.name')</label>
                  <input name="{{$local}}[title]" type="text" class="form-control" id="nameInput{{$local}}" value = " {{old($local.'.title') }}">
                </div>
                <!-- end name scope-->

                <!-- start description scope-->
                <div class="form-group">
                  <label for="descriptionInput{{$local}}">@lang('site.'.$local.'.description')</label>
                  <textarea name="{{$local}}[description]" type="text" class="form-control ckeditor" id="descriptionInput{{$local}}">{{old($local.'.description') }}</textarea>
                </div>
                <!-- end description scope-->
                <!-- start image scope-->
                @endforeach
                <div class="form-group">
                  <label for="image">@lang("site.image")</label>
                  <input name="image" type="file" class="form-control " id="image" >
                </div>
                <!-- end image scope-->

                <!-- start image scope-->
                <div class="form-group">
                  <img id="image-preivew" src="/uploads/user_image/default.jpg" class="rounded-circle" width="150px" height="150px" style="border:2px solid#777">
                </div>
                <!-- end image scope-->

                <!-- start purchase_price scope-->
                <div class="form-group">

                  <label for="purchase_price">@lang("site.purchase_price")</label>
                  <input name="purchase_price" type="number"  step = "0.01" class="form-control " id="purchase_price" value="{{old('purchase_price')}}"  >

                </div>
                <!-- end purchase_price scope-->
                <!-- start sale_price scope-->
                <div class="form-group">

                  <label for="sale_price">@lang("site.sale_price")</label>
                  <input name="sale_price"type="number"  step = "0.01"  class="form-control" value="{{old('sale_price')}}" id="sale_price"  >

                </div>
                <!-- end sale_price scope-->
                <!-- start stock scope-->
                <div class="form-group">

                  <label for="stock">@lang("site.stock")</label>
                  <input name="stock" type="text" class="form-control " id="stock" value="{{old('stock')}}"  >

                </div>
              </div>
              <!-- end sale_price scope-->
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
