// script.js
document.addEventListener("DOMContentLoaded", () => {
    const openFormButton = document.getElementById("openFormButton");
    const closeFormButton = document.getElementById("closeFormButton");
    const floatingForm = document.getElementById("floatingForm");

    // Show the form when the button is clicked
    openFormButton.addEventListener("click", () => {
        floatingForm.classList.remove("hidden");
    });

    // Hide the form when the cancel button is clicked
    closeFormButton.addEventListener("click", () => {
        floatingForm.classList.add("hidden");
    });

    // Submit event for the form
    const form = document.getElementById("form");
    form.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent the default form submission
        alert("Form submitted!");
        floatingForm.classList.add("hidden"); // Hide the form after submission
    });
});
