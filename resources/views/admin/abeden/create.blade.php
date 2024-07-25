@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
.error{color:red;}
.hidden{display:none;}
.has-error .invalid-feedback{
  display:block;
  font-size:16px;
}
.has-error .form-control{
  border:1px solid red;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" rel="stylesheet">
<!-- Import table plugin specific stylesheet -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/plugins/table/ui/trumbowyg.table.min.css">
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">आवेदन ढाँचा</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ 'आवेदन ढाँचा थप्नुहोस्'}}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header border-bottom-dashed">
							<h5 class="card-title mb-0">{{ 'आवेदन ढाँचा थप्नुहोस्' }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.abeden.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-md-8">
										<div class="row">
											<div class="col-12">
												<div class="form-group">
													<label for="title" ><span class="fi fi-us fis"></span> {{ 'शीर्षक' }} <span style="color:red;">*</span></label>
													<input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
													@if($errors->has('title'))
														<em class="invalid-feedback">
															{{ $errors->first('title') }}
														</em>
													@endif
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="title" ><span class="fi fi-us fis"></span> {{ 'Title' }} <span style="color:red;">*</span></label>
													<input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" required>
													@if($errors->has('title_en'))
														<em class="invalid-feedback">
															{{ $errors->first('title_en') }}
														</em>
													@endif
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label class="control-label" for="abeden" style="margin-top:15px;">निबेदन (En)</label>
													<textarea name="abeden_en" id="abedenen" class="trumbowyg-textarea"></textarea>
												</div>
											</div>
											
											<div class="col-12">
												<div class="form-group">
													<label class="control-label" for="abeden" style="margin-top:15px;">निबेदन</label>
													<textarea name="abeden" id="abeden" class="trumbowyg-textarea"></textarea>
												</div>
											</div>
											
											<div class="col-12">
												<div class="form-group">
													<label class="control-label" for="sifaris" style="margin-top:15px;">सिफारिस(En)</label>
													<textarea name="sifaris_en" id="sifarisen" class="trumbowyg-textarea"></textarea>
												</div>
											</div>
											
											<div class="col-12">
												<div class="form-group">
													<label class="control-label" for="sifaris" style="margin-top:15px;">सिफारिस</label>
													<textarea name="sifaris" id="sifaris" class="trumbowyg-textarea"></textarea>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label class="control-label" for="required_docs" style="margin-top:15px;">आवश्यक कागजातहरू</label>
													<textarea name="required_docs" id="required_docs" class="trumbowyg-textarea"></textarea>
												</div>
											</div>
										</div>
										
									</div>

									<div class="col-4">
										<div class="row">
											<div class="col-12" style="margin-top:30px;">
												<div class="form-group">											
													<div class="form-check form-switch form-switch-md form-switch-success">
														<input class="form-check-input statuschng" name="status" type="checkbox">
														<label for="status">{{ 'Status' }}</label>																
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>					
		
								<div class="col-12 text-end" style="margin-top:15px;">
									<button class="btn btn-success" type="submit" id="uploadButton">
										<i class="ri-save-line"></i> Save
									</button>  
								</div>                        
						</form>
					</div>				
				</div>
			</div>
		</div>					
	</div>
 </div>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>
<!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/plugins/table/trumbowyg.table.min.js"></script>
<script>
	$( document ).ready(function() {
            $('#abeden,#sifaris,#abedenen,#sifarisen,#required_docs').trumbowyg({btns: [
			['viewHTML'],
			['formatting'],
			['strong', 'em', 'del'],
			['superscript', 'subscript'],
			['link'],
			['image'], // Our fresh created dropdown
			['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
			['unorderedList', 'orderedList'],
			['horizontalRule'],
			['removeformat'],
			['fullscreen'],
			['table'], 
			['tableCellBackgroundColor', 'tableBorderColor']
			]});
			//$('#sifaris').trumbowyg();
        });
	toastr.options = {
	  "closeButton": true,
	  "newestOnTop": true,
	  "positionClass": "toast-top-right"
	};

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif

</script>
@endsection