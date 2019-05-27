@extends('layouts.app')
    
@section('content')
<div class="container col-md-6">
	<form action="/profile/accstup" method="POST">
    		@csrf
			<input type="hidden" name="_method" value="put" />
		<div class="form-group row">
			<label for="currentpassword" class="col-form-label">Current password: </label>
			<div class="col-md-6">
    			<input id="currentpassword" type="password" name="currentpassword" class="form-control">
    		</div>
		</div>
    	<div class="form-group row">
    		<label for="newpassword" class="col-form-label">New password: </label>
    		<div class="col-md-6">
    			<input id="newpassword" type="password" name="newpassword" class="form-control">
    		</div>
    	</div>
    	<div class="form-group row">
    		<label for="confirmnewpass" class="col-form-label">Confirm new password: </label>
    		<div class="col-md-6">
    			<input id="confirmnewpass" type="password" name="confirmnewpass" class="form-control">
    		</div>
    	</div>
    		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>

<div class="container col-md-6 mt-2">
	<form id="daysoffform">
		<div class="dayoff-group">
			<div class="form-group row">
    	        <label class="col" for="day">Day: </label>
        		<select class="form-control col day">
        			@include('layouts.options.day')
	            </select>
    	    </div>
        	<div class="form-group row">
            	<label class="col" for="month">Month: </label>
            	<input type="text" class="monthinput" style="display: none;">
	        	<select class="form-control col month">
    	    		@include('layouts.options.month')
        	    </select>
	        </div>
    	    <p><span>Day off date: </span><span class="monthoff"></span><span class="dayoff"></span></p>
        </div>
        <button type="button" class="btn btn-primary" id="setdayoff">Submit</button>
	</form>
</div>

<div class="container col-md-6 mt-2">
	<?php
		usort($calendar, function($a, $b) {
    		return $a['day'] <=> $b['day'];
		});
		$January = array();
		$February = array();
		$March = array();
		$April = array();
		$May = array();
		$Juny = array();
		$July = array();
		$August = array();
		$September = array();
		$October = array();
		$November = array();
		$December = array();
		foreach($calendar as $value){
			$month = $value->month;
			$day = $value->day;
			switch ($month) {
    			case 'January':
        			array_push($January,$day);
        			break;
    			case 'February':
        			array_push($February,$day);
        			break;
    			case 'March':
        			array_push($March,$day);
        			break;
        		case 'April':
        			array_push($April,$day);
        			break;
        		case 'May':
        			array_push($May,$day);
        			break;
        		case 'Juny':
        			array_push($Juny,$day);
        			break;
        		case 'July':
        			array_push($July,$day);
        			break;
        		case 'August':
        			array_push($August,$day);
        			break;
        		case 'September':
        			array_push($September,$day);
        			break;
        		case 'October':
        			array_push($October,$day);
        			break;
        		case 'November':
        			array_push($November,$day);
        			break;
        		case 'December':
        			array_push($December,$day);
        			break;
    			default:
        			break;
			}//end switch

		}//end foreach
		if (!empty($January)) {
			echo "January: ";
			foreach ($January as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($February)) {
			echo "February: ";
			foreach ($February as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($March)) {
			echo "March: ";
			foreach ($March as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($April)) {
			echo "April: ";
			foreach ($April as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($May)) {
			echo "May: ";
			foreach ($May as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($Juny)) {
			echo "Juny: ";
			foreach ($Juny as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($July)) {
			echo "July: ";
			foreach ($July as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($August)) {
			echo "August: ";
			foreach ($August as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($September)) {
			echo "September: ";
			foreach ($September as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($October)) {
			echo "October: ";
			foreach ($October as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($November)) {
			echo "November: ";
			foreach ($November as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
		if (!empty($December)) {
			echo "December: ";
			foreach ($December as $key => $value) {
				echo $value . ", ";
			}
			echo "<br>";
		}
	?>
</div>
@endsection
