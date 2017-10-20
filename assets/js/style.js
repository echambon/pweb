$(document).ready(function(){
	$('#header').data('size','big');
});

$(window).scroll(function(){
	if($(document).scrollTop() > 0)
	{
		if($('#header').data('size') == 'big')
		{
			$('#header').data('size','small');
			$('#header').stop().animate({
				height:'80px'
			},600);
			$('#id_picture').stop().animate({
				width:'80px',height:'80px'
			},600);
			$('section').stop().animate({
				'padding-top':'150px'
			},600);
		}
	}
	else
	{
		if($('#header').data('size') == 'small')
		{
			$('#header').data('size','big');
			$('#header').stop().animate({
				height:'250px'
			},600);
			$('#id_picture').stop().animate({
				width:'250px',height:'250px'
			},600);
			$('section').stop().animate({
				'padding-top':'300px'
			},600);
		}  
	}
});

$(document).ready(function(){
	$('#nav a').click(function(){  
	//Toggle Class
	$(".active").removeClass("active");      
	$(this).closest('li').addClass("active");
	var theClass = $(this).attr("class");
	$('.'+theClass).parent('li').addClass('active');
	//Animate
	$('html, body').stop().animate({
		scrollTop: $( $(this).attr('href') ).offset().top - 300
	}, 800);
	return false;
	});
});
