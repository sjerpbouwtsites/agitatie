
export default function stickySidebar() {

	const stickyBar = document.getElementById('sticky-sidebar');
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
