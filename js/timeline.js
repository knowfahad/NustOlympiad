
$(document).ready(function(){
	function addMarginToEventsTimeline(){
		var width = $(window).width();
		var marginLeft, marginRight, minWidth;
		if(width >= 1500){
			minWidth = 1500;
			marginLeft = Math.floor((width-minWidth)/4);
			marginRight = Math.floor((width-minWidth)/4);
			/*$('.class-desktop').css({"margin-left":marginLeft+"px"});*/
		}
		else if(width >= 1002){
			minWidth = 1002;
			marginLeft = Math.floor((width-minWidth)/2);
			marginRight = Math.floor((width-minWidth)/2);
			/*$('.class-desktop').css({"margin-left":marginLeft+"px"});*/
		}
		else if(width >= 900){
			minWidth = 900;
			marginLeft = Math.floor((width+60-minWidth)/4);
			marginRight = Math.floor((width+60-minWidth)/4);
			/*$('.class-desktop').css({"margin-left":marginLeft+"px"});*/
		}
		
	}


	//on load add margin
	addMarginToEventsTimeline();

	$(window).resize(function(){
		addMarginToEventsTimeline();
	});
});