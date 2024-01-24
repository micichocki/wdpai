const nameInput = document.getElementById('name');
const surnameInput = document.getElementById('surname');
const form = document.querySelector('.personal-info-form');
const messagesContainer = document.querySelector('.welcome-text');

nameInput.addEventListener('input', validateName);
surnameInput.addEventListener('input', validateSurname);


function markValidation(element, condition) {
    condition ? element.classList.remove('no-valid') : element.classList.add('no-valid');
    if (!condition){
        messagesContainer.innerHTML = `Credentials must have between 2 and 20 characters`;
        messagesContainer.style.color='red';
    }
}

function validateName() {
    setTimeout(function () {
    const name = nameInput.value;
    markValidation(nameInput, isValidWord(name));
        },
    1000
);
}

function validateSurname() {
    setTimeout(function () {
    const surname = surnameInput.value;
    markValidation(surnameInput, isValidWord(surname));
        },
    1000
);
}

function isValidWord(word) {
    if (word.length > 2 && word.length <= 20 && !/\d/.test(word)) {
        return true;
    }
    return false;
}