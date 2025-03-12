document.addEventListener("DOMContentLoaded", function () {
  const filterButtons = document.querySelectorAll(".filter-button");
  const bioItems = document.querySelectorAll(".community-page-bio-item");

  filterButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      // Remove active class from all buttons
      filterButtons.forEach((btn) => btn.classList.remove("active"));
      // Add active class to clicked button
      this.classList.add("active");

      const filter = this.getAttribute("data-filter");
      bioItems.forEach((item) => {
        if (filter === "all") {
          item.style.display = "block";
        } else {
          const labels = item.querySelector(".label");
          // Convert label text to slug format for comparison
          const labelSlug = labels
            ? labels.textContent.toLowerCase().replace(/\s+/g, "-")
            : "";
          if (labelSlug === filter) {
            item.style.display = "block";
          } else {
            item.style.display = "none";
          }
        }
      });
    });
  });
});
