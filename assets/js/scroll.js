document.addEventListener("DOMContentLoaded", function () {
  const heroSlider = document.querySelector(".hero-slider");

  function handleScroll() {
    const scrollY = window.scrollY;

    if (window.innerWidth <= 768) {
      // For mobile screens
      heroSlider.style.top = scrollY > 50 ? "0px" : "93px";
    } else {
      // For desktop screens
      heroSlider.style.top = scrollY > 100 ? "0px" : "93px";
    }
  }

  window.addEventListener("scroll", handleScroll);
  handleScroll(); // Initial check
});
