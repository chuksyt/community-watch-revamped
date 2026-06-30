function updateButtonLayout() {
    const buttons = document.getElementById('buttons');
    const windowWidth = window.innerWidth;

    if (windowWidth <= 768) {
        buttons.style.flexDirection = 'column';
    } else {
        buttons.style.flexDirection = 'row';
    }
}

window.addEventListener('resize', updateButtonLayout);
updateButtonLayout();

// JavaScript code to make the navigation menu responsive
const navbarToggler = document.querySelector('.navbar-toggler');
const navbarNav = document.querySelector('.navbar-collapse');

navbarToggler.addEventListener('click', () => {
    navbarNav.classList.toggle('show');
});