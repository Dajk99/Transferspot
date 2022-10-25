const logoutBtn = document.querySelector('.logout')

const logoutConf = () => {
	confirm('Nastąpi wylogowanie z konta. Kontynuować?')
}

logoutBtn.addEventListener('click', logoutConf)
