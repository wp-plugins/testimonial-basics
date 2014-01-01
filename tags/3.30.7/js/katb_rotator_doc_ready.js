jQuery(document).ready(function(){
	
	jQuery('.katb_rotate').each(function(i, obj) {
		
		jQuery(this).attr('id','katb_rotator_'+i );
		
	});	

	if( jQuery( '#katb_rotator_0' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_0');
		var speed = katb_rotate_options.dataset.katb_speed;
		var katb_rotate_interval_0 = setInterval( katb_rotate_testimonials_0, speed );
		jQuery('#katb_rotator_0' ).hover(function() {
	   		clearInterval(katb_rotate_interval_0);
		}, function() {
			katb_rotate_interval_0 = setInterval( katb_rotate_testimonials_0, speed );
		});
	}
	
	if( jQuery( '#katb_rotator_1' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_1');
		var speed = katb_rotate_options.dataset.katb_speed;
		var katb_rotate_interval_1 = setInterval( katb_rotate_testimonials_1, speed );
		jQuery('#katb_rotator_1' ).hover(function() {
	   		clearInterval(katb_rotate_interval_1);
		}, function() {
			katb_rotate_interval_1 = setInterval( katb_rotate_testimonials_1, speed );
		});
	}
	
	if( jQuery( '#katb_rotator_2' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_2');
		var speed = katb_rotate_options.dataset.katb_speed;
		var katb_rotate_interval_2 = setInterval( katb_rotate_testimonials_2, speed );
		jQuery('#katb_rotator_2' ).hover(function() {
	   		clearInterval(katb_rotate_interval_2);
		}, function() {
			katb_rotate_interval_2 = setInterval( katb_rotate_testimonials_2, speed );
		});
	}
	
	if( jQuery( '#katb_rotator_3' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_3');
		var speed = katb_rotate_options.dataset.katb_speed;
		var katb_rotate_interval_3 = setInterval( katb_rotate_testimonials_3, speed );
		jQuery('#katb_rotator_3' ).hover(function() {
	   		clearInterval(katb_rotate_interval_3);
		}, function() {
			katb_rotate_interval_3 = setInterval( katb_rotate_testimonials_3, speed );
		});
	}
	
	if( jQuery( '#katb_rotator_4' ).length > 0 ) {
		var katb_rotate_options = this.getElementById('katb_rotator_4');
		var speed = katb_rotate_options.dataset.katb_speed;
		var katb_rotate_interval_4 = setInterval( katb_rotate_testimonials_4, speed );
		jQuery('#katb_rotator_4' ).hover(function() {
	   		clearInterval(katb_rotate_interval_4);
		}, function() {
			katb_rotate_interval_4 = setInterval( katb_rotate_testimonials_4, speed );
		});
	}
    
    jQuery('.katb_widget_rotate').each(function(i, obj) {
		
		jQuery(this).attr('id','katb_widget_rotator_'+i );
		
	});
	
	if( jQuery( '#katb_widget_rotator_0').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_0');
		var speed = katb_widget_rotate_options.dataset.katb_speed;
		var katb_widget_rotate_interval_0 = setInterval( katb_widget_rotate_testimonials_0, speed );
		jQuery('#katb_widget_rotator_0' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_0);
		}, function() {
			katb_widget_rotate_interval_0 = setInterval( katb_widget_rotate_testimonials_0, speed );
		});
	}
	
	if( jQuery( '#katb_widget_rotator_1').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_1');
		var speed = katb_widget_rotate_options.dataset.katb_speed;
		var katb_widget_rotate_interval_1 = setInterval( katb_widget_rotate_testimonials_1, speed );
		jQuery('#katb_widget_rotator_1' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_1);
		}, function() {
			katb_widget_rotate_interval_1 = setInterval( katb_widget_rotate_testimonials_1, speed );
		});
	}
	
	if( jQuery( '#katb_widget_rotator_2').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_2');
		var speed = katb_widget_rotate_options.dataset.katb_speed;
		var katb_widget_rotate_interval_2 = setInterval( katb_widget_rotate_testimonials_2, speed );
		jQuery('#katb_widget_rotator_2' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_2);
		}, function() {
			katb_widget_rotate_interval_2 = setInterval( katb_widget_rotate_testimonials_2, speed );
		});
	}
	
	if( jQuery( '#katb_widget_rotator_3').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_3');
		var speed = katb_widget_rotate_options.dataset.katb_speed;
		var katb_widget_rotate_interval_3 = setInterval( katb_widget_rotate_testimonials_3, speed );
		jQuery('#katb_widget_rotator_3' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_3);
		}, function() {
			katb_widget_rotate_interval_3 = setInterval( katb_widget_rotate_testimonials_3, speed );
		});
	}
	
	if( jQuery( '#katb_widget_rotator_4').length > 0 ) {
		var katb_widget_rotate_options = this.getElementById('katb_widget_rotator_4');
		var speed = katb_widget_rotate_options.dataset.katb_speed;
		var katb_widget_rotate_interval_4 = setInterval( katb_widget_rotate_testimonials_4, speed );
		jQuery('#katb_widget_rotator_4' ).hover(function() {
	   		clearInterval(katb_widget_rotate_interval_4);
		}, function() {
			katb_widget_rotate_interval_4 = setInterval( katb_widget_rotate_testimonials_4, speed );
		});
	}
    
});

