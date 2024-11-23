const form = document.getElementById("tenantForm");
      const notification = document.getElementById("notification");

      // Handle form submission with JavaScript
      form.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch("php/addtenant/addTenant.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.status === "success") {
              // Show the success notification
              notification.textContent = "Form submitted successfully!";
              notification.style.backgroundColor = "#4CAF50"; // Green
            } else {
              notification.textContent =
                "Error: " + (data.message || "Something went wrong!");
              notification.style.backgroundColor = "#f44336"; // Red
            }

            notification.classList.add("show");

            setTimeout(() => {
              notification.classList.remove("show");
            }, 3000);

            if (data.status === "success") {
              form.reset();
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            notification.textContent = "Error: Could not submit the form.";
            notification.style.backgroundColor = "#f44336";
            notification.classList.add("show");

            setTimeout(() => {
              notification.classList.remove("show");
            }, 3000);
          });
      });