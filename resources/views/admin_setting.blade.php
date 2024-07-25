@extends('layouts.admin-web')
@section('title') {{ "Settings" }} @endsection
@section('content')
	
					@include('app_settings::_settings')
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
@parent

@endsection