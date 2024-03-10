<?php
include 'database.php';

$filterCondition = isset($_POST['filter']) ? $_POST['filter'] : 'all';

if ($filterCondition == 'all') {
    $sql  = "SELECT * FROM released_item";
    $stmt = $conn->prepare($sql);
} else {
    // Modify this based on your specific filtering conditions
    $sql  = "SELECT item.id as iid, item, actual_delivery, SUM(balance_quantity) as remain FROM item JOIN released_item ON item.id=released_item.item_id WHERE DATE(date) = ? AND archive_status = 1 GROUP BY item.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filterCondition);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    echo "<table class='table table-bordered text-center' border='1'>
    <thead>
        <tr>
            <th width='250' class='fs-3'>Items Released</th>
        </tr>
    </thead>";

    while ($row = $result->fetch_assoc()) {
        echo "
    <tbody>
        <tr>
            <td><a href='archiveView.php?getview={$row['iid']}'>{$row['item']}</a></td>
        </tr>
    </tbody>";
    }

    echo "</table>";
} else {
    echo "Error executing query: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>