document.addEventListener("DOMContentLoaded", function() {
    const applyButtons = document.querySelectorAll('.apply-button');
    const userIdElement = document.getElementById('user-id');
    const userId = userIdElement ? userIdElement.textContent : '';
  
    applyButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const tutoringId = button.getAttribute('data-tutoring-id');
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
                    window.location.href = '/dashboard'; 
                } else {
                }
            })
            .catch(error => {
                console.error('Error during reservation:', error);
            });
        });
    });

    const removeButtons = document.querySelectorAll('.remove-button');
  removeButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
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
        console.log('Server response:', data);
        if (data.success) {
          window.location.reload();
        } else {
          alert('An error occurred during participation removal.');
        }
      })
      .catch(error => {
        console.error('Error during participation removal:', error);
      });
    });
  });
});