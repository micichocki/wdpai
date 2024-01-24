const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const retypePasswordInput = document.getElementById('retype-password');
const messagesContainer = document.querySelector('.messages');

emailInput.addEventListener('keyup', validateEmail);
retypePasswordInput.addEventListener('keyup', validatePasswords);

function markValidation(element, condition) {
  !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
  console.log(!condition)
}

function validateEmail() {
  setTimeout(function () {
  const email = emailInput.value;
  markValidation(emailInput, isCorrectEmail(email));
    },
  1000
);
}
  
function isCorrectEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}
  
function validatePasswords() {
  setTimeout(function () {
  const password = passwordInput.value;
  const retypePassword = retypePasswordInput.value;
  markValidation(retypePasswordInput, isCorrectPassword(password, retypePassword));
    },
  1000
  );
} 
  
function isCorrectPassword(password, retypePassword) {
  return password.length >= 4 && password === retypePassword;
}