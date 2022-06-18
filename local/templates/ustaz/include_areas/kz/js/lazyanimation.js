{
	const config = {
		rootMargin: '50px 0px 50px 0px',
		threshold: 0,
	};

	let observer = new IntersectionObserver((entries, self) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				animation(entry.target);
				self.unobserve(entry.target);
			}
		});
	}, config);

	const lazyElements = document.querySelectorAll('.animation-lazy');

	lazyElements.forEach((el) => {
		observer.observe(el);
	});

	const animation = (el) => {
		el.classList.add('active-animation');
	};
}
