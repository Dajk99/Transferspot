const logoutBtn = document.querySelector('.logout')

const logoutConf = e => {
	const msg = 'Nastąpi wylogowanie z konta. Kontynuować?'
	if (confirm(msg)) {
		logoutBtn.setAttribute('href', '/components/user_logout.php')
	} else {
		e.preventDefault()
	}
}

logoutBtn.addEventListener('click', logoutConf)
