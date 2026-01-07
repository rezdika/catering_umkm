document.addEventListener('DOMContentLoaded', function() {
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const faqItem = this.closest('.faq-item');
            const content = faqItem.querySelector('.faq-content');
            const icon = this.querySelector('.faq-icon');
            
            // Close all other FAQ items
            faqToggles.forEach(otherToggle => {
                if (otherToggle !== toggle) {
                    const otherItem = otherToggle.closest('.faq-item');
                    const otherContent = otherItem.querySelector('.faq-content');
                    const otherIcon = otherToggle.querySelector('.faq-icon');
                    
                    otherContent.classList.add('hidden');
                    otherIcon.textContent = '+';
                }
            });
            
            // Toggle current FAQ item
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.textContent = '-';
            } else {
                content.classList.add('hidden');
                icon.textContent = '+';
            }
        });
    });
});

// Function to scroll to contact form
function scrollToContactForm() {
    const contactForm = document.querySelector('form');
    if (contactForm) {
        contactForm.scrollIntoView({ 
            behavior: 'smooth',
            block: 'center'
        });
    }
}