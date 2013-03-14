$(function(){
	$(":text,.w250").focus(function(){
		$(this).addClass("input_move");
		
	 });
	 
	 $(":text,.w250").blur(function(){
			$(this).removeClass("input_move");
	 });
});