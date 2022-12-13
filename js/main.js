const burgerBtn = document.querySelector('.navbar__mobile-btns-btn-burger')
const navItems = document.querySelectorAll('.navbar__mobile-item')
const allSections = document.querySelectorAll('section')

const handleNav = () => {
	navItems.forEach(item => {
		item.classList.toggle('deactive')
		item.addEventListener('click', () => {
			hideNav()
		})
	})
}

const hideNav = () => {
	navItems.forEach(item => {
		item.classList.add('deactive')
	})
}

burgerBtn.addEventListener('click', handleNav)
