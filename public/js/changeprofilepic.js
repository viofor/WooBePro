$(document).ready(function(){
	$.ajaxSetup({
 	 headers: {
 	   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});
	/*This function submits the profile photo form
	This form can be found in resources/views/layouts/modal.blade.php*/
	$("#upload").click(function(){
		$("#pictureupload").attr('method', 'POST');
		$("#pictureupload").attr('action', '/image');
		$("#pictureupload").submit();
	});
	/*This function retrieves the current profile photo url value and uses it to set the value
	of the <input type="hidden" name="currentpic"> field modal.blade.php
	This is useful for deleting the previous profile pic when submitting a new one, which avoids
	the hostings to end up filled by a ton of images if the user changes the profile pic too often*/
	$("#changepic").click(function(){
		var src = $("#profilepic").attr('src');
		var url = src.slice(9,src.length)
		$("#currentpic").attr('value', url);
	})
	/*This function sets the profile image and video (if advanced) to the current file*/
	function profilepic(){
		var ruta = "/image/create";
		$.ajax({
				url: ruta,
				type: 'GET',
				dataType: 'json',
				data: "requested data",
				success: function(data){
					$("#profilepic").attr('src', '/storage/' + data[1][0].picture);
					$("#profileaddress").attr('href', '/profile/userprofile/' + data[1][0].profile_address);
					var usertype = data[1][0].usertype;
					if (usertype == '1') {
						$("#profilevideos").html(" ");
						$("#dayoffsection").html(" ");
						$("#profilevideos").hide();
						$("#dayoffsection").hide();
					}else{
						$("#profilevideos").attr('src', 'storage/' + data[0][0].video);
						$("#currentvid").attr('value', data[0][0].video);
					}
				},
				error: function(xhr){
					console.log(xhr.responseText);
				}
			});
	}
	profilepic();
});