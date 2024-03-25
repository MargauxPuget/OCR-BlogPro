// js-popup

function openPopup(){
	const popup = document.querySelector(".js-popup ")
	const btn = document.querySelector(".js-openPopup ")

	btn.addEventListener('click', function handleClick() {
		popup.classList.remove("hidden")
	})
}

function closePopup(){
	const popup = document.querySelector(".js-popup ")
	const form = document.querySelector(".js-closePopup ")

	form.addEventListener('click', function handleClick() {
		popup.classList.add("hidden")
	})
}

function changeForm(){
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
		} else {
			btnNotActive = btn
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

function init() {
	openPopup()
	closePopup()
	changeForm()
}

init()

