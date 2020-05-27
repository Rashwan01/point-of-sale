           <div class="card">
           	<div class="card-header">
           		<h4>@lang("site.showProducts")</h4>
           	</div>

           	<div class="card-body table-responsive p-0">
           		<table class="table table-hover text-nowrap">
           			<thead>
           				<tr>
           					<th>@lang("site.name")</th>
           					<th>@lang("site.quantity")</th>
           					<th>@lang("site.price")</th>



           				</tr>
           			</thead>
           			<tbody>

           				@foreach ($products as $product )
           				<tr>
           					<td>{{ $product->title }}</td>
           					<td>{{ $product->pivot->quantity }}</td>
           					<td>{{number_format($product->pivot->quantity * $product->sale_price,2) }}</td>
           				</tr>
           				@endforeach
           			</tbody>
           		</table>
           		<h2 class="float-left"> الاجمالي:<span class="total-price">{{$order->total_price}}</span></h2>
           		<button class="btn btn-primary btn-block mt-5"><span class="fa fa-print"></span>@lang("site.print")</button>
           	</div>
           	<!-- /.card-body -->
           </div>
