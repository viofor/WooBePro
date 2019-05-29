@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-4">
			<img style="width: 80%; border-radius: 50%;" class="mx-auto d-block" src="/storage/{{ $userdetails->picture }}">
		</div>
		<div class="col-6">
			<strong><h3>{{ $userinfo->name }}{{ " " }}{{ $userinfo->lastname }}</h3>
				<?php 
					$advanced = $userinfo->advanced;
					if ($advanced == 1) {
						echo "Advanced user";
					}
				 ?>
			</strong>
			<p>{{ $userdetails->country }}{{ ", " }}{{ $userdetails->state }}{{ ", " }}{{ $userdetails->city }}</p>
			<p>Member since {{ $userdetails->created_at->format('m Y') }}</p>

		</div>
		<div class="col">
			<p>User reviews stars</p>
			{{ $reviews[0]->stars }}
		</div>
	</div>
	<?php 
		if ($userdetails->usertype == 2) {
			echo "<div class='row'>
		<div class='col'>
			<h4>Working schedule</h4>
		</div>
		<div class='col'>";
			echo $userdetails->schedule;
		echo "</div>
	</div>
	<div class='row'>
		<div class='col'>
			<h4>Skills</h4>
		</div>
		<div class='col'>";
			echo $userdetails->skill;
		echo "</div>
	</div>
	<div class='row'>
		<div class='col'>
			<h4>Resume</h4>
		</div>
		<div class='col'>";
			echo $userdetails->resume;
		echo "</div>
	</div>";
		}

	if (isset($userinfo)) {
		if ($userinfo->advanced == 1) {
			if (isset($advancedinfo)) {
				echo "<div class='text-center'>
		<h4>Profile video</h4>
		<div>
			<video controls>
				<source src='/storage/";
			echo $advancedinfo[0]->video;
			echo "'>
			</video>
		</div>
	</div>";
		}
	}
	}
	 ?>
</div>
@endsection