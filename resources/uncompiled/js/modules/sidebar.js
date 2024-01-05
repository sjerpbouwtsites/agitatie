
export default function stickySidebar() {

	if (document.body.offsetWidth > 1200){

		const stickyBar = document.getElementById('sticky-sidebar');
		verplaatsShareDaddy()
	
		// als geen widgets in sidebar dan weer weg.
		if (stickyBar.querySelectorAll('.widget').length === 0) {
			stickyBar.parentNode.removeChild(stickyBar);
		}
	}

		
}

function verplaatsShareDaddy(){

	var shareDaddyOrigineel = document.querySelector('.sharedaddy');
	var shareDaddyWrapperSidebar = document.getElementById('sharedaddy-in-sidebar');
	if (!shareDaddyOrigineel) {
		shareDaddyWrapperSidebar.parentNode.removeChild(shareDaddyWrapperSidebar);
	}
	shareDaddyOrigineel.parentNode.removeChild(shareDaddyOrigineel);
	if (!shareDaddyWrapperSidebar) {
		console.warn('geen share daddy wrapper!?');
		return ;
	}
	if (shareDaddyOrigineel) {
		shareDaddyWrapperSidebar.appendChild(shareDaddyOrigineel);
		shareDaddyOrigineel.classList.add('actief');
	}
}
