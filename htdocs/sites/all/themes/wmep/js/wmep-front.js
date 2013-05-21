// JavaScript Document

$(document).ready(function(){
	Cufon.replace('#splash-nav li');
	
	$("#splash .slide").hide();
	$("#splash #splash-main").fadeIn();
	
	$("#splash-nav a").hover(
		function() {
			$(this).parent().addClass("active");
			var idToShow = $(this).parent().attr("id");
			idToShow = idToShow + "-slide";
			$("#splash .slide:visible").stop(true,true).fadeOut();
			$("#"+idToShow).fadeIn();
		}, 
		function() {
			$(this).parent().removeClass("active");
		}
	);
	$("#splash").hover(
		function() {
		}, 
		function() {
			$("#splash .slide:visible").stop(true,true).fadeOut();
			$("#splash-main").fadeIn();
		}
	);
});

