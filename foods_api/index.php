<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "rest_api";
// $db_user = "okybxfzl_root_api";
// $db_pass = "Rootapi123@";
// $db_name = "okybxfzl_api";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Cek apakah ada parameter "category" dalam URL
    if (isset($_GET['category'])) {
        $category = $conn->real_escape_string($_GET['category']);
        $sql = "SELECT * FROM ms_foods WHERE category = '$category'";
    } else {
        $sql = "SELECT * FROM ms_foods";
    }

    $result = $conn->query($sql);

    $foods = array();
    while ($row = $result->fetch_assoc()) {
        $food = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'category' => $row['category'],
            'image' => 'image/' . $row['image'] // File path based on folder
            // 'image' => $row['image'] // File path based on folder
        );
        $foods[] = $food;
    }

    header('Content-Type: application/json');
    echo json_encode($foods);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('message' => 'Metode yang diperbolehkan hanya GET.'));
}

$conn->close();
