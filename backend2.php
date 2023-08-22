<?php
$link = mysqli_connect("localhost", "root", "", "studentinfo");

$status = 'OK';
$content = null;

if (mysqli_connect_errno()) {
    $status = 'ERROR';
    $content = mysqli_connect_error();
} else {
    if (isset($_GET['id'])) {
        $studentId = $_GET['id'];
        $query = "SELECT * FROM student WHERE ID = $studentId";
        
        if ($result = mysqli_query($link, $query)) {
            if ($row = mysqli_fetch_assoc($result)) {
                $content = $row;
            }
        }
    }

    if (isset($_GET['delete'])) {
        $studentId = $_GET['delete'];
        $query = "SELECT status FROM student WHERE ID = $studentId";

        if ($result = mysqli_query($link, $query)) {
            if ($row = mysqli_fetch_assoc($result)) {
                $status = $row['status'];

                if ($status === "passed") {
                    $deleteQuery = "DELETE FROM student WHERE ID = $studentId";
                    if (mysqli_query($link, $deleteQuery)) {
                        $content = "Student deleted successfully.";
                    } else {
                        $status = "ERROR";
                        $content = "Error deleting student.";
                    }
                }

                if ($status === "failed") {
                    $deleteQuery = "DELETE FROM student WHERE ID = $studentId";
                    mysqli_query($link, $deleteQuery);
                }
                
                else {
                    $content = "Student status is not 'passed'.";
                }
            }
        }
    }
}

$data = ["status" => $status, "content" => $content];

header('Content-type: application/json');
echo json_encode($data);
?>
