let currentTenantId = '';
        let currentStatus = '';
    
        document.addEventListener("DOMContentLoaded", function() {
            const tenantTableBody = document.getElementById('tenant-table-body');
        
            fetch('php/transact/transact.php')
                .then(response => response.json())
                .then(data => {
                    tenantTableBody.innerHTML = ''; 
        
                    data.forEach(tenant => {
                        const statusClass = tenant.status === 'Paid' ? 'status-paid' : 'status-due';
                        
                        const row = document.createElement('tr');
                        row.innerHTML = ` 
                            <td>${tenant.name}</td>
                            <td>₱${tenant.amount}</td>
                            <td>
                                <span class="${statusClass}" id="status-${tenant.id}">${tenant.status}</span>
                            </td>
                            <td>
                                <button class="action-btn edit" onclick="openEditAmountModal(${tenant.id}, ${tenant.amount}, '${tenant.status}')"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                <button class="action-btn view-details" onclick="viewPaymentHistory(${tenant.id}, '${tenant.name}')"><i class="fas fa-info-circle"></i> View Details</button>
                            </td>
                        `;
                        tenantTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching tenant data:', error));
        });
    
        function openEditAmountModal(tenantId, currentAmount, tenantStatus) {
            currentTenantId = tenantId;
            currentStatus = tenantStatus;
        
            document.getElementById('newAmount').value = currentAmount;
            document.getElementById('statusSelect').value = tenantStatus;
        
            document.getElementById('paymentModal').style.display = 'block';
        }
    
        function updateAmount() {
            const newAmount = document.getElementById('newAmount').value;
            const selectedStatus = document.getElementById('statusSelect').value;
    
            if (newAmount && currentTenantId) {
                const formData = new FormData();
                formData.append('tenant_id', currentTenantId);
                formData.append('new_amount', newAmount);
                formData.append('new_status', selectedStatus);
    
                fetch('php/transact/update-payment-amount.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const statusSpan = document.getElementById(`status-${currentTenantId}`);
                        statusSpan.textContent = selectedStatus;
                        statusSpan.className = selectedStatus === 'Paid' ? 'status-paid' : 'status-due';
    
                        alert('Payment amount and status updated successfully!');
                        closePaymentModal();
                        location.reload();
                    } else {
                        alert('Failed to update payment details.');
                    }
                })
                .catch(error => console.error('Error updating payment:', error));
            } else {
                alert('Please enter a valid amount.');
            }
        }
    
        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }
    
        function viewPaymentHistory(tenantId, tenantName) {
            const historyTableBody = document.getElementById('history-table-body');
            historyTableBody.innerHTML = '';
            document.getElementById('history-tenant-name').textContent = tenantName;

            fetch(`php/transact/fetch-payment-history.php?tenant_id=${tenantId}`)
                .then(response => response.json())
                .then(historyData => {
                    if (historyData.length === 0) {
                        historyTableBody.innerHTML = '<tr><td colspan="3">No history available</td></tr>';
                    } else {
                        historyData.forEach(entry => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${entry.payment_date}</td>
                                <td>₱${entry.amount}</td>
                                <td>${entry.status}</td>
                            `;
                            historyTableBody.appendChild(row);
                        });
                    }

                    document.getElementById('historyModal').style.display = 'block';
                })
                .catch(error => console.error('Error fetching payment history:', error));
        }
    
        function closeHistoryModal() {
            document.getElementById('historyModal').style.display = 'none';
        }

        document.getElementById('logoutBtn').onclick = function() {
            window.location.href = 'login.html';
        };