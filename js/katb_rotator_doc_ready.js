jQuery(document).ready(function(){

	var katb_rotate_interval = setInterval( katb_rotate_testimonials, 7000 );
	jQuery('.katb_rotate').hover(function() {
       clearInterval(katb_rotate_interval);
    }, function() {
    	katb_rotate_interval = setInterval( katb_rotate_testimonials, 7000 );
    });
    
    var katb_widget_rotate_interval = setInterval( katb_widget_rotate_testimonials, 7000 );
	jQuery('.katb_widget_rotate').hover(function() {
       clearInterval(katb_widget_rotate_interval);
    }, function() {
    	katb_widget_rotate_interval = setInterval( katb_widget_rotate_testimonials, 7000 );
    });
    
});

function katb_rotate_testimonials() {
	
	var current = jQuery( '.katb_rotate_show' );
	var next = current.nextAll('.katb_rotate_noshow').first().length ? current.nextAll('.katb_rotate_noshow').first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	next.fadeIn('slow').removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	
};

function katb_widget_rotate_testimonials() {
	
	var current = jQuery( '.katb_widget_rotate_show' );
	var next = current.nextAll('.katb_widget_rotate_noshow').first().length ? current.nextAll('.katb_widget_rotate_noshow').first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	next.fadeIn('slow').removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	
};