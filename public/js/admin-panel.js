document.addEventListener('DOMContentLoaded', function () {
    const removeButtons = document.querySelectorAll('.remove-button');

    removeButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const userId = button.getAttribute('user-id');

            removeUser(userId);
        });
    });

    function removeUser(userId) {
        fetch('/delete_user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                userId: parseInt(userId), 
            }),
        })
            .then(response => response.json())
            .then(data => {
                const messagesContainer = document.getElementsByClassName('messages');
                if (data.success) {
                    messagesContainer.innerHTML = `<p class="success-message">${data.message}</p>`;
                    window.location.reload();
                } else {
                    messagesContainer.innerHTML = `<p class="error-message">${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error during user removal:', error);
            });
    }
});
