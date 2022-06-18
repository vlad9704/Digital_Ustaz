if ('loading' in HTMLImageElement.prototype) {
	const images = document.querySelectorAll('img[loading="lazy"]:not(.safari-ignore)');
	images.forEach((img) => {
		img.src = img.dataset.src || img.dataset.remote;
	});
} else {
	const images = document.querySelectorAll('img[loading="lazy"]:not(.safari-ignore)');
	images.forEach(img => {
		if (img.dataset.remote) {
			img.dataset.src = img.dataset.remote
		};
	});
	// Dynamically import the LazySizes library
	const script = document.createElement('script');
	script.src =
		'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
	document.body.appendChild(script);
}