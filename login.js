// JavaScript code to make the navigation menu responsive
const navbarToggler = document.querySelector('.navbar-toggler');
const navbarNav = document.querySelector('.navbar-collapse');

navbarToggler.addEventListener('click', () => {
    navbarNav.classList.toggle('show');
});