async function fetchFinanceData() {
    try {
        const incomeResponse = await fetch('php/finance/fetchMonthlyIncome.php');
        if (!incomeResponse.ok) throw new Error("Failed to fetch income data");
        const incomeData = await incomeResponse.json();
        loadMonthlyIncomeData(incomeData);

        const chargeHistoryResponse = await fetch('php/finance/fetchChargeHistory.php');
        if (!chargeHistoryResponse.ok) throw new Error("Failed to fetch charge history data");
        const chargeHistoryData = await chargeHistoryResponse.json();
        loadChargeHistoryData(chargeHistoryData);
    } catch (error) {
        console.error("Error fetching finance data:", error);
    }
}

function loadMonthlyIncomeData(incomeData) {
    const tableBody = document.getElementById('monthlyIncomeTable').querySelector('tbody');
    tableBody.innerHTML = '';  // Clear any previous data

    let totalIncome = 0;

    incomeData.forEach(item => {
        const row = tableBody.insertRow();
        row.innerHTML = `
            <td>${item.tenant_name}</td>
            <td>${item.unit_color}</td>
            <td>₱${parseFloat(item.amount).toFixed(2)}</td>
        `;
        totalIncome += parseFloat(item.amount);
    });

    // Update the total monthly income
    document.getElementById('totalMonthlyIncome').textContent = `Total Monthly Income: ₱${totalIncome.toFixed(2)}`;
}

        function loadMaintenanceData(maintenanceData) {
            const tableBody = document.getElementById('maintenanceDetailsTable').querySelector('tbody');
            tableBody.innerHTML = '';

            let totalCost = 0;
            maintenanceData.forEach(item => {
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${item.item_name}</td>
                    <td>₱${item.price}</td>
                    <td>${item.quantity}</td>
                    <td>₱${item.total}</td>
                `;
                totalCost += parseFloat(item.total);
            });

            document.getElementById('totalMaintenanceCost').textContent = `Total Maintenance Cost: ₱${totalCost}`;
        }

        function loadChargeHistoryData(chargeHistoryData) {
            const tableBody = document.getElementById('chargeHistoryTable').querySelector('tbody');
            tableBody.innerHTML = '';

            chargeHistoryData.forEach(item => {
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${item.tenant_name}</td>
                    <td>${item.unit_color}</td>
                    <td>₱${item.charge_amount}</td>
                    <td>${item.damage_description}</td>
                    <td>${item.change_date}</td>
                `;
            });
        }

        function printIncomeReport() {
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Monthly Income Report</title></head><body>');
            printWindow.document.write('<h1>Monthly Income Report</h1>');
            printWindow.document.write(document.getElementById('monthlyIncomeTable').outerHTML);
            printWindow.document.write(`<p><strong>${document.getElementById('totalMonthlyIncome').textContent}</strong></p>`);
            printWindow.document.close();
            printWindow.print();
        }

        function printMaintenanceReport() {
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Monthly Maintenance Report</title></head><body>');
            printWindow.document.write('<h1>Monthly Maintenance Report</h1>');
            printWindow.document.write(document.getElementById('maintenanceDetailsTable').outerHTML);
            printWindow.document.write(`<p><strong>${document.getElementById('totalMaintenanceCost').textContent}</strong></p>`);
            printWindow.document.close();
            printWindow.print();
        }

        document.addEventListener("DOMContentLoaded", () => {
            loadMaintenanceDetails();
        });
        
        function loadMaintenanceDetails() {
            fetch("php/finance/fetchMaintenanceDetails.php")
                .then((response) => response.json())
                .then((data) => {
                    const tableBody = document.querySelector("#maintenanceDetailsTable tbody");
                    let totalCost = 0;
        
                    tableBody.innerHTML = ""; // Clear existing rows
        
                    data.forEach((entry) => {
                        const row = document.createElement("tr");
        
                        row.innerHTML = `
                            <td>${entry.tenant_name || ""}</td>
                            <td>${entry.unit_color || ""}</td>
                            <td>${entry.damage_description || ""}</td>
                            <td>₱${parseFloat(entry.charge_amount).toFixed(2)}</td>
                        `;
        
                        tableBody.appendChild(row);
        
                        totalCost += parseFloat(entry.charge_amount);
                    });
        
                    // Update total cost
                    document.getElementById("totalMaintenanceCost").textContent = `Total Maintenance Cost: ₱${totalCost.toFixed(2)}`;
                })
                .catch((error) => {
                    console.error("Error fetching maintenance details:", error);
                });
        }        

        document.getElementById('logoutBtn').onclick = function() {
            window.location.href = 'login.html';
        }

        window.onload = fetchFinanceData;