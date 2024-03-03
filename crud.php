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
    // item add
    if (isset($_POST['stock-add'])) {
        $item           = mysqli_real_escape_string($conn, $_POST['item']);
        $description    = mysqli_real_escape_string($conn, $_POST['description']);
        $uom            = mysqli_real_escape_string($conn, $_POST['uom']);
        $stockno        = mysqli_real_escape_string($conn, $_POST['stockno']);
        $reorder        = mysqli_real_escape_string($conn, $_POST['reorder']);
        $actualDelivery = mysqli_real_escape_string($conn, $_POST['actualDelivery']);
        $query          = "INSERT INTO item (item,description,unit_measure,stock_no,re_order,actual_delivery) VALUES (?,?,?,?,?,?)";
        $params         = [$item, $description, $uom, $stockno, $reorder, $actualDelivery];
        if (executePreparedStatement($conn, $query, $params, "ssssss")) {
            header("Location: index.php");
        }
    }
    // release item add
    if (isset($_POST['release-add'])) {
        $itemId    = mysqli_real_escape_string($conn, $_POST['itemId']);
        $refer     = mysqli_real_escape_string($conn, $_POST['refer']);
        $releaseBy = mysqli_real_escape_string($conn, $_POST['releasedBy']);
        $balance   = mysqli_real_escape_string($conn, $_POST['balance']);
        $query     = "INSERT INTO released_item (item_id,reference,release_to,balance_quantity) VALUES (?,?,?,?)";
        $params    = [$itemId, $refer, $releaseBy, $balance];
        if (executePreparedStatement($conn, $query, $params, "isss")) {
            header("Location: index.php");
        }
    }
}
// user login
function getUserDetails($conn, $username)
{
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt  = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }

    return null;
}
if (isset($_POST['user-login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch user details based on the provided username
    $userDetails = getUserDetails($conn, $username);

    if ($userDetails && $userDetails['password'] === $password) {
        // Password is correct
        // Perform additional actions or redirect as needed
        header("Location: index.php");
    } else {
        // Incorrect username or password
        // Handle authentication failure (e.g., display an error message)
        echo "<script>alert('Incorrect Credentials'); window.location.href = document.referrer;</script>";
    }
}

?>