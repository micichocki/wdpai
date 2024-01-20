function validateForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const retypePassword = document.getElementById('retype-password').value;
  
    if (!validateEmail(email)) {
      alert('Invalid email address');
      return false;
    }
  
    if (!validatePassword(password, retypePassword)) {
      alert('Passwords do not match or are not secure');
      return false;
    }
  
    return true;
  }
  
  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  
  function validatePassword(password, retypePassword) {
    return password.length >= 8 && password === retypePassword;
  }