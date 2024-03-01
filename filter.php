<?php
// Establish a connection to your MySQL database
include 'database.php';

// Get the selected filter condition from the AJAX request
$filterCondition = $_POST['filter'];

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
    // Generate HTML for the filtered data
    echo "<table class='table table-bordered text-center' border='1'>
        <tr>
            <th>Date</th>
            <th>Reference</th>
            <th>
                <div class='border-bottom'>Receipt</div>
                <div>Quantity</div>
            </th>
            <th colspan='2' class='text-center'>
                <div class='row'>
                    <div class='çol-12'>Issue</div>
                </div>
                <div class='row'>
                    <div class='col-6 border-end border-top'>Quantity</div>
                    <div class='col-6 border-top'>Office</div>
                </div>
            </th>
            <th>
                <div class='border-bottom'>Balance</div>
                <div>Quantity</div>
            </th>
            <th>No. of Days</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['date']}</td>
            <td>{$row['item']}</td>
            <td>{$row['description']}</td>
        </tr>";
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