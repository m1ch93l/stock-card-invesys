<?php
// Establish a connection to your MySQL database
include 'database.php';

// Check if the filter condition is provided in the AJAX request, otherwise use a default filter
$filterCondition = isset($_POST['filter']) ? $_POST['filter'] : 'all';

// Use a prepared statement to prevent SQL injection
if ($filterCondition == 'all') {
    $sql  = "SELECT * FROM release_item";
    $stmt = $conn->prepare($sql);
} else {
    // Modify this based on your specific filtering conditions
    $sql  = "SELECT * FROM released_item WHERE item_id = ?";
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
            <th>Date</th>
            <th>Reference</th>
            <th>Recepient</th>
            <th>
                <div class='border-bottom'>Balance</div>
                <div>Quantity</div>
            </th>
        </tr>
    </thead>";

    while ($row = $result->fetch_assoc()) {
        echo "
    <tbody>
        <tr>
            <td>{$row['date']}</td>
            <td>{$row['reference']}</td>
            <td>{$row['release_to']}</td>
            <td class='text-danger fw-bold'>{$row['balance_quantity']}</td>
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