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
        <div class="col-md-6">
          <h4>@lang("site.categories")</h4>

          <div class="card-body">
           <div class="card">

            <div class="card-body">
              <div id="accordion">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                @foreach($categories as $category)
                <div class="card card-info disabled">
                  <div class="card-header p-0" style="background-color: #3c9cff!important;">
                    <h4 class="card-title  float-left">

                      <a data-toggle="collapse" data-parent="#accordion" href="#{{str_replace(' ','-',$category->name)}}" style="text-decoration: none;display: block;  margin: 5px 17px;">

                        {{$category->name}}
                      </a>

                    </h4>
                  </div>
                  <div id="{{str_replace(' ','-',$category->name)}}" class="panel-collapse collapse in">
                    <div class="card-body">

                      <table class="table table-hover text-nowrap">
                        <thead>
                          <tr>
                            <th>@lang("site.name")</th>
                            <th>@lang("site.stock")</th>
                            <th>@lang("site.purchase_price")</th>
                            <th>@lang("site.action")</th>
                          </tr>
                        </thead>
                        <tbody>
                         @foreach($category->products as $product)
                         <tr>
                          <td>{{ $product->title }}</td>
                          <td>{{ $product->stock }}</td>
                          <td>{{ number_format($product->sale_price,2) }}</td>
                          <td>
                            <a id="product-{{$product->id}}" 
                              class="btn btn-primary text-white btn-sm update-cart
                              {{
                                (in_array($product->id,$order->products->pluck('id')->toArray())) ? 'btn-default disabled':''
                              }}
                              "
                              data-id="{{$product->id}}"
                              data-price="{{$product->sale_price}}"
                              data-name="{{$product->title}}"
                              >@lang('site.add')</a></td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.card -->
        </div>


        <div class="col-md-6">
          <h4>@lang("site.orders")</h4>

          <form action="{{route('dashboard.clients.order.update',[$client->id,$order->id])}}" method="post">
           <div class="card">

            <div class="card-body">
              <div id="accordion">
                @csrf  
                @method('put')
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>@lang("site.name")</th>
                      <th>@lang("site.quantity")</th>
                      <th>@lang("site.purchase_price")</th>
                      <th>@lang("site.action")</th>
                    </tr>
                  </thead>
                  <tbody id="order-list">
                    @foreach($order->products as $product)
                    <input type='hidden' name='products[]' value='{{$product->id}}'>
                    <tr>
                      <td>{{ $product->title }}</td>
                      <td>
                        <input type="number" name='quantities[]' class='form-controll product-quantity ' style='width:50px ;' data-price ='{{$product->sale_price}}' min="1" value="{{$product->pivot->quantity}}">
                      </td>
                      <td class="priceRow">{{number_format($product->pivot->quantity * $product->sale_price,2) }}</td>
                      <td><button class="btn btn-danger btn-sm remove-btn" data-id="1"><span class="fa fa-trash"></span></button> </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <h2 class="float-left" > @lang("site.total")<span class="total-price">{{number_format($order->total_price,2)}}</span></h2>
          <button type="submit" class="btn btn-block btn-primary disabled submit-order ">@lang("site.editOrder")</button>
        </form>

        <!-- /.card -->

      </div>
      <!-- /.card -->

    </div>

  </div>
  <!-- right column -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
