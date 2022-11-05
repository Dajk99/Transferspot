const header = document.querySelector('.header')
const burgerBtn = document.querySelector('.burger-btn')
const burgerBars = document.querySelector('.fa-bars')

const showPanel = () => {
	header.classList.toggle('header--active')
	burgerBars.classList.toggle('fa-bars--dark')
}

window.onscroll = () => {
	header.classList.remove('header--active')
}

burgerBtn.addEventListener('click', showPanel)
