@extends('layouts.admin-web')
@section('title') {{ "Permission" }} @endsection
@section('content')
<style>
button{border:none;background-color:transparent;}
</style>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{"Permission"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{"Permission"}}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header border-bottom-dashed">
							<div class="row g-4 align-items-center">
								<div class="col-sm">
									<div>
										<h5 class="card-title mb-0">Category List</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
											<a class="btn btn-soft-success" href="{{ route('admin.permissions.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ trans('global.add') }} {{ trans('cruds.permission.title_singular') }}
											</a>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped datatable-Permission" style="width:100%">
									<thead>
										<tr>
											<th width="10">

											</th>
											<th>
												{{ trans('cruds.permission.fields.id') }}
											</th>
											<th>
												{{ trans('cruds.permission.fields.title') }}
											</th>
											<th>
												Action
											</th>
										</tr>
									</thead>
									<tbody>
										@foreach($permissions as $key => $permission)
											<tr data-entry-id="{{ $permission->id }}">
												<td>

												</td>
												<td>
													{{ $permission->id ?? '' }}
												</td>
												<td>
													{{ $permission->name ?? '' }}
												</td>
												<td>
													<a class="link-success fs-15" href="{{ route('admin.permissions.show', $permission->id) }}">
														<i class="ri-eye-line"></i>
													</a>

													<a class="link-info fs-15" href="{{ route('admin.permissions.edit', $permission->id) }}">
														<i class="ri-edit-2-line"></i>
													</a>

													<form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
														<input type="hidden" name="_method" value="DELETE">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<button type="submit" class="link-danger fs-15" value="Submit"><i class="ri-delete-bin-5-line"></i></button>
													</form>
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
	</div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.permissions.mass_destroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Permission:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection