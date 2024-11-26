<?php
header('Content-Type: application/json');
include 'connection.php'; // Replace with your connection file

// Query to count active, archived, and occupied tenants
$query = "SELECT 
    (SELECT COUNT(*) FROM tenant) AS active, 
    (SELECT COUNT(*) FROM archived_tenant) AS archived,
    (SELECT COUNT(*) FROM tenant WHERE status = 'Occupied') AS occupied";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Add max units to the response for frontend calculations
$data['maxUnits'] = 15;

// Query to calculate total monthly income
$incomeQuery = "SELECT 
                    DATE_FORMAT(payment_date, '%Y-%m') AS month, 
                    SUM(amount) AS total_income 
                FROM payment_history 
                WHERE status = 'paid' 
                GROUP BY DATE_FORMAT(payment_date, '%Y-%m') 
                ORDER BY month ASC";

$incomeResult = mysqli_query($conn, $incomeQuery);

$monthlyIncome = [];
if ($incomeResult && mysqli_num_rows($incomeResult) > 0) {
    while ($row = mysqli_fetch_assoc($incomeResult)) {
        $monthlyIncome[] = $row;
    }
}
$data['monthlyIncome'] = $monthlyIncome;

// Query to fetch tenants with "due" payment status
$dueQuery = "SELECT name, payment_amount, payment_status 
             FROM tenant 
             WHERE payment_status = 'due'";

$dueResult = mysqli_query($conn, $dueQuery);

$dueTenants = [];
if ($dueResult && mysqli_num_rows($dueResult) > 0) {
    while ($row = mysqli_fetch_assoc($dueResult)) {
        $dueTenants[] = $row;
    }
}
$data['dueTenants'] = $dueTenants;

// Query to calculate total maintenance charges grouped by month
$maintenanceQuery = "SELECT 
                        DATE_FORMAT(charge_date, '%Y-%m') AS month, 
                        SUM(charge_amount) AS total_charge 
                     FROM admin_charge_log 
                     GROUP BY DATE_FORMAT(charge_date, '%Y-%m') 
                     ORDER BY month ASC";

$maintenanceResult = mysqli_query($conn, $maintenanceQuery);

$monthlyMaintenance = [];
if ($maintenanceResult && mysqli_num_rows($maintenanceResult) > 0) {
    while ($row = mysqli_fetch_assoc($maintenanceResult)) {
        $monthlyMaintenance[] = $row;
    }
}
$data['monthlyMaintenance'] = $monthlyMaintenance;

echo json_encode(['tenantStatus' => $data]);
?>
