(function ($)
{
	$(document).ready(function()
	{
		$('.kirki-group-outer.spacing').each(function(e){
			var container = $(this),
				value = JSON.parse ( container.attr( 'value' ) ),
				input = $( 'input.kirki-spacing-value', container ),
				margin_units = $( '.margin-outer input[name="margin_type"][type="radio"]', container ),
				padding_units = $( '.padding-outer input[name="padding_type"][type="radio"]', container ),
				save_tid = 0;
				
				init ( container, 'margin', value );
				init ( container, 'padding', value );
				
				function init( container, type, value )
				{
					var top_offset = 0,
						right_offset = 1,
						bottom_offset = 2,
						left_offset = 3;
					var rep = /(px|%|em)/g;
					
					var outer = $( '.' + type + '-outer', container ),
						link_dims = $( '.kirki-link-dimensions', outer ),
						inputs = $( 'input[type="number"]', outer ),
						units = $( 'input[name="' + type + '_type"][type="radio"]' ),
						top = $( 'input[' + type + '-type="top"]', outer ),
						bottom = $( 'input[' + type + '-type="bottom"]', outer ),
						left = $( 'input[' + type + '-type="left"]', outer ),
						right = $( 'input[' + type + '-type="right"]', outer ),
						devices_outer = $( '.kirki-device-select-options', outer ),
						desktop_btn = $( 'li.desktop', devices_outer ),
						tablet_btn = $( 'li.tablet', devices_outer ),
						mobile_btn = $( 'li.mobile', devices_outer ),
						multiple = value[type] && value[type]['tablet'] && value[type] && value[type]['mobile'],
						active_device = 'desktop';
					console.log(devices_outer);
					var raw_desktop_val = value[type]['desktop'];
					var desktop_val = value[type]['desktop'].replace( rep, '' ).split ( ' ' );
					var tablet_val = value[type]['tablet'].replace( rep, '' ).split ( ' ' );
					if ( !tablet_val || tablet_val.length == 0)
						tablet_val = ['','','',''];
					var mobile_val = value[type]['mobile'].replace( rep, '' ).split ( ' ' );
					if ( !mobile_val || mobile_val.length == 0)
						mobile_val = ['','','',''];
					var unit_match = raw_desktop_val.match( rep );
					var current_unit = 'px';
					
					if ( unit_match && unit_match.length > 0 )
					{
						current_unit = unit_match[0];
					}
					
					top.val ( desktop_val[top_offset] );
					top.attr ( 'desktop-value', desktop_val[top_offset] );
					top.attr ( 'tablet-value', tablet_val[top_offset] );
					top.attr ( 'mobile-value', mobile_val[top_offset] );
					
					right.val ( desktop_val[right_offset] );
					right.attr ( 'desktop-value', desktop_val[right_offset] );
					right.attr ( 'tablet-value', tablet_val[right_offset] );
					right.attr ( 'mobile-value', mobile_val[right_offset] );
					
					bottom.val ( desktop_val[bottom_offset] );
					bottom.attr ( 'desktop-value', desktop_val[bottom_offset] );
					bottom.attr ( 'tablet-value', tablet_val[bottom_offset] );
					bottom.attr ( 'mobile-value', mobile_val[bottom_offset] );
					
					left.val ( desktop_val[left_offset] );
					left.attr ( 'desktop-value', desktop_val[left_offset] );
					left.attr ( 'tablet-value', tablet_val[left_offset] );
					left.attr ( 'mobile-value', mobile_val[left_offset] );
					
					units.filter( 'input[value="' + current_unit + '"]' ).prop( 'checked', true );
					
					if ( multiple )
					{
						tablet_btn.removeClass( 'hidden-device' );
						mobile_btn.removeClass( 'hidden-device' );
					}
					
					margin_units.change(function()
					{
						save ( container, multiple );
					});
					
					padding_units.change(function()
					{
						save( container, multiple );
					});
					
					inputs.on( 'keyup change click', function ( e ){
						clearTimeout (save_tid );
						var input = $(this);
						var cur_val = input.val();
						//var last_val = input.attr( 'last-' + active_device + '-val' );
						input.attr ( active_device + '-value', cur_val );
						// if ( cur_val != last_val )
						// {
							//input.attr( 'last-' + active_device + '-val', cur_val );
							if ( link_dims.hasClass( 'linked' ) )
							{
								inputs.val( cur_val );
								inputs.attr(  active_device + '-value', cur_val );
								//inputs.attr( 'last-' + active_device + '-val', cur_val );
							}
							save( container, multiple );
							//save_border();
						//}
					});
					
					link_dims.click(function(e){
						e.preventDefault();
						e.stopImmediatePropagation();
						link_dims.toggleClass( 'unlinked' );
						link_dims.toggleClass( 'linked' );
					});
					
					desktop_btn.click ( function(e)
					{
						e.preventDefault();
						e.stopImmediatePropagation();
						if ( !tablet_btn.hasClass( 'active' ) && !mobile_btn.hasClass( 'active' ) )
						{
							desktop_btn.toggleClass( 'multiple' );
							if ( desktop_btn.hasClass( 'multiple' ) )
							{
								multiple = true;
								tablet_btn.removeClass( 'hidden-device' );
								mobile_btn.removeClass( 'hidden-device' );
							}
							else
							{
								multiple = false;
								tablet_btn.addClass( 'hidden-device' );
								mobile_btn.addClass( 'hidden-device' );
								
								loadValues( 'desktop' );
							}
						}
						else
						{
							active_device = 'desktop';
							tablet_btn.removeClass( 'active' );
							mobile_btn.removeClass( 'active' );
							loadValues( );
						}
						
					});
					tablet_btn.click ( function(e)
					{
						e.preventDefault();
						e.stopImmediatePropagation();
						active_device = 'tablet';
						mobile_btn.removeClass( 'active' );
						tablet_btn.addClass( 'active' );
						loadValues();
					});
					mobile_btn.click ( function(e)
					{
						e.preventDefault();
						e.stopImmediatePropagation();
						active_device = 'mobile';
						tablet_btn.removeClass( 'active' );
						mobile_btn.addClass( 'active' );
						loadValues();
					});
					
					function loadValues()
					{
						top.val( top.attr ( active_device + '-value' ) );
						left.val( left.attr ( active_device + '-value' ) );
						bottom.val( bottom.attr ( active_device + '-value' ) );
						right.val( right.attr ( active_device + '-value' ) );
						
						//top.attr( 'last-' + active_device + '-val', top.val() );
						//left.attr( 'last-' + active_device + '-val', left.val() );
						//bottom.attr( 'last-' + active_device + '-val', bottom.val() );
						//right.attr( 'last-' + active_device + '-val', right.val() );
					}
				}
				
				function save( container, multiple ){
					clearTimeout (save_tid );
					save_tid = setTimeout( function ()
						{
							var margin_top = $( 'input[margin-type="top"]', container ),
								margin_bottom = $( 'input[margin-type="bottom"]', container ),
								margin_left = $( 'input[margin-type="left"]', container ),
								margin_right = $( 'input[margin-type="right"]', container ),
								
								padding_top= $( 'input[padding-type="top"]', container ),
								padding_left = $( 'input[padding-type="left"]', container ),
								padding_bottom = $( 'input[padding-type="bottom"]', container ),
								padding_right = $( 'input[padding-type="right"]', container );
								
							var margin_unit = container.find( 'input[name="margin_type"]:checked' ).val();
							var margin = {
								'desktop': [
									( margin_top.attr( 'desktop-value' ) || 0 ) + margin_unit,
									( margin_right.attr( 'desktop-value' ) || 0 ) + margin_unit,
									( margin_bottom.attr( 'desktop-value' ) || 0 ) + margin_unit,
									( margin_left.attr( 'desktop-value' ) || 0 ) + margin_unit
								].join( ' ' ),
								'tablet': [
									( margin_top.attr( 'tablet-value' ) || 0 ) + margin_unit,
									( margin_right.attr( 'tablet-value' ) || 0 ) + margin_unit,
									( margin_bottom.attr( 'tablet-value' ) || 0 ) + margin_unit,
									( margin_left.attr( 'tablet-value' ) || 0 ) + margin_unit
								].join( ' ' ),
								'mobile': [
									( margin_top.attr( 'mobile-value' ) || 0 ) + margin_unit,
									( margin_right.attr( 'mobile-value' ) || 0 ) + margin_unit,
									( margin_bottom.attr( 'mobile-value' ) || 0 ) + margin_unit,
									( margin_left.attr( 'mobile-value' ) || 0 ) + margin_unit
								].join( ' ' )
							};
							var padding_unit = container.find( 'input[name="padding_type"]:checked' ).val();
							var padding = {
								'desktop': [
									( padding_top.attr( 'desktop-value' ) || 0 ) + padding_unit,
									( padding_right.attr( 'desktop-value' ) || 0 ) + padding_unit,
									( padding_bottom.attr( 'desktop-value' ) || 0 ) + padding_unit,
									( padding_left.attr( 'desktop-value' ) || 0 ) + padding_unit
								].join( ' ' ),
								'tablet': [
									( padding_top.attr( 'tablet-value' ) || 0 ) + padding_unit,
									( padding_right.attr( 'tablet-value' ) || 0 ) + padding_unit,
									( padding_bottom.attr( 'tablet-value' ) || 0 ) + padding_unit,
									( padding_left.attr( 'tablet-value' ) || 0 ) + padding_unit
								].join( ' ' ),
								'mobile': [
									( padding_top.attr( 'mobile-value' ) || 0 ) + padding_unit,
									( padding_right.attr( 'mobile-value' ) || 0 ) + padding_unit,
									( padding_bottom.attr( 'mobile-value' ) || 0 ) + padding_unit,
									( padding_left.attr( 'mobile-value' ) || 0 ) + padding_unit
								].join( ' ' )
							};
							if ( !multiple )
							{
								delete margin.tablet;
								delete margin.mobile;
								delete padding.tablet;
								delete padding.mobile;
							}
							var data = {
								'margin': margin,
								'padding': padding
							};
							data = JSON.stringify( data );
							input.val( data ).trigger( 'change' );
							save_tid = 0;
					}, 1000 );
				}
		});
	});
})(jQuery);