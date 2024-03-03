<?php
// Establish a connection to your MySQL database
include 'database.php';

// Check if the filter condition is provided in the AJAX request, otherwise use a default filter
$filterCondition = isset($_POST['filter']) ? $_POST['filter'] : 'all';

// Use a prepared statement to prevent SQL injection
if ($filterCondition == 'all') {
    $sql  = "SELECT * FROM item";
    $stmt = $conn->prepare($sql);
} else {
    // Modify this based on your specific filtering conditions
    $sql  = "SELECT * FROM item WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filterCondition);
}

// Execute the prepared statement
$stmt->execute();
$result = $stmt->get_result();

if ($result) {

    while ($row = $result->fetch_assoc()) {
        echo "
    <div class='row mb-1 text-white bg-success'>
        <div class='col-6 mt-2'>
            <p class='border-bottom text-capitalize'><b>Item: </b>{$row['item']}</p>
            <p class='border-bottom text-capitalize'><b>Description: </b>{$row['description']}</p>
            <p class='border-bottom text-capitalize'><b>Unit of Measurement: </b>{$row['unit_measure']}</p>
        </div>
        <div class='col-6 mt-2'>
            <p class='border-bottom text-capitalize'><b>Stock No: </b>{$row['stock_no']}</p>
            <p class='border-bottom text-capitalize'><b>Re-order point: </b>{$row['re_order']}</p>
            <p class='border-bottom text-capitalize'><b>Actual Delivery: </b>{$row['actual_delivery']}</p>
        </div>
    </div>";
    }

    echo "</table>";
} else {
    echo "Error executing query: " . $stmt->error;
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();
?>