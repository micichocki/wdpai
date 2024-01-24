const emailInput = document.getElementById('email');
const cityInput = document.getElementById('city');

emailInput.addEventListener('keyup', validateEmail);
cityInput.addEventListener('keyup', validateCity);

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function validateEmail() {
    setTimeout(function () {
        const email = emailInput.value;
        markValidation(emailInput, isCorrectEmail(email));
    }, 1000);
}

function validateCity() {
    setTimeout(function () {
        const city = cityInput.value;
        markValidation(cityInput, isCorrectCity(city));
    }, 1000);
}

function isCorrectEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isCorrectCity(city) {
    const cityRegex = /^[A-Za-z]+$/;
    return cityRegex.test(city);
}
