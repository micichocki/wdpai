const duration = document.getElementById('duration');
const price = document.getElementById('price');
const description = document.getElementById('description');


duration.addEventListener('input', validateDuration);
price.addEventListener('input', validatePrice);
description.addEventListener('input', validateDescription);


function markValidation(element, condition) {
    condition ? element.classList.remove('no-valid') : element.classList.add('no-valid');
}


function validateDuration() {
    setTimeout(function () {
    const durationValue = duration.value.trim();
    const isValid = isValidDuration(durationValue);
    markValidation(duration, isValid);
    return isValid;
        },
    1000
);
}

function validatePrice() {
    setTimeout(function () {
    const priceValue = parseFloat(price.value.trim());
    const isValid = !isNaN(priceValue) && priceValue >= 0 && priceValue <= 1000;
    markValidation(price, isValid, 'Invalid price. Enter a value between 0 and 1000');
    return isValid;
        },
    1000
);
}

function validateDescription() {
    setTimeout(function () {
    const descriptionValue = description.value.trim();
    const isValid = descriptionValue.length >= 10;
    markValidation(description, isValid);
    return isValid;
        },
    1000
);
}


function isValidDuration(duration) {
    const durationRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
    return durationRegex.test(duration);
}

