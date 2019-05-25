$(document).ready(function(){
	$("#upload").click(function(){
		$("#pictureupload").attr('method', 'POST');
		$("#pictureupload").attr('action', '/image');
		$("#pictureupload").submit();
	});
});