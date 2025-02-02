document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.image-scroll-container');
    const mainContainer = document.querySelector('main');

    let isScrollingHorizontally = false;

    window.addEventListener('scroll', function() {
        const rect = scrollContainer.getBoundingClientRect();
        const mainRect = mainContainer.getBoundingClientRect();

        // Check if the user has reached the image scroll section
        if (rect.top <= window.innerHeight && rect.bottom >= 0) {
            isScrollingHorizontally = true;
        } else {
            isScrollingHorizontally = false;
        }
    });

    scrollContainer.addEventListener('wheel', function(event) {
        if (isScrollingHorizontally) {
            event.preventDefault();
            scrollContainer.scrollLeft += event.deltaY;
        }
    });
});