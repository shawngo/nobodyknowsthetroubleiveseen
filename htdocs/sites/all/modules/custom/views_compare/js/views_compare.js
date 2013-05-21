/**
 *
 */
Drupal.behaviors.views_compareBehaviours = function (context) {


$('body').append($('<div id="bottomtip"><a id="clicktocompare">Click To View Compare Items</a><div id="bottomtip_close">X</div></div>'));
$('#bottomtip_close').click(function() {
  $('#bottomtip').show().animate({"height": "0px"}, "slow").addClass('unhideme');
});
$("#clicktocompare").livequery(function() {
  $(this).click(function() {
     var ids = '';
     $(".list-views-compare-checkbox:checked").each(function() {
       var id = this.id.replace(/compare-checkbox/g, '');
       ids += id + "+"
       $(this).parent().css('color', "#0f0");
       
     });
     if(ids == '') {
       alert('You must select at least 2 products to compare');
       return false;
     }
     ids = ids.substring(0, ids.length-1);
     window.location.href = '/compare/' + ids;
     return false;
  });
});
$('.unhideme')
  .livequery(function() {
    $(this)
      .hover(function() {
        $(this).stop();
        $(this).animate({"height": "50px"}, "slow")
      }, function() {
        $(this).stop();
        $(this).animate({"height": "0px"}, "slow")
      });
  }, function() {
    $(this)
      .unbind('mouseover')
      .unbind('mouseout');
  });

//$("label:parent").each(
//  function(i){
//    $(this).simpletip(
//      {content: '<h1>foo</h1><a href="#">view</a>',fixed: true, position: 'top', showEffect: 'slide', hideEffect: 'fade', persistent: true }
//    )
//  }
//);





   var views_checked_obj = {

     num_checked : 0,
     threshhold  : 4,
     active_element : '',

     increment   : function(el) {
       this.num_checked++;
       this.update(el);
       this.active_element = el;
     },
     decrement   : function(el) {
       this.num_checked--;
       this.update();
       this.active_element = el;
     },
     update      : function(el) {
       if(this.num_checked >= 2) {
         $('#bottomtip').show().animate({"height": "50px"}, "slow").removeClass('unhideme');
       }
       else {
         $('#bottomtip').slideUp('slow');;
       }
       if(this.num_checked >= this.threshhold) {
         this.disableize();
       }
       else {
         this.enableize();
       }
     },
     remove_link : function () {
       $('.compare_submit').slideUp('slow').remove();
       $('.compare_submit').remove();
     },
     append_link : function(el) {

 

       ///compare-checkbox
/*       var newid = el.id.replace(/compare-checkbox/, '');
       alert('#compare-checkbox'+newid+'-wrapper');
       //compare-checkbox1280-wrapper
       $('#compare-checkbox'+newid+'-wrapper').append($('<a class="compare_submit">Compare Items &raquo;</a>'));
*/
//       $(".list-views-compare-checkbox:checked").each(function() {
//         if ($(this).parent().siblings().size() <= 1) {
//           $(this).parent().parent().append($('<a class="compare_submit">Compare Items &raquo;</a>'));
//         }
//       });
     },
     disableize  : function() {
       $(".list-views-compare-checkbox:not(:checked)").each(function() {
         $(this).parent().css('color', "#f00");
         $(this).attr('disabled','disabled');
       });
     },
     enableize   : function() {
       $(".list-views-compare-checkbox:not(:checked)").each(function() {
         $(this).parent().css('color', "#000");
         $(this).attr('disabled','');
       });
     }

   }

   $(function(){

     // click the compare button
     $(".list-views-compare").click(function() {
       var ids = '';
       $(".list-views-compare-checkbox:checked").each(function() {
         var id = this.id.replace(/compare-checkbox/g, '');
         ids += id + "+"
         $(this).parent().css('color', "#0f0");
         
       });
       if(ids == '') {
         alert('You must select at least 2 products to compare');
         return false;
       }
       ids = ids.substring(0, ids.length-1);
       window.location.href = '/compare/' + ids;
       return false;
     });

     // click the checkbox
     $(".list-views-compare-checkbox").click(function() {
       var checked = $(this).attr('checked');
       if(checked === true) {
         views_checked_obj.increment(this);
       }
       else {
         views_checked_obj.decrement();
       }
     });
   });

};
