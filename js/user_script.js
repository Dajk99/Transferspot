const header = document.querySelector('.header')
const burgerBtn = document.querySelector('.burger-btn')
const burgerBars = document.querySelector('.fa-bars')

const darkBody = () => {
	const darkDiv = document.querySelector('.dark')
	if (darkDiv == null) {
		let darkBg = document.createElement('div')
		darkBg.classList.toggle('dark')
		document.body.append(darkBg)
	} else {
		darkDiv.remove()
	}
}

const showPanel = () => {
	header.classList.toggle('header--active')
	// burgerBars.classList.toggle('fa-bars--dark')
	document.body.classList.toggle('sticky')
	darkBody()
}

// window.onscroll = () => {
// 	header.classList.remove('header--active')
// }

burgerBtn.addEventListener('click', showPanel)
