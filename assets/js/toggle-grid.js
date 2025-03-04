document.addEventListener("DOMContentLoaded", function () {
  const gridContainer = document.getElementById("news-archive-grid");
  const largeButton = document.getElementById("toggle-large");
  const smallButton = document.getElementById("toggle-small");
  const toggleLinks = document.querySelectorAll(".toggle-view");

  // Function to handle grid view changes and toggle active class
  function toggleView(view) {
    if (view === "large") {
      gridContainer.classList.add("large-view");
      gridContainer.classList.remove("small-view");
    } else if (view === "small") {
      gridContainer.classList.add("small-view");
      gridContainer.classList.remove("large-view");
    }

    // Update active state
    toggleLinks.forEach((link) => link.classList.remove("active"));
    document.getElementById(`toggle-${view}`).classList.add("active");
  }

  // Add event listeners for toggles
  largeButton.addEventListener("click", () => toggleView("large"));
  smallButton.addEventListener("click", () => toggleView("small"));
});
