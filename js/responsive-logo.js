
$(document).ready(function(){
	function adjustLogo(){
		var width = $(window).width();
		if(width < 668){
			$('#id-img-logo').attr("src","img/cube2.png");
		}
		else{
			$('#id-img-logo').attr("src","img/cube.png");
		}
	}
	function adjustAlignment(){
		var logoDiv = document.getElementById('id-div-logo');
		var width = $(window).width();
		if(width > 374 && width < 452){
			logoDiv.className = "col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 text-center homepageleft";
		}
		else if(width > 452 && width < 768){
			logoDiv.className = "col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 text-center homepageleft";
		}
		else if(width <= 374){
			logoDiv.className = "col-md-6 col-md-offset-3 col-xs-12 col-sm-6 col-sm-offset-3 text-center homepageleft";

		}
		else{
			logoDiv.className = "col-md-6 col-md-offset-4 col-xs-12 col-sm-6 col-sm-offset-3 text-center homepageleft";
		}
	}
	adjustLogo();
	adjustAlignment();
	$(window).resize(function(){
		adjustLogo();
		adjustAlignment();
	});


});