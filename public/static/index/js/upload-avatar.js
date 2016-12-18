

function cut_img(img){
	Alert("拖动选框修改头像", "iframe:/iframe/upload_cut_avatar.php?pid=" + img, "700", "500", "false", "", "true", "img");
}
function cut_img_complete(photo){
	$('#windown-close').click();
	document.getElementById('newsphoto_iframe').src = "/iframe/pic-avatar.php?avatar=" + photo;
	document.getElementById('avatar').value = photo;
}
function do_submit(type){
	$('#stype').val(type);
	$("#uploadform").submit();
}