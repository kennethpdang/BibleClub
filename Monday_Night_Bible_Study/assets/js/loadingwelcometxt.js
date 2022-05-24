function disableScroll() {
	// Get the current page scroll position
	scrollTop = window.pageYOffset || document.documentElement.scrollTop;
	scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,

	window.onscroll = function() {
		window.scrollTo(scrollLeft, scrollTop);
	};
}

function enableScroll() {
	window.onscroll = function() {};
}

// Hiding All Text On Loading - Welcome
$(document).ready(function(){
	width = window.innerWidth;
	if(width < 420) {
		enableScroll();
	}
	else {
		disableScroll();
		var totalscrolldown = 0;
		
		// Hiding All Text On Loading - Welcome
		$(".element1").hide();
		$(".element2").hide();
		$(".element3").hide();
		$(".element4").hide();
		$(".element5").hide();
		$(".element6").hide();
		$(".element7").hide();
		
		$(window).on('wheel', function(event){
			var wheelposition = parseInt(event.originalEvent.deltaY);
			// Note deltaY obviously records vertical scroll, however deltaX and deltaZ exist too.
			// This condition makes sure it's vertical scrolling that happened.
			
			if(wheelposition > 0) {
				totalscrolldown--;
			}
			
			if(wheelposition < 0) {
				totalscrolldown++;
			}
			
			// Squeezing Back In TEXT
			if(totalscrolldown == -1 && totalscrolldown < 0) {
				$(".element1").fadeIn("slow");
			}		
			else if(totalscrolldown == -2) {
				$(".element2").fadeIn("slow");
			}
			else if(totalscrolldown == -3) {
				$(".element3").fadeIn("slow");
			}
			else if(totalscrolldown == -4) {
				$(".element4").fadeIn("slow");
			}
			else if(totalscrolldown == -5) {
				$(".element5").fadeIn("slow");
			}
			else if(totalscrolldown == -6) {
				$(".element6").fadeIn("slow");
			}
			else {
				if(totalscrolldown < 0) {
					$(".element7").fadeIn("slow");
				}
			}
			
			if(totalscrolldown < -8) {
				document.getElementById("element1").style.textShadow = "0 0 10px #ffffff, 0 0 20px #ffffff, 0 0 40px #ffffff, 0 0 80px #ffffff, 0 0 120px #ffffff";
				document.getElementById("element2").style.textShadow = "0 0 10px #ffffff, 0 0 20px #ffffff, 0 0 40px #ffffff, 0 0 80px #ffffff, 0 0 120px #ffffff";
				document.getElementById("element3").style.textShadow = "0 0 10px #ffffff, 0 0 20px #ffffff, 0 0 40px #ffffff, 0 0 80px #ffffff, 0 0 120px #ffffff";
				document.getElementById("element4").style.textShadow = "0 0 10px #ffffff, 0 0 20px #ffffff, 0 0 40px #ffffff, 0 0 80px #ffffff, 0 0 120px #ffffff";
				document.getElementById("element5").style.textShadow = "0 0 10px #ffffff, 0 0 20px #ffffff, 0 0 40px #ffffff, 0 0 80px #ffffff, 0 0 120px #ffffff";
				document.getElementById("element6").style.textShadow = "0 0 10px #ffffff, 0 0 20px #ffffff, 0 0 40px #ffffff, 0 0 80px #ffffff, 0 0 120px #ffffff";
				document.getElementById("element7").style.textShadow = "0 0 10px #ffffff, 0 0 20px #ffffff, 0 0 40px #ffffff, 0 0 80px #ffffff, 0 0 120px #ffffff";
				document.getElementById("element1").style.color = "white";
				document.getElementById("element2").style.color = "white";
				document.getElementById("element3").style.color = "white";
				document.getElementById("element4").style.color = "white";
				document.getElementById("element5").style.color = "white";
				document.getElementById("element6").style.color = "white";
				document.getElementById("element7").style.color = "white";
			}
			
			if(totalscrolldown < -10) {
				enableScroll();
			}
		});
	}
});