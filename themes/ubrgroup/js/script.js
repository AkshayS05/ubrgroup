document.addEventListener("DOMContentLoaded", function () {
  const testimonialsSection = document.getElementById("testimonials");
  if (testimonialsSection) {
    const testimonials = testimonialsSection.querySelectorAll(".testimonial");

    // Hide testimonials section if no testimonials are present
    if (testimonials.length === 0) {
      testimonialsSection.style.display = "none";
    }
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelector(".slides");
  const slideElements = document.querySelectorAll(".slide");
  const prevButton = document.querySelector(".prev");
  const nextButton = document.querySelector(".next");

  if (slides && slideElements.length > 0) {
    let currentIndex = 0;
    const totalSlides = slideElements.length;

    function showSlide(index) {
      slides.style.transform = `translateX(-${index * 100}%)`;
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalSlides;
      showSlide(currentIndex);
    }

    function prevSlide() {
      currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      showSlide(currentIndex);
    }

    // Auto-slide every 5 seconds
    let slideInterval = setInterval(nextSlide, 5000);

    // Stop auto-slide when the user interacts with controls
    if (nextButton) {
      nextButton.addEventListener("click", function () {
        nextSlide();
        resetSlideInterval();
      });
    }

    if (prevButton) {
      prevButton.addEventListener("click", function () {
        prevSlide();
        resetSlideInterval();
      });
    }

    function resetSlideInterval() {
      clearInterval(slideInterval);
      slideInterval = setInterval(nextSlide, 5000);
    }
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.getElementById("hamburger");
  const sideMenu = document.getElementById("side-menu");
  const closeBtn = document.getElementById("close-btn");

  if (hamburger && sideMenu && closeBtn) {
    hamburger.addEventListener("click", function () {
      sideMenu.style.left = "0";
    });

    closeBtn.addEventListener("click", function () {
      sideMenu.style.left = "-100%";
    });

    document.addEventListener("click", function (event) {
      if (!sideMenu.contains(event.target) && event.target !== hamburger) {
        sideMenu.style.left = "-100%";
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const statNumbers = document.querySelectorAll(".stat-number");

  if (statNumbers.length > 0) {
    const animateCountUp = (element) => {
      const target = +element.getAttribute("data-target");
      let count = 0;
      const increment = target / 100;

      const updateCount = () => {
        count += increment;
        if (count < target) {
          element.textContent = Math.floor(count);
          requestAnimationFrame(updateCount);
        } else {
          element.textContent = target;
        }
      };

      updateCount();
    };

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCountUp(entry.target);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 }
    );

    statNumbers.forEach((stat) => observer.observe(stat));
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const carouselInner = document.querySelector(".carousel-inner");
  const items = document.querySelectorAll(".carousel-item");
  const prevButton = document.querySelector(".prev");
  const nextButton = document.querySelector(".next");

  let currentIndex = 0;

  function updateCarousel() {
    items.forEach((item, index) => {
      item.classList.remove("center");
      item.style.opacity = "0"; // Hide all items
      if (index === currentIndex) {
        item.classList.add("center");
        item.style.opacity = "1"; // Show current item
      }
    });
    const offset = -currentIndex * 100;
    carouselInner.style.transform = `translateX(${offset}%)`;
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % items.length;
    updateCarousel();
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + items.length) % items.length;
    updateCarousel();
  }

  // Event listeners for navigation buttons
  nextButton.addEventListener("click", nextSlide);
  prevButton.addEventListener("click", prevSlide);

  // Keyboard navigation
  document.addEventListener("keydown", (event) => {
    if (event.key === "ArrowRight") {
      nextSlide();
    } else if (event.key === "ArrowLeft") {
      prevSlide();
    }
  });

  // Auto-slide every 5 seconds
  setInterval(nextSlide, 5000);

  updateCarousel();
});

document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".nav-links a");
  const hamburger = document.getElementById("hamburger");
  const navMenu = document.getElementById("nav-menu");

  if (navLinks.length > 0 && hamburger && navMenu) {
    navLinks.forEach((link) => {
      link.addEventListener("click", function () {
        // Close the navigation menu when a link is clicked
        navMenu.style.left = "-100%";
      });
    });
  }
});

//for contact form

document.addEventListener("DOMContentLoaded", function () {
  const contactForm = document.querySelector(".contact-form form");

  contactForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    if (!name || !email || !message) {
      alert("Please fill in all fields.");
      return;
    }

    try {
      const response = await fetch("/wp-json/contact-api/v1/submit", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ name, email, message }),
      });

      const result = await response.json();

      if (response.ok) {
        alert(result.message);
        contactForm.reset(); // Clear the form
      } else {
        alert(result.message || "Something went wrong. Please try again.");
      }
    } catch (error) {
      console.error("Error submitting form:", error);
      alert("An error occurred. Please try again later.");
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Hamburger Menu Toggle
  const hamburger = document.getElementById("hamburger");
  const navMenu = document.getElementById("nav-menu");

  if (hamburger && navMenu) {
    // Toggle the hamburger and menu visibility
    hamburger.addEventListener("click", function () {
      hamburger.classList.toggle("active");
      navMenu.classList.toggle("open");
    });

    // Close the menu when clicking on a menu link
    const navLinks = document.querySelectorAll(".nav-links a");
    navLinks.forEach((link) => {
      link.addEventListener("click", function () {
        navMenu.classList.remove("open");
        hamburger.classList.remove("active");
      });
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const statNumbers = document.querySelectorAll(".stat-number");

  if (statNumbers.length > 0) {
    const animateCountUp = (element) => {
      const target = +element.getAttribute("data-target"); // Get the target value
      let count = 0;
      const increment = target / 100; // Adjust the speed

      const updateCount = () => {
        count += increment;
        if (count < target) {
          element.textContent = Math.floor(count) + "+"; // Add "+" during animation
          requestAnimationFrame(updateCount);
        } else {
          element.textContent = target + "+"; // Final number with "+"
        }
      };

      updateCount();
    };

    // Use IntersectionObserver to trigger animation on scroll
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCountUp(entry.target);
            observer.unobserve(entry.target); // Stop observing after animation
          }
        });
      },
      { threshold: 0.5 } // Trigger when 50% of the element is visible
    );

    statNumbers.forEach((stat) => observer.observe(stat)); // Observe each number
  }
});
