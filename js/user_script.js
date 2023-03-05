const header = document.querySelector('.header')
const burgerBtn = document.querySelector('.burger-btn')
const burgerBars = document.querySelector('.fa-bars')
const postsContainer = document.querySelector('.show-ann__container')
const emptyContainer = document.querySelector('.show-ann__container__empty')
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

if (document.querySelector('.burger-btn') !== null) {
	burgerBtn.addEventListener('click', showPanel)
}

if (emptyContainer != null) {
	postsContainer.style.display = 'flex'
}
