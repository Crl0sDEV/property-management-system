<?php
header('Content-Type: application/json');
include('connection.php');

$date = $_POST['date'];
$name = $_POST['name'];
$birthday = $_POST['birthday'];
$birthplace = $_POST['birthplace'];
$nationality = $_POST['nationality'];
$civil_status = $_POST['civil_status'];
$previous_address = $_POST['previous_address'];
$province = $_POST['province'];
$occupation = $_POST['occupation'];
$address_of_workplace = $_POST['address_of_workplace'];
$phone_number = $_POST['phone_number'];
$email_address = $_POST['email_address'];
$emergency_contact_number = $_POST['emergency_contact_number'];
$spouse_name = $_POST['spouse_name'];
$spouse_occupation = $_POST['spouse_occupation'];
$spouse_workplace_address = $_POST['spouse_workplace_address'];
$tenant_phone_number = $_POST['tenant_phone_number'];
$number_of_tenants = $_POST['number_of_tenants'];
$unit_color = $_POST['unit_color'];

$tenant1_name = $_POST['tenant1_name'];
$tenant1_age = $_POST['tenant1_age'];
$tenant1_relationship = $_POST['tenant1_relationship'];
$tenant2_name = $_POST['tenant2_name'];
$tenant2_age = $_POST['tenant2_age'];
$tenant2_relationship = $_POST['tenant2_relationship'];
$tenant3_name = $_POST['tenant3_name'];
$tenant3_age = $_POST['tenant3_age'];
$tenant3_relationship = $_POST['tenant3_relationship'];
$tenant4_name = $_POST['tenant4_name'];
$tenant4_age = $_POST['tenant4_age'];
$tenant4_relationship = $_POST['tenant4_relationship'];
$tenant5_name = $_POST['tenant5_name'];
$tenant5_age = $_POST['tenant5_age'];
$tenant5_relationship = $_POST['tenant5_relationship'];

$sql = "INSERT INTO tenant (
    date, name, birthday, birthplace, nationality, civil_status, previous_address, province,
    occupation, address_of_workplace, phone_number, email_address, emergency_contact_number,
    spouse_name, spouse_occupation, spouse_workplace_address, tenant_phone_number,
    number_of_tenants, unit_color,
    tenant1_name, tenant1_age, tenant1_relationship,
    tenant2_name, tenant2_age, tenant2_relationship,
    tenant3_name, tenant3_age, tenant3_relationship,
    tenant4_name, tenant4_age, tenant4_relationship,
    tenant5_name, tenant5_age, tenant5_relationship
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param(
        "ssssssssssssssssssssssssssssssssss",
        $date, $name, $birthday, $birthplace, $nationality, $civil_status, $previous_address, $province,
        $occupation, $address_of_workplace, $phone_number, $email_address, $emergency_contact_number,
        $spouse_name, $spouse_occupation, $spouse_workplace_address, $tenant_phone_number,
        $number_of_tenants, $unit_color,
        $tenant1_name, $tenant1_age, $tenant1_relationship,
        $tenant2_name, $tenant2_age, $tenant2_relationship,
        $tenant3_name, $tenant3_age, $tenant3_relationship,
        $tenant4_name, $tenant4_age, $tenant4_relationship,
        $tenant5_name, $tenant5_age, $tenant5_relationship
    );

    if ($stmt->execute()) {
    
        echo json_encode(["status" => "success"]);
    } else {
    
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    
    $stmt->close();
} else {
    
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
