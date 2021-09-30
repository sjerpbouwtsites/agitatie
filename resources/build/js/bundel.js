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

var doc, body, aside;
function klikBaas(){   
    
	body.addEventListener('click', function(e){
 
		var
		funcNamen = ['schakel', 'scroll'],
		f;

		for (var i = funcNamen.length - 1; i >= 0; i--) {
			f = funcNamen[i];
			if (e.target.classList.contains(f) || e.target.parentNode.classList.contains(f)) {
				window[f](e);
			}  
		}

	});

}

function init() {
	doc = document;
	body = doc.getElementsByTagName('body')[0] || null;
	doc.getElementsByTagName('html')[0] || null;
	aside = doc.getElementById('zijbalk') || null;
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

	if (doc.getElementById('sticky-sidebar')) {
		stickySidebar();
	}


/*	var shareDaddy = $('.sharedaddy');
	if (shareDaddy.length) kopieerShare(shareDaddy);
*/
	videoPlayer(); 

	if (doc.getElementById('agenda-filter')) agendaFilter();
 
	kopmenuSubMobiel();

};
