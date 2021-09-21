jQuery(document).ready(function ($) {

	if (typeof indexNav !== 'undefined') zetIndexNav();

});

function zetIndexNav (){
	indexNav.addEventListener('click', function(e){
		e.preventDefault();

		var el;

		if (e.target.hasAttribute('href')) {
			el = e.target;
		} else if (e.target.parentNode.hasAttribute('href')) {
			el = e.target.parentNode;
		} else {
			return false;
		}

		var weetje = document.getElementsByClassName('weetje')[0];

		if (!weetje.classList.contains('gefilterd')) weetje.classList.add('gefilterd');

		var toon = el.href.split('#')[1];

		var ankers = document.querySelectorAll('.weetje .index');

		for (var i = ankers.length - 1; i >= 0; i--) {

			d = ankers[i];

			if (d.classList.contains(toon)){
				d.style.display = 'block';
			} else {
				d.style.display = 'none';
			}

		}

	});
}