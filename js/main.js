const burgerBtn = document.querySelector('.navbar__mobile-btns-btn-burger')
const navItems = document.querySelectorAll('.navbar__mobile-item')
const mobileNav = document.querySelector('.navbar__mobile')

const showNavItems = () => {
	let delay = 0
	mobileNav.classList.toggle('active-nav-bg')
	navItems.forEach(item => {
		item.classList.toggle('deactive')
		item.classList.toggle('nav-items-animation')
		item.style.animationDelay = '.' + delay + 's'
		delay++
	})
}

burgerBtn.addEventListener('click', showNavItems)
