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
	document.querySelector('.carrossel__prev').addEventListener('click', () => mySiema.prev());
	document.querySelector('.carrossel__next').addEventListener('click', () => mySiema.next());

	jQuery('.carrossel').keydown(function (event) {
		keyboardHandler(mySiema, event);
	});
});