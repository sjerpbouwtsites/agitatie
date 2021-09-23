
export default function stickySidebar() {

	const stickyBar = document.getElementById('sticky-sidebar');
	
	const contentWidth = document.body.dataset.contentWidth;
	const spaceToTheRight = (window.innerWidth - contentWidth) / 2;
	const spaceNeeded = stickyBar.offsetWidth + 30;
	var kanStickyDoen = spaceToTheRight > spaceNeeded;

	if (!kanStickyDoen) {
		stickyBar.parentNode.removeChild(stickyBar);
		return;
	}

	stickyBar.style.opacity = 0;


	const berichtTekst = document.querySelector('div.bericht-tekst');

	var offset = $('div.bericht-tekst').offset().top - $("#stek-kop").height();
	//const right = (spaceToTheRight - stickyBar.offsetWidth) / 2;
	const right = 20;

	//als er geen uitgelichte afbeelding is telt de margin van h1 mee.
	if (!$(".uitgelichte-afbeelding-buiten").length) {
		offset -= Number($('h1').css('margin-top').replace('px', ''));
	}

	stickyBar.style.top = offset + "px";
	stickyBar.style.right = right + "px";
	//stickyBar.style.height = berichtTekst.offsetHeight + "px";
	
	$('#main').addClass('heeft-sticky').append($(stickyBar));
	document.getElementsByTagName('main')[0].classList.add('heeft-sticky');



	setTimeout(()=>{
		stickyBar.style.opacity = 1;
		const stickyWidgets = Array.from(document.querySelectorAll('.sticky-widget'));
		const hoogteStickyWidgets = stickyWidgets.reduce((prev, next)=>{
			console.log(prev, next.scrollHeight)
			return prev + next.scrollHeight;
		}, 0) + (stickyWidgets.length - 1) * 20;
		const binnen = document.querySelector('.sticky-binnen');
		if (binnen.offsetHeight < hoogteStickyWidgets) {
			binnen.style.maxHeight = 'initial'; 		
		}
		binnen.style.minHeight = `${hoogteStickyWidgets}px`; 		
		document.getElementById('sticky-sidebar').style.height = `${hoogteStickyWidgets + 80}px`; 	 
	}, 150);

	verplaatsShareDaddy()

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
