<?php
function getUserDetails($conn, $username)
{
    $query = "SELECT * FROM users WHERE username = ?";
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

    if ($userDetails && password_verify($password, $userDetails['password'])) {
        // Password is correct
        // Perform additional actions or redirect as needed
        header("Location: index.php");
    } else {
        // Incorrect username or password
        // Handle authentication failure (e.g., display an error message)
        echo "Incorrect username or password";
    }
}

?>