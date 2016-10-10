$(document).ready(function(){


    
	$("a[rel*=if_close]").bind("click", function(){
		$("#if_popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
		$("#if_box").bPopup({loadUrl:$(this).attr("url"),contentContainer:"#if_popcontent"});
    });
	$("a[rel*=if_off]").bind("click", function(){
		$("#if_popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
		$("#if_box").bPopup({loadUrl:$(this).attr("url"),contentContainer:"#if_popcontent",follow:false});
    });
	$("a[rel*=if_url]").bind("click", function(){
		$("#if_popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
		$("#if_box").bPopup({loadUrl:$(this).attr("url"),contentContainer:"#if_popcontent",modalClose:false});
    });
	$("a[rel*=if_up]").bind("click", function(){
		$("#if_popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
		$("#if_box").bPopup({loadUrl:$(this).attr("url"),contentContainer:"#if_popcontent",follow:false,modalClose:false});
    });
	$("a[rel*=if-close]").bind("click", function(){
		$("#if-popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
		$("#if-box").bPopup({loadUrl:$(this).attr("url"),contentContainer:"#if-popcontent"});
	});
	$("a[rel*=if-off]").bind("click", function(){
		$("#if-popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
		$("#if-box").bPopup({loadUrl:$(this).attr("url"),contentContainer:"#if-popcontent",follow:false});
	});
	$("a[rel*=if-url]").bind("click", function(){
		$("#if-popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
		$("#if-box").bPopup({loadUrl:$(this).attr("url"),contentContainer:"#if-popcontent",modalClose:false});
	});
	$("a[rel*=if-up]").bind("click", function(){
		$("#if-popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
		$("#if-box").bPopup({loadUrl:$(this).attr("url"),contentContainer:"#if-popcontent",follow:false,modalClose:false});
	});
		
	$("#main-nav li ul").hide();
	$("#main-nav li a.current").parent().find("ul").slideToggle("slow");
	$("#main-nav li a.nav-top-item").click(
		function(){
			$(this).parent().siblings().find("ul").slideUp("normal");
			$(this).next().slideToggle("normal");
			return false;
		}
	);
	$("#main-nav li a.no-submenu").click(
		function(){
			window.location.href=(this.href);
			return false;
		}
	);
	$("#main-nav li .nav-top-item").hover(
		function(){
			$(this).stop().animate({ paddingRight: "25px" }, 200);
		}, 
		function(){
			$(this).stop().animate({ paddingRight: "15px" });
		}
	);
	
});
function iFpopUp(url){
	$("#if_popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
	$("#if_box").bPopup({loadUrl:url,contentContainer:"#if_popcontent",follow:false,modalClose:false});
}
function iFpopUpurl(url){
	$("#if_popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
	$("#if_box").bPopup({loadUrl:url,contentContainer:"#if_popcontent",modalClose:false});
}
function iFpopUp_url(url){
	$("#if-popcontent").html('<center><img src="'+ HOST +'static/i/loading.gif" alt="Loading.."></center>');
	$("#if-box").bPopup({loadUrl:url,contentContainer:"#if-popcontent",modalClose:false});
}
function iFresponse(st, id){
	if(st==1) setTimeout("iFtimeout()", 1000); else if(st==2) setTimeout("iFtimereload()", 1000); else if(st==3) setTimeout("iFreferrer()", 1000); else if(st==4) $("#"+ id).get(0).reset();
	if(st < 3) $("#"+ id).fadeOut();
}
function iFtimeout(){
	document.getElementById("timeout").value--;
	if(document.getElementById("timeout").value==0) $(".ifclose").click(); else setTimeout("iFtimeout()", 1000);
}
function iFtimereload(){
	document.getElementById("timereload").value--;
	if(document.getElementById("timereload").value==0) window.location.reload(); else setTimeout("iFtimereload()", 1000);
}
function iFtoggle(id){
	if(document.getElementById(id).style.display=="block") $("#"+ id).fadeOut().css({"display":"none"}); else $("#"+ id).fadeIn().css({"display":"block"});
}
function iFshowhide(show, hide){
	$("."+ hide).css({"display":"none"});
	$("#"+ show).css({"display":"block"});
}
function iFshowhiding(show, hide){
	$("."+ hide).css({"display":"none"});
	$("."+ show).css({"display":"block"});
}
function Inint_AJAX(){
	try{ return new ActiveXObject("Msxml2.XMLHTTP"); }catch(e){}
	try{ return new ActiveXObject("Microsoft.XMLHTTP"); }catch(e){}
	try{ return new XMLHttpRequest(); }catch(e){}
	alert("XMLHttpRequest not supported");
	return null;
};
function dochange(src, val, sel){
	var req = Inint_AJAX();
	req.onreadystatechange = function(){
		if(req.readyState==4){
			if(req.status==200) document.getElementById(src).innerHTML=req.responseText;
		}
	};
	req.open("GET", HOST +"index.php/process/autocomplete/"+ src +"/"+ val +"/"+ sel);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=iso-8859-1");
	req.send(null);
}
function poi_filter(){
	if(document.form.main_menu.value=="0"){
		alert("Please select Main Menu.");
		document.form.main_menu.focus();
		return false;
	}
}
function searchbox(){
	if(document.search_box.q.value==""){
		alert("Please insert keyword..");
		document.search_box.q.focus();
	}else{
		$("#search-box").ajaxSubmit({
			success:function(response){
				$("#search-box").html(response);
			}
		});
	}
	return false;
}
function iForms_s(id){
	$("#iforms_r"+ id).html('<div style="padding:9px"><img src="static/i/loading_s.gif" style="vertical-align:top"><span style="color:#9E461A;font-size:12px">Please wait..</span></div>').fadeIn(function(){ $("#iforms_f"+ id).slideUp() });
	$("#iforms_f"+ id).ajaxSubmit({
		success:function(response){
			if(id==10) $(window).unbind("beforeunload");
			$("#iforms_r"+ id).html(response);
		}
	});
	return false;
}
function ifclose(){
	$(".ifclose").click();
}
$(".close").on("click",function(){
	$(this).parent().fadeTo(400, 0, function(){
		$(this).slideUp(400);
	});
});
$(".reload").on("click",function(){
	window.location.reload();
});
$(document).on("click", ".remove", function(){
var id=$(this).attr("id");
	var c=$(this).attr("c");
	var t=$(this).attr("t");
	var dataString='idx='+ id +'&c='+ c;
	if(confirm("Are you sure you want to remove this "+ t +"?")){
		$("#attr_"+ c +"_"+ id).css({"background":"#459300","color":"#FFF","font-size":"10px"}).html('Removing<img src="'+ HOST +'static/i/loading_dot.gif" alt="..." style="vertical-align:bottom;width:13px;padding:0 0 3px 0">').fadeIn();
		$.ajax({
			type:"POST",
			url:HOST +"index.php/process/remove",
			data:dataString,
			cache:false,
			success:function(response){
				//$("#list_"+ c +"_"+ id).css({"background":"#459300","color":"#FFF"}).fadeOut();
				 $('#dataitem').dataTable()._fnAjaxUpdate();
			}
		})
	}
	return false
	
});
 
