@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card-deck">
	<?php
		if ($matchs[0]=="") {
			echo "No match found";
		}
	    foreach ($matchusers as $key =>  $user){
	    	echo "<div class='card text-center' style='width:50%; height:50%;'><a href='/profile/userprofile/";
	    	echo $matchs[$key]->profile_address;
	    	echo "'>";
    		echo "<img style='width:50%; height:50%;' src='/storage/";
    		echo $matchs[$key]->picture;
    		echo "' class='card-img-top img-fluid rounded mx-auto d-block'></a>
    			<div class='card-body'><a href='/profile/userprofile/";
	    	echo $matchs[$key]->profile_address;
	    	echo "'>";
      			echo "<h5 class='card-title'>";
      				echo $user->name . " " . $user->lastname;
      				echo "</h5></a>
      				<p class='card-text'>This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
    			</div>
  			</div>";
	    	/*echo "<div class='card'>";
	    	echo "<a href='/profile/userprofile/"; echo $matchs[$key]->profile_address; echo "'><img style='height: 40px; width: 40px; background-color: grey;' src='/storage/"; echo $matchs[$key]->picture; echo "'>";
   			echo $user->name . " " . $user->lastname;
   			echo "</a>";*/

    	}
    	/*echo "<br>" . $matchs[0];*/
     ?>
    </div>
    <a href='/profile/userprofile/'></a>
</div>

{{ $matchs->links() }}
@endsection