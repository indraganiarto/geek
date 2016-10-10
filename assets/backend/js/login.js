try{
	document.getElementById("uname").focus();
}catch(e){
}
function iFresponse(st, id){
	setTimeout("iFtimereload()", 1000);
}
function iFtimereload(){
	document.getElementById("timereload").value--;
	if(document.getElementById("timereload").value==0) window.location.reload(); else setTimeout("iFtimereload()", 1000);
}
function iForms_s(id){
	$("#iforms_r"+ id).html('<div style="padding:9px;color:#FFF">Please wait..</div>').fadeIn(function(){ $("#iforms_f"+ id).slideUp() });
	$("#iforms_f"+ id).ajaxSubmit({
		success:function(response){
			$("#iforms_r"+ id).html(response);
		}
	});
	return false;
}