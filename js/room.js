let currentRow;

        // Predefined unit colors
        const unitColors = [
            'Red', 'Angel Blush', 'Light Blue', 'Blue Green', 'Dark Blue', 'Gold',
            'Orange', 'Green Nile', 'Pink', 'Yellow Ribbon', 'Light Green', 'Orcher',
            'Blue', 'Light Pink', 'Light Yellow'
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

        async function fetchRoomData() {
            try {
                const response = await fetch('php/room/room.php');
                const rooms = await response.json();
                loadRoomData(rooms);
            } catch (error) {
                console.error("Error fetching room data:", error);
            }
        }

        function loadRoomData(rooms) {
            const roomTable = document.getElementById('roomTable').getElementsByTagName('tbody')[0];
            roomTable.innerHTML = '';  // Clear existing table data

            // Display all predefined unit colors
            unitColors.forEach(color => {
                // Find tenant that matches this unit color
                const tenant = rooms.find(room => room.unit_color === color);
                const colorCode = colorMap[color] || 'white'; // Default to white if color not found

                const newRow = roomTable.insertRow();
                newRow.innerHTML = `
                    <td>${tenant ? tenant.name : ''}</td>
                    <td style="background-color: ${colorCode};">${color}</td>
                    <td>${tenant ? tenant.damage_description : ''}</td>
                    <td class="charge-amount">${tenant ? `₱${tenant.charge_amount}` : '₱0'}</td>
                    <td>
                        <button class="btn btn-charge" ${tenant ? '' : 'disabled'} onclick="openChargeModal('${tenant ? tenant.name : ''}', '${color}', ${tenant ? tenant.charge_amount : 0}, this)">
                            <i class="fa-solid fa-peso-sign"></i> Charge
                        </button>
                    </td>
                `;
            });
        }

        function openChargeModal(name, unitColor, currentCharge, btnElement) {
            if (name) {
                document.getElementById('charge-details').textContent = `Tenant: ${name}, Unit Color: ${unitColor}`;
                document.getElementById('charge-amount').value = currentCharge;
                currentRow = btnElement.closest("tr");
                document.getElementById('chargeModal').style.display = "block";
            }
        }

        function confirmCloseModal() {
            document.getElementById('confirmCloseModal').style.display = "none";
            document.getElementById('chargeModal').style.display = "none";
        }

        function closeChargeModal() {
            document.getElementById('chargeModal').style.display = "none";
        }

        function closeConfirmationModal() {
            document.getElementById('confirmCloseModal').style.display = "none";
            document.getElementById('chargeModal').style.display = "block";
        }

        async function applyCharge() {
            const chargeAmount = document.getElementById('charge-amount').value;
            const damageDescription = document.getElementById('damage-description').value;
            const tenantDetails = document.getElementById('charge-details').textContent;
            const [name, unitColor] = tenantDetails.replace("Tenant: ", "").split(", Unit Color: ");

            if (chargeAmount >= 0) {
                currentRow.querySelector(".charge-amount").textContent = `₱${chargeAmount}`;
                currentRow.cells[2].textContent = damageDescription;

                try {
                    const response = await fetch('php/room/saveCharge.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            name: name.trim(),
                            unit_color: unitColor.trim(),
                            damage_description: damageDescription,
                            charge_amount: chargeAmount
                        })
                    });
                    const result = await response.json();
                    if (result.status === "success") {
                        alert(result.message);
                        closeChargeModal();
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    console.error("Error saving charge:", error);
                    alert("An error occurred while saving the charge.");
                }
            } else {
                alert("Please enter a valid charge amount.");
            }
        }

        async function applyChargeToAdmin() {
            const chargeAmount = document.getElementById('charge-amount').value;
            const damageDescription = document.getElementById('damage-description').value;
            const tenantDetails = document.getElementById('charge-details').textContent;
            const [name, unitColor] = tenantDetails.replace("Tenant: ", "").split(", Unit Color: ");

            if (chargeAmount >= 0) {
                try {
                    const response = await fetch('php/rooom/saveAdminCharge.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            name: name.trim(),
                            unit_color: unitColor.trim(),
                            damage_description: damageDescription,
                            charge_amount: chargeAmount
                        })
                    });
                    const result = await response.json();
                    if (result.status === "success") {
                        alert(result.message);
                        closeChargeModal();
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    console.error("Error saving charge to admin:", error);
                    alert("An error occurred while applying charge to admin.");
                }
            } else {
                alert("Please enter a valid charge amount.");
            }
        }

        document.getElementById('logoutBtn').onclick = function() {
            window.location.href = 'login.html';
        };
        // Load room data when the page loads
        window.onload = fetchRoomData;