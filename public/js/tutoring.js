function validateForm() {
    const subject = document.getElementById('subject');
    const date = document.getElementById('date');
    const duration = document.getElementById('duration');
    const price = document.getElementById('price');
    const description = document.getElementById('description');

    const messagesContainer = document.querySelector('.messages');
    messagesContainer.innerHTML = ''; 

    if (!subject.value.trim()) {
        displayMessage('Please select a subject.');
        return false;
    }

    if (!date.value.trim()) {
        displayMessage('Please enter a date and time.');
        return false;
    }

    if (!isValidDateFormat(date.value.trim())) {
        displayMessage('Invalid date and time format. Please use dd:mm:yyyy HH:mm.');
        return false;
    }

    if (!duration.value.trim()) {
        displayMessage('Please enter a duration.');
        return false;
    }

    if (!isValidDuration(duration.value.trim())) {
        displayMessage('Invalid duration format. Please use HH:mm.');
        return false;
    }

    if (!price.value.trim()) {
        displayMessage('Please enter a price.');
        return false;
    }

    if (parseFloat(price.value.trim()) < 0) {
        displayMessage('Price cannot be negative.');
        return false;
    }

    if (!description.value.trim()) {
        displayMessage('Please enter a description.');
        return false;
    }

    if (description.value.trim().length < 20) {
        displayMessage('Description must have at least 20 characters.');
        return false;
    }

    return true;
}

function isValidDateFormat(dateTime) {
    const dateFormatRegex = /^(0[1-9]|[12][0-9]|3[01]):(0[1-9]|1[0-2]):\d{4} (?:[01]\d|2[0-3]):[0-5]\d$/;
    return dateFormatRegex.test(dateTime);
}

function isValidDuration(duration) {
    const durationRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
    return durationRegex.test(duration);
}

function displayMessage(message) {
    const messagesContainer = document.querySelector('.messages');
    const messageElement = document.createElement('div');
    messageElement.classList.add('message');
    messageElement.textContent = message;
    messagesContainer.appendChild(messageElement);
}