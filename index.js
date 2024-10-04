document.addEventListener('DOMContentLoaded', () => {
    const loginSection = document.querySelector('.login-section');
    const loginLink = document.querySelector('.login-link');
    const registerLink = document.querySelector('.register-link');

    // Show Register Form
    registerLink.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default anchor behavior
        loginSection.classList.add('active');
    });

    // Show Login Form
    loginLink.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default anchor behavior
        loginSection.classList.remove('active');
    });
});
