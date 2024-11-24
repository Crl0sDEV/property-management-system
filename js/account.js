// Function to fetch user data from the server using AJAX
window.onload = function() {
    fetchUserData();
};

function fetchUserData() {
    fetch('php/account/account.php')  // Request data from account.php
        .then(response => response.json())  // Parse JSON response
        .then(data => {
            // Check if the response has user data
            if (data.error) {
                console.error("Error: " + data.error);
            } else {
                // Insert data into the HTML
                document.getElementById('user-name').textContent = data.name;
                document.getElementById('user-role').textContent = data.role;
                document.getElementById('user-email').textContent = data.email;
            }
        })
        .catch(error => console.error('Error fetching user data:', error));
}
    // Get elements
    const profileBtn = document.getElementById('profile-btn');
    const accountDetailsBtn = document.getElementById('account-details-btn');
    const changePasswordBtn = document.getElementById('change-password-btn');
    const logoutBtn = document.getElementById('logoutBtn');

    const profile = document.getElementById('profile');
    const accountDetails = document.getElementById('account-details');
    const changePassword = document.getElementById('change-password');
    const loginPage = document.getElementById('login-page');

    // Event listeners for sidebar buttons
    profileBtn.addEventListener('click', function() {
        showPage(profile);
    });

    accountDetailsBtn.addEventListener('click', function() {
        showPage(accountDetails);
    });

    changePasswordBtn.addEventListener('click', function() {
        showPage(changePassword);
    });

    logoutBtn.addEventListener('click', function() {
        showPage(loginPage);
    });

    // Function to display the clicked section and hide others
    function showPage(page) {
        profile.classList.add('hidden');
        accountDetails.classList.add('hidden');
        changePassword.classList.add('hidden');
        loginPage.classList.add('hidden');
        
        page.classList.remove('hidden');
    }

    // Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const passwordField = document.getElementById(targetId);

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        }
    });
});

function showToast(message, type = "success") {
    const toastContainer = document.getElementById("toast-container");
    const toast = document.createElement("div");
    toast.className = `toast ${type}`;
    toast.textContent = message;

    toastContainer.appendChild(toast);

    // Remove the toast after 4 seconds
    setTimeout(() => {
        toast.remove();
    }, 4000);
}

document.querySelector('form[action="php/account/save_account_details.php"]').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('php/account/save_account_details.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, "success");
        } else {
            showToast(data.message, "error");
        }
    })
    .catch(error => showToast("An error occurred.", "error"));
});

document.querySelector('form[action="php/account/change_password.php"]').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('php/account/change_password.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, "success");
        } else {
            showToast(data.message, "error");
        }
    })
    .catch(error => showToast("An error occurred.", "error"));
});

    document.getElementById('logoutBtn').onclick = function() {
        window.location.href = 'login.html';
    };