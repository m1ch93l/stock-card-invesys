<?php
include 'database.php';

function executePreparedStatement($conn, $query, $params, $types = "")
{
    $stmt = $conn->prepare($query);
    if ($stmt) {
        if ($types != "") {
            $stmt->bind_param($types, ...$params);
        }
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // academic year add
    if (isset($_POST['stock-add'])) {
        $item        = mysqli_real_escape_string($conn, $_POST['item']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $uom         = mysqli_real_escape_string($conn, $_POST['uom']);
        $stockno     = mysqli_real_escape_string($conn, $_POST['stockno']);
        $reorder     = mysqli_real_escape_string($conn, $_POST['reorder']);
        $query       = "INSERT INTO item (item,description,unit_measure,stock_no,re_order) VALUES (?,?,?,?,?)";
        $params      = [$item, $description, $uom, $stockno, $reorder];
        if (executePreparedStatement($conn, $query, $params, "sssss")) {
            header("Location: index.php");
        }
    }
    // academic year update status
    // if (isset($_POST['update-status'])) {
    //     $academicYearStatus = mysqli_real_escape_string($conn, $_POST['academicStatus']);
    //     $primaryId          = mysqli_real_escape_string($conn, $_POST['primaryId']);
    //     $query              = "UPDATE academic_year SET status = ? WHERE id = ?";
    //     $params             = [$academicYearStatus, $primaryId];
    //     if (executePreparedStatement($conn, $query, $params, "ii")) {
    //         header("Location: academic_year.php");
    //     }
    // }
    // // courses.php add
    // if (isset($_POST['add-courses'])) {
    //     $course  = mysqli_real_escape_string($conn, $_POST['course']);
    //     $level   = mysqli_real_escape_string($conn, $_POST['level']);
    //     $section = mysqli_real_escape_string($conn, $_POST['section']);
    //     $query   = "INSERT INTO courses (course, course_code, level, section) VALUES (?, ?, ?, ?)";
    //     $params  = [$course, $course, $level, $section];
    //     if (executePreparedStatement($conn, $query, $params, "ssss")) {
    //         header("Location: courses.php");
    //     }
    // }
    // // course.php edit
    // if (isset($_POST['submit-edit-course'])) {
    //     $id           = mysqli_real_escape_string($conn, $_POST['course_id']);
    //     $edit_course  = mysqli_real_escape_string($conn, $_POST['edit-course']);
    //     $edit_level   = mysqli_real_escape_string($conn, $_POST['edit-level']);
    //     $edit_section = mysqli_real_escape_string($conn, $_POST['edit-section']);
    //     $query        = "UPDATE courses SET course = ?, course_code = ?, level = ?, section = ? WHERE id = ?";
    //     $params       = [$edit_course, $edit_course, $edit_level, $edit_section, $id];
    //     if (executePreparedStatement($conn, $query, $params, "ssssi")) {
    //         header("Location: courses.php");
    //     }
    // }
}
?>