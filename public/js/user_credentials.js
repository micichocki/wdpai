document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.getElementById('name');
    const surnameInput = document.getElementById('surname');
    const form = document.querySelector('.personal-info-form');
    const messagesContainer = document.querySelector('.messages');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = nameInput.value.trim();
        const surname = surnameInput.value.trim();

        messagesContainer.innerHTML = ''; // Wyczyść poprzednie komunikaty

        if (name.length < 2 || name.length > 26) {
            displayErrorMessage('Name must be between 2 and 26 characters.');
            return;
        }

        if (surname.length < 2 || surname.length > 26) {
            displayErrorMessage('Surname must be between 2 and 26 characters.');
            return;
        }

        form.submit();
    });

    function displayErrorMessage(message) {
        messagesContainer.innerHTML = '<div class="error-message">' + message + '</div>';
    }
});