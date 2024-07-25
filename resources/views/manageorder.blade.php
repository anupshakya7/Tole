@extends('layouts.ordermanage')
@section('title') {{ "Dashboard" }} @endsection
@section('styles')
<style>
	.dash-card .title{
	font-size: 14px;
	color: #3a3a3a;
	text-transform: uppercase;
}
.dash-card .data{
	padding-top: 13px;
	font-size: 32px;
	color: #0041ff;
}
.dash-card .data .progress {
	font-size: 14px;
	color: #8e8e8e;
	float: right;
	margin-top: -2px;
}
.dash-card .data .progress .icon{
		vertical-align: middle;
}
.graph-up-icon {
	background-image: url({{asset('img/Icon-Graph-Green.svg')}});
	width: 24px;
	height: 24px;
}
</style>
@endsection
@section('content')
<div class="content">
	<div class="row">		
		<div class="col-lg-4">
			<div class="card">
			  <div class="card-body dash-card">
				<div class="title">Total Customers</div>
				<div class="data">
					{{$customer}}
					<span class="progress">
						<span class="icon graph-up-icon"></span>
								0.0%
					</span>
				</div>
			  </div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card">
			  <div class="card-body dash-card">
				<div class="title">Total Orders</div>
				<div class="data">
					{{$order}}
					<span class="progress">
						<span class="icon graph-up-icon"></span>
								0.0%
					</span>
				</div>
			  </div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card">
			  <div class="card-body dash-card">
				<div class="title">Total Enquiry</div>
				<div class="data">
					NPR. {{number_format($sales,2)}}
					<span class="progress">
						<span class="icon graph-up-icon"></span>
								0.0%
					</span>
				</div>
			  </div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="card">
					  <div class="card-body">
						  <div class="table-responsive">
							  <table class=" table table-listing table-striped table-hover datatable datatable-attributes">
								  <thead>
									  <tr>
										  <th width="10">#</th>
										  <th>
											  {{ trans('Order ID') }}
										  </th>
										  <th>
											  {{ trans('Order Date') }}
										  </th>
										  <th>
											  {{ trans('Billed To') }}
										  </th>
										  <th>
											  {{ trans('Sub Total') }}
										  </th> 
										  {{--<th>
											  {{ trans('Tax') }}
										  </th>--}} 
										  <th>
											  {{ trans('Grand Total') }}
										  </th>                       
										  <th>
											  {{ trans('Intallation Status') }}
										  </th>
										  
										  <th>
											  Actions
										  </th>
									  </tr>
								  </thead>
								  <tbody>
									  @foreach($orders as $order)
										  <tr data-entry-id="{{ $order->id }}">                            
											  <td></td>
											  <td>#{{$order->id}}</td>
											  <td>{{ $order->created_at }}</td>
											  <td>{{$order->customers->first_name.' '.$order->customers->last_name}}</td>    
											  <td>{{ $order->sub_total }}</td>    
											  {{--<td>{{ $order->tax }}</td>--}} 
											  <td>{{ $order->total }}</td>    
											  <td>
												  @if($order->installation->status==0)
													  <span class="badge badge-warning">Pending</span>
												  @elseif($order->installation->status==1)
													  <span class="badge badge-success">Completed</span>
												  @else
													  <span class="badge badge-danger">Cancelled</span>
												  @endif                            
											  </td>
											  
											  <td>
												  <a href="{{ route('admin.orders.show', $order->id) }}">
													  <i class="fa fa-eye"></i>
												  </a>
											  </td>
										  </tr>
									  @endforeach
								  </tbody>
							  </table>
						  </div>
					  </div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@parent
<script>


	$(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
	order: [[ 1, 'desc' ]],
	pageLength: 100,
  });
  $('.datatable-logactivity:not(.ajaxTable)').DataTable({ buttons: dtButtons })
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
		$($.fn.dataTable.tables(false)).DataTable()
			.columns.adjust();
	});
})

</script>

@endsection