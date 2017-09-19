@extends('layouts.app')
@section('content')
	<div id="feed"></div>
<div class="container-fluid">
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

        <div id="feed"></div>


		@foreach($user_data as $user)
			@if(isset($user->Post))
				@foreach($user->Post as $eachPost)
				<div class="row">
					<div class="jumbotron">
						<a href="/profile/{{$user->url}}"><img class="profile-pic" width="27" height="27" src="{{$user->profile_img['avatar'][0]}}"> {{$user->name}} </a> <br>
						{{$eachPost['content']}} <br>
						{{$eachPost['time']}}
					</div>
				</div>
				@endforeach
			@endif
		@endforeach
	</div>
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	</div>

</div>
@endsection