function katb_rotate_testimonials_0() {
	var katb_rotate_options = document.getElementById('katb_rotator_0');
	var transition = katb_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_rotator_0 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_0 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_0 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_rotate_testimonials_1() {
	var katb_rotate_options = document.getElementById('katb_rotator_1');
	var transition = katb_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_rotator_1 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_1 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_1 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_rotate_testimonials_2() {
	var katb_rotate_options = document.getElementById('katb_rotator_2');
	var transition = katb_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_rotator_2 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_2 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_2 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_rotate_testimonials_3() {
	var katb_rotate_options = document.getElementById('katb_rotator_3');
	var transition = katb_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_rotator_3 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_3 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_3 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_rotate_testimonials_4() {
	var katb_rotate_options = document.getElementById('katb_rotator_4');
	var transition = katb_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_rotator_4 .katb_rotate_show' );
	var next = current.nextAll( '#katb_rotator_4 .katb_rotate_noshow' ).first().length ? current.nextAll( '#katb_rotator_4 .katb_rotate_noshow' ).first() : current.parent().children( '.katb_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_rotate_show' ).addClass( 'katb_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_rotate_noshow' ).addClass( 'katb_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_0() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_0');
	var transition = katb_widget_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_widget_rotator_0 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_0 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_0 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_1() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_1');
	var transition = katb_widget_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_widget_rotator_1 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_1 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_1 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_2() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_2');
	var transition = katb_widget_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_widget_rotator_2 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_2 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_2 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_3() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_3');
	var transition = katb_widget_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_widget_rotator_3 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_3 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_3 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};

function katb_widget_rotate_testimonials_4() {
	var katb_widget_rotate_options = document.getElementById('katb_widget_rotator_4');
	var transition = katb_widget_rotate_options.dataset.katb_transition;
	var current = jQuery( '#katb_widget_rotator_4 .katb_widget_rotate_show' );
	var next = current.nextAll( '#katb_widget_rotator_4 .katb_widget_rotate_noshow' ).first().length ? current.nextAll( '#katb_widget_rotator_4 .katb_widget_rotate_noshow' ).first() : current.parent().children( '.katb_widget_rotate_noshow:first' );
	
	current.hide().removeClass( 'katb_widget_rotate_show' ).addClass( 'katb_widget_rotate_noshow' );
	if( transition == 'left to right' ) {
		next.show('slide', {direction: 'left'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else if(transition == 'right to left') {
		next.show('slide', {direction: 'right'}, 1000).removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' )
	} else {
		next.fadeIn('slow').removeClass( 'katb_widget_rotate_noshow' ).addClass( 'katb_widget_rotate_show' );
	}
};
