function randBackground (argument) {
	// Activate cloaking device
	var randnum = Math.random();
	var inum = 6;
	// Change this number to the number of images you are using.
	var rand1 = Math.round(randnum * (inum-1)) + 1;
	images = new Array
	images[1] = "img/fondo1.jpg"
	images[2] = "img/fondo2.jpg"
	images[3] = "img/fondo3.jpg"
	images[4] = "img/fondo5.jpg"
	images[5] = "img/fondo6.png"
	images[6] = "img/fondo7.png"
	// Ensure you have an array item for every image you are using.
	var image = images[rand1]
	// Deactivate cloaking device
	document.body.style.backgroundImage = "url('"+image+"')";
}