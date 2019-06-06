$(document).ready(function(){
	var day = $(".day");
	var month = $(".month");
	var monthinput = $(".monthinput");
	var dayoff = $(".dayoff");
	var monthoff = $(".monthoff");
	var n = 0;
	function calculateParameters(){
		dayoff[n].innerHTML = day.val();
		var monthIndex = month[n].value - 1;
		var monthValue = month[n][monthIndex].innerHTML;
		monthoff[n].innerHTML = monthValue + " ";
		monthinput[n].setAttribute('value', monthValue);	//input value
		monthinput[n].setAttribute('name', 'month'+n+'');
		day[n].setAttribute('name', 'day'+n+'');
	}
	day.change(function(){
		calculateParameters();
	});
	month.change(function(){
		calculateParameters();
	});
	calculateParameters();
	$("#setdayoff").click(function(){
		calculateParameters();
		$("#daysoffform").attr('method', 'GET');
		$("#daysoffform").attr('action', '/profile/dayoff');
		$("#daysoffform").submit();
	});
});