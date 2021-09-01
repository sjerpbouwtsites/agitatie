/* Do not modify this file directly. It is compiled from other files. */
/* jshint onevar: false, smarttabs: true */
/* global isRtl */
/* global widget_conditions_parent_pages */
/* global widget_conditions_data */
/* global jQuery */
jQuery(function(i){function t(t){var n,e;if(i("body").hasClass("wp-customizer"))return void t.find(".widget-inside").css("top",0);t.hasClass("expanded")?(t.attr("style")&&t.data("original-style",t.attr("style")),(n=t.width())<400&&(e=400-n,isRtl?t.css("position","relative").css("right","-"+e+"px").css("width","400px"):t.css("position","relative").css("left","-"+e+"px").css("width","400px"))):t.data("original-style")?t.attr("style",t.data("original-style")).data("original-style",null):t.removeAttr("style")}function n(i){var t=i.find("a.display-options").first();t.insertBefore(i.find("input.widget-control-save")),t.parent().removeClass("widget-control-noform").find(".spinner").remove().css("float","left").prependTo(t.parent())}function e(t){var n,e,o,d,a,c,l,r,h,p,u,g,f=t.find(".conditions-rule-minor").html(""),v=t.data("rule-major");if(!v||"post_type"===v)return void f.attr("disabled","disabled");for(n=t.data("rule-minor"),e=t.data("rule-has-children"),o=widget_conditions_data[v],d=0,r=o.length;d<r;d++)if(c=o[d][0],"object"==typeof(l=o[d][1])){for(g=i("<optgroup/>").attr("label",c),a=0,h=l.length;a<h;a++)p=o[d][1][a][0],u=o[d][1][a][1],g.append(i("<option/>").val(p).text(s(u.replace(/&nbsp;/g," "))));f.append(g)}else f.append(i("<option/>").val(c).text(s(l.replace(/&nbsp;/g," "))));f.removeAttr("disabled"),f.val(n),"page"===v&&n in widget_conditions_parent_pages?(f.siblings("span.conditions-rule-has-children").show(),e&&f.siblings("span.conditions-rule-has-children").find('input[type="checkbox"]').attr("checked","checked")):f.siblings("span.conditions-rule-has-children").hide().find('input[type="checkbox"]').removeAttr("checked")}function o(t){var n=0;t.find("span.conditions-rule-has-children").find('input[type="checkbox"]').each(function(){i(this).attr("name","conditions[page_children]["+n+"]"),n++})}function s(i){var t=document.createElement("textarea");return t.innerHTML=i,t.value}var d=i("div#widgets-right");d.length&&i(d).find(".widget-control-actions").length||(d=i("form#customize-controls")),i(".widget").each(function(){n(i(this))}),i(document).on("widget-added",function(i,t){0===t.find("div.widget-control-actions a.display-options").length&&n(t)}),d.on("click.widgetconditions","a.add-condition",function(t){var n=i(this).closest("div.condition"),e=n.clone().data("rule-major","").data("rule-minor","").data("has-children","").insertAfter(n);t.preventDefault(),e.find("select.conditions-rule-major").val(""),e.find("select.conditions-rule-minor").html("").attr("disabled"),e.find("span.conditions-rule-has-children").hide().find('input[type="checkbox"]').removeAttr("checked"),o(e.closest(".conditions"))}),d.on("click.widgetconditions","a.display-options",function(n){var o=i(this),s=o.closest("div.widget");n.preventDefault(),s.find("div.widget-conditional").toggleClass("widget-conditional-hide"),i(this).toggleClass("active"),s.toggleClass("expanded"),t(s),i(this).hasClass("active")?(s.find("input[name=widget-conditions-visible]").val("1"),s.find(".condition").each(function(){e(i(this))})):s.find("input[name=widget-conditions-visible]").val("0")}),d.on("click.widgetconditions","a.delete-condition",function(t){var n=i(this).closest("div.condition");t.preventDefault(),n.is(":first-child")&&n.is(":last-child")?(i(this).closest("div.widget").find("a.display-options").click(),n.find("select.conditions-rule-major").val("").change()):(n.find("select.conditions-rule-major").change(),n.detach()),o(n.closest(".conditions"))}),d.on("click.widgetconditions","div.widget-top",function(){var n=i(this).closest("div.widget"),e=n.find("a.display-options");e.hasClass("active")&&e.attr("opened","true"),e.attr("opened")&&(e.removeAttr("opened"),n.toggleClass("expanded"),t(n))}),d.on("change.widgetconditions","input.conditions-match-all",function(){i(this).parents(".widget-conditional").toggleClass("conjunction").toggleClass("intersection")}),i(document).on("change.widgetconditions","select.conditions-rule-major",function(){var t=i(this),n=t.siblings("select.conditions-rule-minor:first"),o=t.siblings("span.conditions-rule-has-children"),s=n.closest(".condition");s.data("rule-minor","").data("rule-major",t.val()),t.val()?e(s):(t.siblings("select.conditions-rule-minor").attr("disabled","disabled").html(""),o.hide().find('input[type="checkbox"]').removeAttr("checked"))}),i(document).on("change.widgetconditions","select.conditions-rule-minor",function(){var t=i(this),n=t.siblings("select.conditions-rule-major"),e=t.siblings("span.conditions-rule-has-children");t.closest(".condition").data("rule-minor",t.val()),"page"===n.val()&&t.val()in widget_conditions_parent_pages?e.show():e.hide().find('input[type="checkbox"]').removeAttr("checked")}),i(document).on("widget-updated widget-synced",function(t,n){n.find(".condition").each(function(){e(i(this))})})});


