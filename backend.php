<?php
error_reporting(E_ERROR | E_PARSE);

$link = mysqli_connect("localhost", "root", "", "studentinfo");

$status = 'OK';
$content = [];

if (mysqli_connect_errno()) {
    $status = 'ERROR';
    $content = mysqli_connect_error();
}

$query = "SELECT * FROM student"; // Removed the id filter

if ($result = mysqli_query($link, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $content[] = $row;
    }
}

$data = ["status" => $status, "content" => $content];

header('Content-type: application/json');
echo json_encode($data);
?>
