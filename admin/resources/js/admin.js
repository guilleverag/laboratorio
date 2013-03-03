// JavaScript Document
$(function() {
	$('#menu > li').on({
		'mouseenter': function(){
			
			var li = $(this), a = li.children(), id = this.id;
			$('#menu > li > a').each(function(index, element) {
				$(element).removeClass().addClass('desactive');
            });
			a.removeClass().addClass('active');
			
			$('.images span').each(function(index, element) {
                $(element).hide();
            });
			$('span.'+id).show();
			
			$('.tittles div').each(function(index, element) {
                $(element).hide();
            });
			$('div.'+id).show();
		},
		'click': function(){
			console.log('click',this);
		}
	});
});