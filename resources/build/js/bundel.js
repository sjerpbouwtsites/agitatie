function stickySidebar() {

	const stickyBar = document.getElementById('sticky-sidebar');
	verplaatsShareDaddy();

	// als geen widgets in sidebar dan weer weg.
	if (stickyBar.querySelectorAll('.widget').length === 0) {
		stickyBar.parentNode.removeChild(stickyBar);
	}
		
}

function verplaatsShareDaddy(){
	var shareDaddyOrigineel = document.querySelector('.sharedaddy');
	if (!shareDaddyOrigineel) return;
	shareDaddyOrigineel.parentNode.removeChild(shareDaddyOrigineel);
	var shareDaddyWrapperSidebar = document.getElementById('sharedaddy-in-sidebar');
	if (!shareDaddyWrapperSidebar) {
		console.warn('geen share daddy wrapper!?');
		return ;
	}
	shareDaddyWrapperSidebar.appendChild(shareDaddyOrigineel);
	shareDaddyOrigineel.classList.add('actief');
}

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

var doc$1, body$1, aside;
function klikBaas(){   
    
	body$1.addEventListener('click', function(e){
 
		var
		funcNamen = ['schakel', 'scroll'],
		f;

		for (var i = funcNamen.length - 1; i >= 0; i--) {
			f = funcNamen[i];

			if (e.target.classList.contains(f) || e.target.parentNode.classList.contains(f)) {
				schakel[f](e);
			}  
		}

	});

}

function init() {
	doc$1 = document;
	body$1 = doc$1.getElementsByTagName('body')[0] || null;
	doc$1.getElementsByTagName('html')[0] || null;
	aside = doc$1.getElementById('zijbalk') || null;
}

function verschrikkelijkeHacks(){

	if (aside) {
		var
		l = aside.getElementsByTagName('section').length;

		var
		c = (l%2 === 0 ? 'even' : 'oneven');

		aside.classList.add('sectietal-'+c);
	}

}



function videoPlayer () {

	$('video ~ .Ag_knop').hover(function(){
		if (this.classList.contains('speel-video')) {
			this.classList.add('in-wit');
		} else {
			this.classList.remove('in-wit');
		}
	}, function(){
		if (this.classList.contains('speel-video')) {
			this.classList.remove('in-wit');
		} else {
			this.classList.add('in-wit');
		}
	});

	$('body').on('click', '.speel-video', function(e){
		e.preventDefault();
		console.log(this, $(this).closest('vid-doos').find('video'));
		$(this).closest('.vid-doos').find('video').click();
		//this.parentNode.getElementsByTagName('video')[0].click();
	});

	$('body').on('click', 'video', function(){
		if (this.paused) {
			this.classList.remove('pause');
			this.classList.add('speelt');
			this.play();
		} else {
			this.classList.remove('speelt');
			this.classList.add('pause');
			this.pause();
		}

	});
}



function artCLinkTrigger(){
	$('.art-c').on('click', 'div', function(e){

		if (this.classList.contains('art-rechts')) {
			this.querySelector('a').click();
		}

	});
}

function kopmenuSubMobiel() {

	if (!$('.kopmenu-mobiel:visible').length) {
		return false;
		//niet mobiel
	}

	// $("#stek-kop .menu").on('click', 'i', function(e){
	// 	e.preventDefault();
		
	// 	document.querySelector('.menu-kop-container').classList.toggle('tonen');

	// 	// const menuKop = document.getElementById('menu-kop');
	// 	// menuKop.classList.add('klaar-voor-schuiven');
	// 	// setTimeout(()=>{
	// 	// 	menuKop.classList.toggle('omhoog-geschoven');
	// 	// }, 5); 

		
	// });

}



window.onload = function(){

	init();

	klikBaas();

	verschrikkelijkeHacks();

	artCLinkTrigger();

	if (doc$1.getElementById('sticky-sidebar')) {
		stickySidebar();
	}


/*	var shareDaddy = $('.sharedaddy');
	if (shareDaddy.length) kopieerShare(shareDaddy);
*/
	videoPlayer(); 

	if (doc$1.getElementById('agenda-filter')) agendaFilter();
 
	kopmenuSubMobiel();

};
