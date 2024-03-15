// js-popup

function toggleNavBtn(){
	const form = document.querySelectorAll(".js-popup-form ")
	console.log('je suis la', form)
}

toggleNavBtn()

function init() {
	const popupButtons = document.querySelectorAll('.js-popup-btn')
	const forms = document.querySelectorAll(".js-popup-form ")

	let formHidden = null
	let formVisible = null

	let btnActive = null
	let btnNotActive = null

	forms.forEach(form => {
		if (form.classList.contains("isHidden")) {
			formHidden = form
		} else {
			formVisible = form
		}
	});

	popupButtons.forEach(btn => {
		if (btn.classList.contains("loginNav_link_active")) {
			btnActive = btn
			console.log(btnActive)
		} else {
			btnNotActive = btn
			console.log(btnNotActive)
		}
	});

	popupButtons.forEach(button => {
		button.addEventListener('click', function handleClick() {
			
			if (!button.classList.contains('loginNav_link_active')) {
				console.log('Popup button clicked!')
				formHidden.classList.toggle("isHidden")
				formVisible.classList.toggle("isHidden")

				btnActive.classList.toggle("loginNav_link_active")
				btnNotActive.classList.toggle("loginNav_link_active")
			}
		});
	});
}

init()

