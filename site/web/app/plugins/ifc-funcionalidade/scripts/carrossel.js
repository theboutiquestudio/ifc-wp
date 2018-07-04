function keyboardHandler(siema, event) {
	var target = event.target;
	var which = event.which;

	if (which === 37) {
		siema.prev();
    } else if (which === 39) {
    	siema.next();
    }
}

jQuery(function (){
	var mySiema = new Siema({
		selector: '.carrossel__siema',
		loop: true,
	});
	document.querySelectorAll('.carrossel__prev').forEach(x => x.addEventListener('click', () => mySiema.prev()));
	document.querySelectorAll('.carrossel__next').forEach(x => x.addEventListener('click', () => mySiema.next()));

	jQuery('.carrossel').keydown(function (event) {
		keyboardHandler(mySiema, event);
	});
});