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
    $sql  = "SELECT item, actual_delivery, SUM(balance_quantity) as remain FROM item JOIN released_item ON item.id=released_item.item_id WHERE item.id = ? GROUP BY item.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filterCondition);
}

// Execute the prepared statement
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    // Generate HTML for the filtered data
    echo "<table class='table table-bordered text-center' border='1'>
    <thead>
        <tr>
            <th>Actual Delivery</th>
            <th>Remaining Quantity</th>
        </tr>
    </thead>";

    while ($row = $result->fetch_assoc()) {
        $remaining = $row['actual_delivery'] - $row['remain'];
        echo "
    <tbody>
        <tr>
            <td class='fw-bold'>{$row['actual_delivery']}</td>
            <td class='text-danger fw-bold'>{$remaining}</td>
        </tr>
    </tbody>";
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