<?php
// Establish a connection to your MySQL database
include 'database.php';

// Check if the filter condition is provided in the AJAX request, otherwise use a default filter
$filterCondition = isset($_POST['filter']) ? $_POST['filter'] : 'all';

// Use a prepared statement to prevent SQL injection
if ($filterCondition == 'all') {
    $sql  = "SELECT * FROM archive";
    $stmt = $conn->prepare($sql);
} else {
    // Modify this based on your specific filtering conditions
    $sql  = "SELECT * FROM archive WHERE item_id = ?";
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
            <th width='250'>Date</th>
            <th width='250'>Items</th>
        </tr>
    </thead>";

    while ($row = $result->fetch_assoc()) {
        $dateString    = $row['date'];
        $timestamp     = strtotime($dateString);
        $formattedDate = date("F, j Y g:i a", $timestamp);
        echo "
    <tbody>
        <tr>
            <td>{$formattedDate}</td>
            <td>{$row['']}</td>
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