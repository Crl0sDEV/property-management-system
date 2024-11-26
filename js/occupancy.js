const predefinedUnitColors = [
    "Red", "Angel Blush", "Light Blue", "Blue Green", "Dark Blue",
    "Gold", "Orange", "Green Nile", "Pink", "Yellow Ribbon",
    "Light Green", "Orcher", "Blue", "Light Pink", "Light Yellow"
];

// Map of unit color names to background color codes
const colorMap = {
    'Red': 'red',
    'Angel Blush': '#F7D1D1',
    'Light Blue': '#ADD8E6',
    'Blue Green': '#0D98BA',
    'Dark Blue': '#00008B',
    'Gold': '#FFD700',
    'Orange': '#FFA500',
    'Green Nile': '#3E5F4F',
    'Pink': '#FFC0CB',
    'Yellow Ribbon': '#F7F700',
    'Light Green': '#90EE90',
    'Orcher': '#9C6C4F',
    'Blue': '#0000FF',
    'Light Pink': '#FFB6C1',
    'Light Yellow': '#FFFFE0'
};

let tenants = []; // Tenant data from the server

async function fetchOccupancyData() {
try {
    const response = await fetch('php/occupancy/occupancy.php'); // PHP script to fetch tenant data
    tenants = await response.json();
    loadOccupancy();
} catch (error) {
    console.error("Error fetching occupancy data:", error);
}
}

function loadOccupancy() {
const occupancyTable = document.getElementById('occupancyTable').getElementsByTagName('tbody')[0];
occupancyTable.innerHTML = '';

predefinedUnitColors.forEach(color => {
    const tenant = tenants.find(tenant => tenant.unit_color === color);
    const colorCode = colorMap[color] || 'white';
    const status = tenant ? "Occupied" : "Available";
    const name = tenant ? tenant.name : "";

    const newRow = occupancyTable.insertRow();
    newRow.innerHTML = `
        <td>${name}</td>
        <td style="background-color: ${colorCode};">${color}</td>
        <td>${status}</td>
    `;
});
}

document.getElementById('logoutBtn').onclick = function() {
    window.location.href = 'login.html';
};

window.onload = fetchOccupancyData;