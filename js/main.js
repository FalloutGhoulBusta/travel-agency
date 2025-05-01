// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.style.backgroundColor = 'rgba(44, 62, 80, 0.95)';
    } else {
        navbar.style.backgroundColor = 'transparent';
    }
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add animation class to elements when they come into view
const animateOnScroll = () => {
    const elements = document.querySelectorAll('.destination-card, .section-title, .hero-content');
    
    elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;
        
        if (elementTop < window.innerHeight && elementBottom > 0) {
            element.classList.add('fade-in');
        }
    });
};

window.addEventListener('scroll', animateOnScroll);
window.addEventListener('load', animateOnScroll);

// Form validation for contact form
const validateForm = (formElement) => {
    const emailInput = formElement.querySelector('input[type="email"]');
    const nameInput = formElement.querySelector('input[name="name"]');
    
    if (emailInput) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            alert('Please enter a valid email address');
            return false;
        }
    }
    
    if (nameInput && nameInput.value.trim() === '') {
        alert('Please enter your name');
        return false;
    }
    
    return true;
};

// Initialize any forms
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!validateForm(this)) {
            e.preventDefault();
        }
    });
}); 