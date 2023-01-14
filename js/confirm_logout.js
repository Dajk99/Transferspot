const logoutBtn = document.querySelector('.header__navbar-item--logout')
const logoutLink = document.querySelector('a.logout')

const logoutConf = e => {
	const msg = 'Nastąpi wylogowanie z konta. Kontynuować?'
	if (confirm(msg)) {
		logoutLink.setAttribute('href', '../components/user_logout.php')
	} else {
		e.preventDefault()
	}
}

logoutBtn.addEventListener('click', logoutConf)
