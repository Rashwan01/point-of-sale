@extends("layouts.dashboard.app")

@section("content")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark d-inline">@lang("site.categories")</h1><small>{{$categories->count()}}</small>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard.')}}">@lang("site.home")</a></li>
            <li class="breadcrumb-item active">@lang("site.categories")</li>
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
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">@lang("site.categories")

            </h3>

            <div class="card-tools">
              <form action="{{route('dashboard.categories.index')}}" method="get">

                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="search" class="form-control float-right" placeholder="@lang('site.search')" value="{{request()->search}}">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>

            </div>
            @permission("create-categories")
            <a href="{{route('dashboard.categories.create')}}" class="btn btn-primary btn-sm">@lang("site.add")<i class="fas fa-plus"></i></a>
            @else
            <button style="cursor: not-allowed;"  class="btn  btn-primary btn-sm btn-sm disabled">@lang("site.add")<i class="fa fa-plus-circle" aria-hidden="true"></i> </button>
            @endpermission
          </div>
          @if($categories->count()>0)
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>@lang("site.id")</th>
                  <th>@lang("site.name")</th>
                  <th>@lang("site.product_count")</th>
                  <th>@lang("site.realted_product")</th>
      
                  <th>@lang("site.action")</th>


                </tr>
              </thead>
              <tbody>

                @foreach ($categories as $category )
                <tr>
                  <td>{{ $category->id }}</td>
                  <td>{{ $category->name }}</td>
                  <td>{{ $category->products->count() }}</td>
                  <td><a href="{{route('dashboard.products.index',['category_id'=>$category->id])}}" class="btn btn-info btn-sm"> @lang("site.realted_product")</a></td>
                  <td>
                    <div class="row">
                     @permission("update-categories")
                     <div class="col-md-3">
                      <a  href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-sm fa-edit ml-2" aria-hidden="true"></i>@lang("site.edit") </a>
                    </div>
                    @else
                    <div class="col-md-3">
                      <button style="cursor: not-allowed;"  class="btn  btn-primary btn-sm disabled"><i class="fa fa-sm fa-edit ml-2" aria-hidden="true"></i>@lang("site.edit")</button>
                    </div>
                    @endpermission
                    @permission("delete-categories")
                    <div class="col-md-3">
                      <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn  btn-danger btn-sm"><i class="fa fa-sm fa-trash ml-2" aria-hidden="true"></i>@lang("site.delete")</button>
                      </form>
                    </div>
                    @else
                    <div class="col-md-3">
                      <button style="cursor: not-allowed;"  class="btn  btn-danger btn-sm disabled"><i class="fa fa-sm fa-trash ml-2" aria-hidden="true"></i>@lang("site.delete")</button>
                    </div>
                    @endpermission
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        @else
        <h1 class="text-center">@lang("site.no_data_found")</h1>
        @endif
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
