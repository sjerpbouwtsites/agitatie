
//doet varia checks bij opslaan.


var gaDoor = false;
var bev = "\nOK = negeren.";
var loc = location.href;
var i;

jQuery(function($) {
	$("#publish").on('click', function(e){

    //EDIT EDIT EDIT
    //EDIT EDIT EDIT
    //EDIT EDIT EDIT
    //EDIT EDIT EDIT
    //EDIT EDIT EDIT
    //EDIT EDIT EDIT
    gaDoor = true;

		if (!gaDoor) {

        var
        isOpOpts = loc.indexOf("admin.php?page=acf-options") !== -1,
        isOpACF = jQuery('#toplevel_page_edit-post_type-acf-field-group.wp-has-current-submenu').length ;
        isOpVacature = jQuery('#menu-posts-vacature.wp-has-current-submenu').length;
        isOpAgenda = jQuery('#menu-posts-agenda.wp-has-current-submenu').length;
        isOpMenu = jQuery('#menu-posts-menu.wp-has-current-submenu').length;
        isOpGerecht = jQuery('#menu-posts-gerecht.wp-has-current-submenu').length;
        isOpRecensie = jQuery('#menu-posts-grfwp-review.wp-has-current-submenu').length;

		  	if ( isOpOpts || isOpACF || isOpVacature || isOpAg_agenda || isOpMenu || isOpGerecht || isOpRecensie) {
		  		//
		  	} else {
		  		var r = check();

		  		if (!r) {
		  			e.preventDefault();
		  			return false;
		  		} else {
		  			gaDoor = true;
		  		}
		  	}
		}

	});
});


function check() {

  	var waarden = {
  		slechteScore: {
  			verg: 'max',
  			val: jQuery(".wpseo-score-icon.bad:visible").length,
  			drempel: 1,
  			tekst: "Er zijn %VERV% slechte SEO kenmerken."
  		},
  		goedeScore: {
  			verg: 'min',
  			val: jQuery(".wpseo-score-icon.good:visible").length,
  			drempel: 1,
  			tekst: "Er zijn slechts %VERV% goede SEO kenmerken."
  		},
  		uitgelichteAfb: {
  			verg: 'min',
  			val: jQuery("#set-post-thumbnail img").length,
  			drempel: 1,
  			tekst: "Je bent de uitgelichte afbeelding vergeten."
  		},
  	};

  	//post
  	var $tcl = jQuery("#post_tag .tagchecklist");

  	if ($tcl.length) {

  		var aantalTags = $tcl.find('.remove-tag-icon').length;

  		waarden['weinigTags'] = {
  			verg: 'min',
  			val: aantalTags,
  			drempel: 2,
  			tekst: "Je hebt maar %VERV% tags gebruikt. Meer is beter."
  		};
  		waarden['veelTags'] = {
  			verg: 'max',
  			val: aantalTags,
  			drempel: 7,
  			tekst: "Je hebt wel %VERV% tags gebruikt. Dat is wel erg veel."
  		};
  	}

  	//agenda
  	if (jQuery("#tagsdiv-momentsoort").length) {

  		var aantalMS = jQuery('#tagsdiv-momentsoort .tagchecklist .remove-tag-icon').length;

  		waarden['weinigMS'] = {
  			verg: 'min',
  			val: aantalMS,
  			drempel: 1,
  			tekst: "Vul een momentsoort in."
  		};
  		waarden['veelMS'] = {
  			verg: 'max',
  			val: aantalMS,
  			drempel: 2,
  			tekst: "Je hebt wel %VERV% momentsoorten gebruikt. Zeker weten?"
  		};
  	}

  	//agenda
  	if (jQuery("#tagsdiv-onderwerp").length) {

  		var aantalOnderwerp = jQuery('#tagsdiv-onderwerp .tagchecklist .remove-tag-icon').length;

  		waarden['weinigOnderwerp'] = {
  			verg: 'min',
  			val: aantalOnderwerp,
  			drempel: 1,
  			tekst: "Vul een onderwerp in."
  		};
  		waarden['veelOnderwerp'] = {
  			verg: 'max',
  			val: aantalOnderwerp,
  			drempel: 4,
  			tekst: "Je hebt wel %VERV% onderwerpen gebruikt. Zeker weten?"
  		};
  	}

 	//agenda
  	if (jQuery("#tagsdiv-plek").length) {

  		var aantalPlekken = jQuery('#tagsdiv-plek .tagchecklist .remove-tag-icon').length;

  		waarden['weinigPlekken'] = {
  			verg: 'min',
  			val: aantalPlekken,
  			drempel: 1,
  			tekst: "Vul een plek in."
  		};
  		waarden['veelPlekken'] = {
  			verg: 'max',
  			val: aantalPlekken,
  			drempel: 2,
  			tekst: "Je hebt wel %VERV% plekken gebruikt. Zeker weten?"
  		};
  	}

  	//agenda
  	var agendaACF = false;
  	jQuery(".postbox.acf-postbox:visible h2").each(function(){
      if (this.textContent === 'agenda extra data') {
  			agendaACF = jQuery(this).closest('.acf-postbox');
  		}
  	});

  	if (agendaACF.length) {

  			var agendaDataIngevuld = 0;

  			var agendaACFI;
  			agendaACF.find('input, select').each(function(){
  				var agendaACFI = jQuery(this);
  				if (agendaACFI.val()) agendaDataIngevuld++;
  			});

  		waarden['weinigAg_agendaData'] = {
  			verg: 'min',
  			val: agendaDataIngevuld,
  			drempel: 7,
  			tekst: "Je hebt maar %VERV% velden ingevuld van de agendadata. Dat kan beter."
  		};

      //zeker weten de conversie er tussen staat op agenda.
      var conversieSelKeuze = document.querySelector('[value=moment]').parentNode.selectedOptions;

      var momConvI = 0;

      //waarom een teller? het kan er maar één zijn. Omdat array.
      for (i = 0; i < conversieSelKeuze.length; i++) {
        if (conversieSelKeuze[i].textContent === 'moment') momConvI++;
      }

      waarden['agendaMomentConversie'] = {
        verg: 'min',
        val: momConvI,
        drempel: 1,
        tekst: "Bij een agendastuk is de moment conversie wel handig."
      };

      //console.log()


  	}




  	var ant, w, isGoed, v;

  	for (v in waarden) {

  		w = waarden[v];

  		if (w.verg === 'max') {
  			isGoed = w.val <= w.drempel;
  		} else {
  			isGoed = w.val >= w.drempel;
  		}

  		if (!isGoed) {
			ant = spreek(w);

			if (!ant) {
				return false;
			}

  		}

  	}

  	return true;

}


function spreek(w) {

	var t = w.tekst.replace("%VERV%", w.val);

	var r = confirm(t + bev);

	return r;

}