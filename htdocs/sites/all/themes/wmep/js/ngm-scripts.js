// JavaScript Document

$(document).ready(function() {
	// Set up page for display
	$(".ngm-slide").hide();
	$("#ngm-cfi-splash").show();
	$("#ngm").addClass("js-enabled");
	$("#ngm-cfi").addClass("active");
	
	// Hover over side links
	$("#ngm-links li").hover(function() {
		// mouse over
		var tempID = $(this).attr("id");
		$("#ngm-links li").removeClass("active");
		$(this).addClass("active");
		$(".ngm-slide:visible").stop(true,true).fadeOut().parent().find("#"+tempID+"-splash").fadeIn();
	}, function() {
		// mouse out
		
	});
});
