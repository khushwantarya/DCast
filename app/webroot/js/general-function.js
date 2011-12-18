/**
 * Javascript for Default Theme
 */
$(document).ready(function(){
			
	if($(".idea_input").length > 0)
	{
		$(".idea_input").focus(function() {
			if($(this).val() == $("#" + $(this).attr("id") + "_default").val())
			{
				$(this).val("");
			}
		});
		$(".idea_input").blur(function() {
			if($(this).val() == "")
			{
				$(this).val($("#" + $(this).attr("id") + "_default").val());
			}
		});
	}


	/* this function is called to make favorite any idea by the logged in user */
  $("#wrapper").ajaxStart(function()
  {
    //alert(this.id)
    $(this).mask('Loading...');
    $('.loadmask-msg').center();
  }).ajaxComplete(function()
  {
    $(this).unmask();
    //tb_init('a.thickbox, area.thickbox, input.thickbox');
  });
	
	
});



function countChars(obj, maxchars)
{
	var char_span_id	=	(obj.id) + '_idea_chars_count';

	var char_entered	=	(obj.value).length;
	var char_left			=	(maxchars)-(char_entered);
	if((char_left==0) || (char_left<0))
	{
		//alert('you can enter only '+maxchars+' characters');
		obj.value	=	(obj.value).substring(0, maxchars);
		char_left=0;
	}
	$("#" + char_span_id).html(char_left);
}

function init_tabs(id)
{
	$("#" + id).tabs({ cookie: { expires: 30 } });
}

jQuery.fn.center = function () {
  this.css("position", "absolute");
  this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
  this.css("left", ( $("#wrapper").width() - this.width() ) / 2+$(window).scrollLeft() + "px");
  return this;
}
