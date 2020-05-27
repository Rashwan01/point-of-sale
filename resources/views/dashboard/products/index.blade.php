@extends("layouts.dashboard.app")

@section("content")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark d-inline">@lang("site.products")</h1><small>{{$products->count()}}</small>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard.')}}">@lang("site.home")</a></li>
            <li class="breadcrumb-item active">@lang("site.products")</li>
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
            <h3 class="card-title">@lang("site.products")

            </h3>

            <div class="card-tools">
              <form action="{{route('dashboard.products.index')}}" method="get">

                <div class="input-group input-group-sm " >
                  <input type="text" name="search" class="form-control float-right" placeholder="@lang('site.search')" value="{{request()->search}}">


                  <select name="category_id" class="form-control ml-5 ">
                    <option value="" >@lang("site.allCategories")</option>
                    @foreach($categories as $category)
                    <option @if(request("category_id")==$category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach

                  </select>
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>

            </div>
            @permission("create-products")
            <a href="{{route('dashboard.products.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i>@lang("site.add")</a>
            @else
            <button style="cursor: not-allowed;"  class="btn  btn-primary btn-sm disabled">@lang("site.add")<i class="fas fa-plus"></i></button>
            @endpermission
          </div>
          @if($products->count()>0)
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>@lang("site.id")</th>
                  <th>@lang("site.name")</th>
                  <th>@lang("site.description")</th>
                  <th>@lang("site.category")</th>
                  <th>@lang("site.image")</th>
                  <th>@lang("site.purchase_price")</th>
                  <th>@lang("site.sale_price")</th>
                  <th>@lang("site.profit_percent")</th>
                  <th>@lang("site.stock")</th>

                  <th>@lang("site.action")</th>


                </tr>
              </thead>
              <tbody>

                @foreach ($products as $product )
                <tr>
                  <td>{{ $product->id }}</td>
                  <td>{{ $product->title }}</td>
                  <td>{!! $product->description !!}</td>
                  <td>{{ $product->category->name }}</td>
                  <td><img  src="{{$product->image_path}}" width="50px" height="50px" ></td>
                  <td>{{ $product->purchase_price }}</td>
                  <td>{{ $product->sale_price }}</td>
                  <td>{{ $product->profit_percent }}</td>
                  <td>{{ $product->stock }}</td>
                  <td>
                    <div class="row">
                     @permission("update-products")
                     <div class="col-md-6">
                      <a  href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-block btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang("site.edit")</a>
                    </div>
                    @else
                    <div class="col-md-6">
                      <button style="cursor: not-allowed;"  class="btn btn-block btn-primary btn-sm disabled"><i class="fa fa-edit" aria-hidden="true"></i>@lang("site.edit")</button>
                    </div>
                    @endpermission
                    @permission("delete-products")
                    <div class="col-md-6">
                      <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-block btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i>@lang("site.delete")</button>
                      </form>
                    </div>
                    @else
                    <div class="col-md-6">
                      <button style="cursor: not-allowed;"  class="btn btn-block btn-danger btn-sm disabled"><i class="fa fa-trash" aria-hidden="true"></i>@lang("site.delete")</button>
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
