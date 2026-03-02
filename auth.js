// Password strength checker untuk form registrasi
const passwordInput = document.getElementById('password');
if (passwordInput) {
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        let strength = 0;
        let text = '';
        let color = '';
        
        if (password.length === 0) {
            strengthBar.style.width = '0%';
            strengthText.textContent = '';
            return;
        }
        
        // Check length
        if (password.length >= 6) strength += 25;
        if (password.length >= 8) strength += 25;
        
        // Check for numbers
        if (/\d/.test(password)) strength += 15;
        
        // Check for lowercase
        if (/[a-z]/.test(password)) strength += 15;
        
        // Check for uppercase
        if (/[A-Z]/.test(password)) strength += 10;
        
        // Check for special characters
        if (/[!@#$%^&*]/.test(password)) strength += 10;
        
        // Cap at 100
        strength = Math.min(strength, 100);
        
        // Set strength level
        if (strength < 30) {
            text = 'Lemah';
            color = '#e74c3c';
        } else if (strength < 60) {
            text = 'Sedang';
            color = '#f39c12';
        } else if (strength < 80) {
            text = 'Kuat';
            color = '#3498db';
        } else {
            text = 'Sangat Kuat';
            color = '#27ae60';
        }
        
        strengthBar.style.width = strength + '%';
        strengthBar.style.backgroundColor = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    });
}

// Form validation
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            alert('Semua field harus diisi');
            return false;
        }
        
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            e.preventDefault();
            alert('Email tidak valid');
            return false;
        }
    });
}

const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (!name || !email || !password || !confirmPassword) {
            e.preventDefault();
            alert('Semua field harus diisi');
            return false;
        }
        
        if (name.length < 3) {
            e.preventDefault();
            alert('Nama minimal 3 karakter');
            return false;
        }
        
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            e.preventDefault();
            alert('Email tidak valid');
            return false;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            alert('Password minimal 6 karakter');
            return false;
        }
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak sama');
            return false;
        }
    });
}

// Responsive menu toggle (jika ada)
const menuToggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');

if (menuToggle && menu) {
    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('active');
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!menuToggle.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.remove('active');
        }
    });
}

// Smooth transitions
window.addEventListener('load', function() {
    const boxes = document.querySelectorAll('.auth-box');
    boxes.forEach(box => {
        box.style.opacity = '1';
    });
});

// Add ripple effect to buttons
const buttons = document.querySelectorAll('button');
buttons.forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
    });
});

// Check if password and confirm password match in real-time
const passwordField = document.getElementById('password');
const confirmPasswordField = document.getElementById('confirm_password');

function checkPasswordMatch() {
    if (!passwordField || !confirmPasswordField) return;
    
    if (passwordField.value === confirmPasswordField.value && passwordField.value !== '') {
        confirmPasswordField.style.borderColor = '#27ae60';
    } else if (confirmPasswordField.value !== '') {
        if (passwordField.value !== confirmPasswordField.value) {
            confirmPasswordField.style.borderColor = '#e74c3c';
        }
    } else {
        confirmPasswordField.style.borderColor = '#ecf0f1';
    }
}

if (passwordField) passwordField.addEventListener('input', checkPasswordMatch);
if (confirmPasswordField) confirmPasswordField.addEventListener('input', checkPasswordMatch);
