async function fetchTenantData() {
    const response = await fetch('php/dashboard/get-tenant-data.php'); 
    const data = await response.json();
    return data;
}


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


async function renderOccupancyChart() {
    const data = await fetchTenantData();

    const maxUnits = 15;
    const occupiedUnits = data.tenantStatus.occupied; 
    const availableUnits = maxUnits - occupiedUnits;

    const ctx = document.getElementById('occupancyChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Occupied', 'Available'],
            datasets: [{
                data: [occupiedUnits, availableUnits],
                backgroundColor: ['#4CAF50', '#FF5252'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            },
        }
    });
}

async function renderMonthlyIncomeChart() {
const data = await fetchTenantData();

const incomeData = data.tenantStatus.monthlyIncome;
const labels = incomeData.map(item => item.month);
const incomes = incomeData.map(item => parseFloat(item.total_income));

const ctx = document.getElementById('monthlyIncomeChart').getContext('2d');
new Chart(ctx, {
type: 'line',
data: {
    labels: labels,
    datasets: [{
        label: 'Monthly Income',
        data: incomes,
        borderColor: '#4CAF50',
        backgroundColor: 'rgba(76, 175, 80, 0.2)',
        fill: true,
        tension: 0.4,
    }]
},
options: {
    responsive: true,
    plugins: {
        legend: {
            position: 'top',
        },
    },
    scales: {
        x: {
            title: {
                display: true,
                text: 'Month',
            },
        },
        y: {
            title: {
                display: true,
                text: 'Income (PHP)',
            },
            beginAtZero: true,
        },
    },
},
});
}

async function renderMaintenanceChart() {
const response = await fetch('php/dashboard/get-tenant-data.php');
const data = await response.json();
const maintenanceData = data.tenantStatus.monthlyMaintenance;

const labels = maintenanceData.map(item => item.month);
const charges = maintenanceData.map(item => parseFloat(item.total_charge));

const ctx = document.getElementById('maintenanceChart').getContext('2d');
new Chart(ctx, {
type: 'bar',
data: {
    labels: labels,
    datasets: [{
        label: 'Monthly Maintenance',
        data: charges,
        backgroundColor: '#FF9800',
        borderColor: '#FF5722',
        borderWidth: 1
    }]
},
options: {
    responsive: true,
    plugins: {
        legend: {
            position: 'top',
        },
    },
    scales: {
        x: {
            title: {
                display: true,
                text: 'Month',
            },
        },
        y: {
            title: {
                display: true,
                text: 'Charge Amount (PHP)',
            },
            beginAtZero: true,
        },
    },
},
});
}

async function populateDueTenants() {
const data = await fetchTenantData();

const dueTenants = data.tenantStatus.dueTenants;
const dueTenantsTableBody = document.querySelector('#dueTenantsTable tbody');

dueTenantsTableBody.innerHTML = dueTenants.map(tenant => `
<tr>
    <td>${tenant.name}</td>
    <td>${tenant.payment_amount}</td>
    <td>${tenant.payment_status}</td>
</tr>
`).join('');
}

populateCards();
renderOccupancyChart();
renderMonthlyIncomeChart();
renderMaintenanceChart();
populateDueTenants();


document.getElementById('logoutBtn').onclick = function () {
    window.location.href = 'login.html';
};