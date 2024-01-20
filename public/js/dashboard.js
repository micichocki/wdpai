document.addEventListener("DOMContentLoaded", function () {
  const applyButtons = document.querySelectorAll('.apply-button');
  const removeButtons = document.querySelectorAll('.remove-button');
  const userIdElement = document.getElementById('user-id');
  const userId = userIdElement ? userIdElement.textContent : '';

  function handleApplyButtonClick(button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();

      const tutoringId = button.getAttribute('data-tutoring-id');
      const creatorId = button.getAttribute('data-creator-id');
      console.log('userId:', userId);
      console.log('creatorId:', creatorId);

      if (userId === creatorId) {
        const messagesContainer = document.querySelector('.messages');
        messagesContainer.innerHTML = '<div class="message">You cannot apply to your own tutoring.</div>';
        return;
      }

      fetch('/add_participation', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          tutoringId: tutoringId,
          userId: userId,
        }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.reload();
          }
        })
        .catch(error => {
          console.error('Error during reservation:', error);
        });
    });
  }

  function handleRemoveButtonClick(button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();

      const tutoringId = button.getAttribute('data-tutoring-id');

      fetch('/delete_participation', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          tutoringId: tutoringId,
        }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.reload();
          }
        })
        .catch(error => {
          console.error('Error during participation removal:', error);
        });
    });
  }

  applyButtons.forEach(handleApplyButtonClick);
  removeButtons.forEach(handleRemoveButtonClick);


  
});
