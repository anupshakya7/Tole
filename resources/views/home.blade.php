@extends('layouts.admin')
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
            <div class="card admin-card">
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
            <div class="card admin-card">
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
            <div class="card admin-card">
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
		@if($activity->count()>0)
		<div class="col-lg-12">
            <div class="card">
				<div class="card-header">
					{{ trans('Activity Log') }}
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class=" table table-listing table-striped table-hover datatable datatable-logactivity">
							<thead>
								<tr>
									<th width="10">#</th>
									<th>
										{{ trans('Name') }}
									</th>
									<th>
										{{ trans('Description') }}
									</th>
									<th>
										{{ trans('Properties') }}
									</th
								</tr>
							</thead>
							<tbody>
								@foreach($activity as $data)
									<tr data-entry-id="{{ $data->id }}">                            
										<td></td>
										<td>{{$data->log_name}}</td>
										<td>{{ $data->description }}</td>
										<td>{{ $data->properties }}</td>   
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
            </div>
        </div>
		@endif
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