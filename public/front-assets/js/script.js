const menuOpenButton = document.querySelector("#menu-open-button");
const menuCloseButton = document.querySelector("#menu-close-button");
const navLinks = document.querySelectorAll(".nav-menu .nav-link");

menuOpenButton.addEventListener("click", ()=>{
    // Togle mobile menu visibility
    document.body.classList.toggle("show-mobile-menu");
})

// close menu when the close button is clicked
menuCloseButton.addEventListener("click", ()=> menuOpenButton.click());

// close menu when the nav link is clicked
navLinks.forEach(link => {
    link.addEventListener("click", ()=> menuOpenButton.click());
})

// Initialize Swiper
const swiper = new Swiper('.slider-wrapper', {

  loop: true,
  grabCursor: true,
  spaceBetween: 25,

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
    dynamicBullets: true,
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

//   Responsive breack point
breakpoints: {
    0: {
        slidesPerView: 1
    },
    768: {
        slidesPerView: 2
    },
    1024: {
        slidesPerView: 3
    }
}

});

document.addEventListener("DOMContentLoaded", () => {
  const faqItems = document.querySelectorAll(".faq-item");

  faqItems.forEach(item => {
    const question = item.querySelector(".faq-question");

    question.addEventListener("click", () => {
      item.classList.toggle("active");

      // Close others
      faqItems.forEach(other => {
        if (other !== item) {
          other.classList.remove("active");
        }
      });
    });
  });
});

  document.querySelectorAll('#questions-container > div').forEach(item => {
    const header = item.querySelector('.flex.justify-between');
    header.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');

      // Close all
      document.querySelectorAll('#questions-container > div').forEach(i => {
        i.classList.remove('open', 'active');
      });

      // Toggle current
      if (!isOpen) {
        item.classList.add('open', 'active');
      }
    });
  });
