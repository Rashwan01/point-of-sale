@extends("layouts.dashboard.app")

@section("content")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark d-inline">@lang("site.orders")</h1><small>{{$orders->count()}}</small>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard.')}}">@lang("site.home")</a></li>
            <li class="breadcrumb-item active">@lang("site.orders")</li>
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
      <div class="col-8">
        <div class="card">
          <div class="card-header">

            <div class="card-tools">
              <form action="{{route('dashboard.orders.index')}}" method="get">

                <div class="input-group input-group-sm " >
                  <input type="text" name="search" class="form-control float-right" placeholder="@lang('site.search')" value="{{request()->search}}">


                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>

            </div>

          </div>
          @if($orders->count()>0)
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>@lang("site.clientName")</th>
                  <th>@lang("site.price")</th>
                  <th>@lang("site.created_at")</th>
                  <th>@lang("site.action")</th>
                </tr>
              </thead>
              <tbody>

                @foreach ($orders as $order )
                <tr>
                  <td>{{ $order->Client->name }}</td>
                  <td>{{ $order->total_price }}</td>
                  <td>{{ $order->created_at->diffForHumans() }}</td>
                  <td>
                    <div class="row">
                      @permission("read-orders")
                      <div class="col-md-4">
                        <a   data-url="{{route('dashboard.orders.products',$order->id)}}" class="btn  btn-primary text-white btn-sm order-products"><span class="fa fa-sm fa-list ml-2 "></span>@lang("site.show")</a>
                      </div>
                      @else
                      <div class="col-md-4">
                        <button style="cursor: not-allowed;"  class="btn  btn-primary btn-sm disabled"><span class="fa fa-sm fa-edit ml-2"></span>@lang("site.edit")</button>
                      </div>
                      @endpermission
                      @permission("update-orders")
                      <div class="col-md-4">
                        <a  href="{{route('dashboard.clients.order.edit',[$order->client->id,$order->id])}}" class="btn  btn-warning  text-white btn-sm"><span class="fa fa-sm fa-edit ml-2"></span>@lang("site.edit")</a>
                      </div>
                      @else
                      <div class="col-md-4">
                        <button style="cursor: not-allowed;"  class="btn  btn-warning text-white  btn-sm disabled"><span class="fa fa-sm fa-edit ml-2"></span>@lang("site.edit")</button>
                      </div>
                      @endpermission
                      @permission("delete-orders")
                      <div class="col-md-4">
                        <form action="{{route('dashboard.orders.destroy',$order->id)}}" method="post">
                          @csrf
                          @method('delete')
                          <button type="submit" class="btn btn-block btn-danger btn-sm"><span class="fa fa-sm fa-trash ml-2"></span>@lang("site.delete")</button>
                        </form>
                      </div>
                      @else
                      <div class="col-md-4">
                        <button style="cursor: not-allowed;"  class="btn btn-block btn-danger btn-sm disabled"><span class="fa fa-sm fa-trash  ml-2"></span>@lang("site.delete")</button>
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
      <div class="col-md-4 products-position">

      </div>
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
