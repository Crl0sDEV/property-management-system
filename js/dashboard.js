// Fetch tenant data dynamically
async function fetchTenantData() {
    const response = await fetch('php/dashboard/get-tenant-data.php'); // Adjust endpoint if needed
    const data = await response.json();
    return data;
}

// Populate Card Boxes with Tenant Data
async function populateCards() {
    const data = await fetchTenantData();

    const tenantCardContainer = document.getElementById('tenantCardContainer');
    tenantCardContainer.innerHTML = `
        <div class="card">
            <h3>${data.tenantStatus.active}</h3>
            <p>Active Tenants</p>
        </div>
        <div class="card">
            <h3>${data.tenantStatus.archived}</h3>
            <p>Archived Tenants</p>
        </div>
    `;
}

// Initialize the dashboard on page load
populateCards();

// Log Out Button Handler
document.getElementById('logoutBtn').onclick = function () {
    window.location.href = 'login.html';
};