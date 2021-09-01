function schakel(e) {

	var
	doel = actieInit(e, 'schakel'),
	toon = doc.querySelectorAll( doel.getAttribute('data-toon') ),
	antiSchakel,
	anti = [],
	i;

	if (doel.hasAttribute('data-doorschakel')) {
		doc.querySelector(doel.getAttribute('data-doorschakel')).click();
		return;
	}

	if (doel.hasAttribute('data-anti')) {

		antiSchakel = doc.querySelectorAll(doel.getAttribute('data-anti'));
		var ai;
		for (i = antiSchakel.length - 1; i >= 0; i--) {
			ai = antiSchakel[i];
			ai.classList.remove('open');
			body.classList.remove(ai.id+'-open');
			anti.push(doc.querySelectorAll( ai.getAttribute('data-toon')) );
		}
	}

	//tonen of verstoppen afhankelijk van open
	var stijl = '';
	if (!doel.classList.contains('open')) {
		if(!body.classList.contains(doel.id+'-open')) {
			body.classList.add(doel.id+'-open');
		}
		stijl = "block";
	} else {
		stijl = "none";
		body.classList.remove(doel.id+'-open');
	}

	if (toon) zetStijl(toon, 'display', stijl);
	if (anti.length) {
		for (i = anti.length - 1; i >= 0; i--) {
			zetStijl(anti[i], 'display', 'none');
		}
	}

	doel.classList.toggle('open');

	if (doel.hasAttribute('data-f')) {
		schakelExtra[doel.getAttribute('data-f')]();
	}
}

var schakelExtra = {
	focusZoekveld: function(){
		doc.getElementById('zoekveld').getElementsByTagName('input')[0].focus();
	},
};

function scroll(e) {

	var scrollNaar;

	//var werkMet = e.target.classList.contains('Ag_knop') ? e.target : e.target.parentNode;
	var werkMet = actieInit(e, 'scroll');

	if (werkMet.hasAttribute('doel')) {

		scrollNaar = werkMet.getAttribute('doel');

	} else if (werkMet.hasAttribute('href')) {

		scrollNaar = werkMet.getAttribute('href');

	} else {

	}

	var headerH = $('#stek-kop').is(':visible') ? $('#stek-kop').height() : 0;

	var marginTop = Number($(scrollNaar).css('margin-top').replace('px', ''));

    $('html, body').animate({
        scrollTop: $(scrollNaar).offset().top - headerH - marginTop
    }, 600);
}