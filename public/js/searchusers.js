$(document).ready(function(){
	$("#searchuser").click(function(){
		var searchfield = $(".form-control-plaintext").val();
		if (searchfield != "") {
			$(".form-inline").attr("action", "/searchresults"); //Setting the attribute "action" of form field (suggestion)
      		$(".form-inline").submit(); //Submits the form
		}
	});
});