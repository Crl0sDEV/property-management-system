<?php
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$date = $data['date'];
$name = $data['name'];
$birthday = $data['birthday'];
$birthplace = $data['birthplace'];
$nationality = $data['nationality'];
$civil_status = $data['civil_status'];
$previous_address = $data['previous_address'];
$province = $data['province'];
$occupation = $data['occupation'];
$address_of_workplace = $data['address_of_workplace'];
$phone_number = $data['phone_number'];
$email_address = $data['email_address'];
$emergency_contact_number = $data['emergency_contact_number'];
$spouse_name = $data['spouse_name'];
$spouse_occupation = $data['spouse_occupation'];
$spouse_workplace_address = $data['spouse_workplace_address'];
$tenant_phone_number = $data['tenant_phone_number'];
$number_of_tenants = $data['number_of_tenants'];
$unit_color = $data['unit_color'];

$sql = "UPDATE tenant SET 
            date = '$date',
            name = '$name',
            birthday = '$birthday',
            birthplace = '$birthplace',
            nationality = '$nationality',
            civil_status = '$civil_status',
            previous_address = '$previous_address',
            province = '$province',
            occupation = '$occupation',
            address_of_workplace = '$address_of_workplace',
            phone_number = '$phone_number',
            email_address = '$email_address',
            emergency_contact_number = '$emergency_contact_number',
            spouse_name = '$spouse_name',
            spouse_occupation = '$spouse_occupation',
            spouse_workplace_address = '$spouse_workplace_address',
            tenant_phone_number = '$tenant_phone_number',
            number_of_tenants = '$number_of_tenants',
            unit_color = '$unit_color'
            WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
