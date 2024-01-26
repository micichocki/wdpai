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
    const cityRegex = /^[A-Za-z\u0104\u0106\u0118\u0141\u0143\u00D3\u015A\u0179\u017B\u017A\u0105\u0107\u0119\u0142\u0144\u00F3\u015B\u017A\s]+$/;
    return cityRegex.test(city);
}
