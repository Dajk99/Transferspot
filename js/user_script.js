const header = document.querySelector('.header')
const burgerBtn = document.querySelector('.burger-btn')
const burgerBars = document.querySelector('.fa-bars')
const posts = document.querySelectorAll('.show-ann__container__box-content')

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
	document.body.classList.toggle('sticky')
	darkBody()
}

posts.forEach(content => {
	if (content.classList.contains('no-slice') != true) {
		if (content.innerHTML.length > 100) {
			content.innerHTML = content.innerHTML.slice(0, 100) + '...'
		}
	}
})

if (document.querySelector('.burger-btn') !== null) {
	burgerBtn.addEventListener('click', showPanel)
}
