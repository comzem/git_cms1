$(function(){
	$("#txt_video_path").live("focus",function(){
		$("#picture_space").css({
			left:$(this).offset().left+"px",
			top:$(this).offset().top+26+"px"
		});
		$("#picture_space").show();
		$("#load_img").load("videolist.php?tm="+(new Date()).getTime());
	});

	
	$("#closeimg").click(function(){
		$("#picture_space").hide();
	});
	
	$(".videoitem").live("click",function(){
		$("#txt_video_path").val($(this).attr("id"));
		$("#picture_space").hide();
	});
});