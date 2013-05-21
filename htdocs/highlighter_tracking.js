/*
	
*/
window.onload=function(){var e=null;var g=60;var h=3;var c=document.getElementsByTagName("body")[0];if(c){c.onmouseup=function(j){e=b();f=e.length;d=i(e);if(e!=null&&d<g&&f>h){_gaq.push(["_trackEvent","CopyText","Highlighted",e])}function i(k){var l=k;var m=0;a=l.replace(/\s/g," ");a=a.split(" ");for(z=0;z<a.length;z++){if(a[z].length>0){m++}}return m}function b(){if(window.getSelection){d=window.getSelection()}else{if(document.getSelection){d=document.getSelection()}else{if(document.selection){d=document.selection.createRange().text}else{return""}}}return d.toString()}}}};