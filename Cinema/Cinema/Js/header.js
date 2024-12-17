// Get all the anchor links inside the .menu class
const navLinks = document.querySelectorAll('.menu a');

// Add an event listener for each link
navLinks.forEach(link => {
  link.addEventListener('click', function() {
    // Remove the active class from all links
    navLinks.forEach(link => link.classList.remove('active'));
    
    // Add the active class to the clicked link
    this.classList.add('active');
  });
});