/* jshint onevar: false, smarttabs: true */
/* global isRtl */
/* global widget_conditions_parent_pages */
/* global widget_conditions_data */
/* global jQuery */
/*
jQuery( function( $ ) {
	var widgets_shell = $( 'div#widgets-right' );

	if ( ! widgets_shell.length || ! $( widgets_shell ).find( '.widget-control-actions' ).length ) {
		widgets_shell = $( 'form#customize-controls' );
	}

	function setWidgetMargin( $widget ) {
		var currentWidth,
			extra;

		if ( $( 'body' ).hasClass( 'wp-customizer' ) ) {
			// set the inside widget 2 top this way we can see the widget settings
			$widget.find( '.widget-inside' ).css( 'top', 0 );

			return;
		}

		if ( $widget.hasClass( 'expanded' ) ) {
			// The expanded widget must be at least 400px wide in order to
			// contain the visibility settings. IE wasn't handling the
			// margin-left value properly.

			if ( $widget.attr( 'style' ) ) {
				$widget.data( 'original-style', $widget.attr( 'style' ) );
			}

			currentWidth = $widget.width();

			if ( currentWidth < 400 ) {
				extra = 400 - currentWidth;
				if ( isRtl ) {
					$widget.css( 'position', 'relative' ).css( 'right', '-' + extra + 'px' ).css( 'width', '400px' );
				} else {
					$widget.css( 'position', 'relative' ).css( 'left', '-' + extra + 'px' ).css( 'width', '400px' );
				}
			}
		} else if ( $widget.data( 'original-style' ) ) {
			// Restore any original inline styles when visibility is toggled off.
			$widget.attr( 'style', $widget.data( 'original-style' ) ).data( 'original-style', null );
		} else {
			$widget.removeAttr( 'style' );
		}
	}

	function moveWidgetVisibilityButton( $widget ) {
		var $displayOptionsButton = $widget.find( 'a.display-options' ).first();
		$displayOptionsButton.insertBefore( $widget.find( 'input.widget-control-save' ) );

		// Widgets with no configurable options don't show the Save button's container.
		$displayOptionsButton
			.parent()
				.removeClass( 'widget-control-noform' )
				.find( '.spinner' )
					.remove()
					.css( 'float', 'left' )
					.prependTo( $displayOptionsButton.parent() );
	}

	$( '.widget' ).each( function() {
		moveWidgetVisibilityButton( $( this ) );
	} );

	$( document ).on( 'widget-added', function( e, $widget ) {
		if ( $widget.find( 'div.widget-control-actions a.display-options' ).length === 0 ) {
			moveWidgetVisibilityButton( $widget );
		}
	} );

	widgets_shell.on( 'click.widgetconditions', 'a.add-condition', function( e ) {
		var $condition = $( this ).closest( 'div.condition' ),
			$conditionClone = $condition.clone().data( 'rule-major', '' ).data( 'rule-minor', '' ).data( 'has-children','' ).insertAfter( $condition );

		e.preventDefault();

		$conditionClone.find( 'select.conditions-rule-major' ).val( '' );
		$conditionClone.find( 'select.conditions-rule-minor' ).html( '' ).attr( 'disabled' );
		$conditionClone.find( 'span.conditions-rule-has-children' ).hide().find( 'input[type="checkbox"]' ).removeAttr( 'checked' );

		resetRuleIndexes( $conditionClone.closest( '.conditions' ) );
	} );

	widgets_shell.on( 'click.widgetconditions', 'a.display-options', function( e ) {
		var $displayOptionsButton = $( this ),
			$widget = $displayOptionsButton.closest( 'div.widget' );

		e.preventDefault();

		$widget.find( 'div.widget-conditional' ).toggleClass( 'widget-conditional-hide' );
		$( this ).toggleClass( 'active' );
		$widget.toggleClass( 'expanded' );
		setWidgetMargin( $widget );

		if ( $( this ).hasClass( 'active' ) ) {
			$widget.find( 'input[name=widget-conditions-visible]' ).val( '1' );
			$widget.find( '.condition' ).each( function() {
				buildMinorConditions( $( this ) );
			} );
		} else {
			$widget.find( 'input[name=widget-conditions-visible]' ).val( '0' );
		}
	} );

	widgets_shell.on( 'click.widgetconditions', 'a.delete-condition', function( e ) {
		var $condition = $( this ).closest( 'div.condition' );

		e.preventDefault();

		if ( $condition.is( ':first-child' ) && $condition.is( ':last-child' ) ) {
			$( this ).closest( 'div.widget' ).find( 'a.display-options' ).click();
			$condition.find( 'select.conditions-rule-major' ).val( '' ).change();
		} else {
			$condition.find( 'select.conditions-rule-major' ).change();
			$condition.detach();
		}

		resetRuleIndexes( $condition.closest( '.conditions' ) );
	} );

	widgets_shell.on( 'click.widgetconditions', 'div.widget-top', function() {
		var $widget = $( this ).closest( 'div.widget' ),
			$displayOptionsButton = $widget.find( 'a.display-options' );

		if ( $displayOptionsButton.hasClass( 'active' ) ) {
			$displayOptionsButton.attr( 'opened', 'true' );
		}

		if ( $displayOptionsButton.attr( 'opened' ) ) {
			$displayOptionsButton.removeAttr( 'opened' );
			$widget.toggleClass( 'expanded' );
			setWidgetMargin( $widget );
		}
	} );

	widgets_shell.on( 'change.widgetconditions', 'input.conditions-match-all', function() {
		$( this ).parents( '.widget-conditional' )
			.toggleClass( 'conjunction' )
			.toggleClass( 'intersection' );
	} );

	$( document ).on( 'change.widgetconditions', 'select.conditions-rule-major', function() {
		var $conditionsRuleMajor = $( this ),
			$conditionsRuleMinor = $conditionsRuleMajor.siblings( 'select.conditions-rule-minor:first' ),
			$conditionsRuleHasChildren = $conditionsRuleMajor.siblings( 'span.conditions-rule-has-children' ),
			$condition = $conditionsRuleMinor.closest( '.condition' );

		$condition.data( 'rule-minor', '' ).data( 'rule-major', $conditionsRuleMajor.val() );

		if ( $conditionsRuleMajor.val() ) {
			buildMinorConditions( $condition );
		} else {
			$conditionsRuleMajor.siblings( 'select.conditions-rule-minor' ).attr( 'disabled', 'disabled' ).html( '' );
			$conditionsRuleHasChildren.hide().find( 'input[type="checkbox"]' ).removeAttr( 'checked' );
		}
	} );

	$( document ).on( 'change.widgetconditions', 'select.conditions-rule-minor', function() {
		var $conditionsRuleMinor = $( this ),
			$conditionsRuleMajor = $conditionsRuleMinor.siblings( 'select.conditions-rule-major' ),
			$conditionsRuleHasChildren = $conditionsRuleMinor.siblings( 'span.conditions-rule-has-children' ),
			$condition = $conditionsRuleMinor.closest( '.condition' );

		$condition.data( 'rule-minor', $conditionsRuleMinor.val() );

		if ( $conditionsRuleMajor.val() === 'page' ) {
			if ( $conditionsRuleMinor.val() in widget_conditions_parent_pages ) {
				$conditionsRuleHasChildren.show();
			} else {
				$conditionsRuleHasChildren.hide().find( 'input[type="checkbox"]' ).removeAttr( 'checked' );
			}
		} else {
			$conditionsRuleHasChildren.hide().find( 'input[type="checkbox"]' ).removeAttr( 'checked' );
		}
	} );

	$( document ).on( 'widget-updated widget-synced', function( e, widget ) {
		widget.find( '.condition' ).each( function() {
			buildMinorConditions( $( this ) );
		} );
	} );

	function buildMinorConditions( condition ) {
		var minor,
			hasChildren,
			majorData,
			i,
			j,
			key,
			val,
			_len,
			_jlen,
			subkey,
			subval,
			optgroup,
			select = condition.find( '.conditions-rule-minor' ).html( '' ),
			major = condition.data( 'rule-major' );

		// Disable the select, if major rule is empty or if it's a `post_type`.
		// "Post Type" rule has been removed in Jetpack 4.7, and
		// because it breaks all other rules we should `return`.
		if ( ! major || 'post_type' === major ) {
			select.attr( 'disabled', 'disabled' );
			return;
		}

		minor = condition.data( 'rule-minor' );
		hasChildren = condition.data( 'rule-has-children' );
		majorData = widget_conditions_data[ major ];

		for ( i = 0, _len = majorData.length; i < _len; i++ ) {
			key = majorData[i][0];
			val = majorData[i][1];

			if ( typeof val === 'object' ) {
				optgroup = $( '<optgroup/>' ).attr( 'label', key );

				for ( j = 0, _jlen = val.length; j < _jlen; j++ ) {
					subkey = majorData[i][1][j][0];
					subval = majorData[i][1][j][1];

					optgroup.append( $( '<option/>' ).val( subkey ).text( decodeEntities( subval.replace( /&nbsp;/g, '\xA0' ) ) ) );
				}

				select.append( optgroup );
			} else {
				select.append( $( '<option/>' ).val( key ).text( decodeEntities( val.replace( /&nbsp;/g, '\xA0' ) ) ) );
			}
		}

		select.removeAttr( 'disabled' );
		select.val( minor );

		if ( 'page' === major && minor in widget_conditions_parent_pages ) {
			select.siblings( 'span.conditions-rule-has-children' ).show();

			if ( hasChildren ) {
				select.siblings( 'span.conditions-rule-has-children' ).find( 'input[type="checkbox"]' ).attr( 'checked', 'checked' );
			}
		} else {
			select.siblings( 'span.conditions-rule-has-children' ).hide().find( 'input[type="checkbox"]' ).removeAttr( 'checked' );
		}
	}

	function resetRuleIndexes( widget ) {
		var index = 0;
		widget.find( 'span.conditions-rule-has-children' )
			.find( 'input[type="checkbox"]' )
			.each( function() {
				$( this ).attr( 'name', 'conditions[page_children][' + index + ']' );
				index++;
			} );
	}

	function decodeEntities( encodedString ) {
		var textarea = document.createElement( 'textarea' );
		textarea.innerHTML = encodedString;
		return textarea.value;
	}
} );
*/