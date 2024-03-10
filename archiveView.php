<?php
session_start();
if (isset($_SESSION['admin'])) {

    require_once 'header.php';

    ?>

    <body>
        <div class="container-lg shadow-sm">
            <div class="text-center h1 mono">Stock Card System</div>

            <div class="row mb-3">
                <div class="col-1 text-center p-0 m-0">
                    <img src="image/DA.jpg" alt="logo" width="50" height="50">
                </div>
                <div class="col-10 p-0">
                    <p class="ps-5 m-0">Department of Agriculture</p>
                    <p class="ps-5 m-0"><strong>Regional Field Office No. 5</strong></p>
                </div>
                <div class="col-1 text-center fs-3">
                    <a class="text-decoration-none text-success" type="button" href="logout.php">
                        <span><i class='bx bx-log-out'></i></span>
                    </a>
                </div>
            </div>
            <div class="row p-2" style="background-color: #D5640E">
                <div class="col-1">
                    <a href="archive.php" type="button" class="btn btn-sm fw-bold fs-5 text-white"><i
                            class='bx bx-arrow-back'></i></a>
                </div>
            </div>

            <?php

            require_once 'database.php';

            $getview = $_GET['getview'];

            // Use a prepared statement to prevent SQL injection
            $query = "SELECT id, item, description, unit_measure, stock_no, re_order, actual_delivery FROM item WHERE id = ? ";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $getview); // Assuming 'id' is an integer, adjust the type accordingly
        
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {

                while ($row = $result->fetch_assoc()) { ?>

                    <!-- Display the filtered data here -->
                    <div class="row mb-1 text-white bg-success mt-2 mb2">
                        <div class="col-6 mt-2">
                            <p class="border-bottom text-capitalize"><b>Item: </b>
                                <?php echo $row['item']; ?>
                            </p>
                            <p class="border-bottom text-capitalize"><b>Description: </b>
                                <?php echo $row['description']; ?>
                            </p>
                            <p class="border-bottom text-capitalize"><b>Unit of Measurement: </b>
                                <?php echo $row['unit_measure']; ?>
                            </p>
                        </div>
                        <div class="col-6 mt-2">
                            <p class="border-bottom text-capitalize"><b>Stock No: </b>
                                <?php echo $row['stock_no']; ?>
                            </p>
                            <p class="border-bottom text-capitalize"><b>Re-order point: </b>
                                <?php echo $row['re_order']; ?>
                            </p>
                            <p class="border-bottom text-capitalize"><b>Actual Delivery: </b>
                                <?php echo $row['actual_delivery']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-2"">
                    <div class=" col-9">

                        <table class="table table-bordered text-center" border="1">
                            <thead>
                                <tr>
                                    <th width="250">Date</th>
                                    <th width="250">Reference</th>
                                    <th width="350">Recipient</th>
                                    <th>
                                        <div class="border-bottom">Balance</div>
                                        <div>Quantity</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM released_item WHERE item_id = ? ";
                                $stmt  = $conn->prepare($query);
                                $stmt->bind_param("i", $getview);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {

                                    $dateString    = $row['date'];
                                    $timestamp     = strtotime($dateString);
                                    $formattedDate = date("F, j Y g:i a", $timestamp);
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $row['date'] ?>
                                        </td>
                                        <td>
                                            <?= $row['reference'] ?>
                                        </td>
                                        <td class="text-uppercase">
                                            <?= $row['release_to'] ?>
                                        </td>
                                        <td class="text-danger fw-bold">
                                            <?= $row['balance_quantity'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-3">
                        <table class='table table-bordered text-center' border='1'>
                            <thead>
                                <tr>
                                    <th>Total Released</th>
                                    <th>Remaining Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT SUM(balance_quantity) as total_balance, actual_delivery FROM released_item INNER JOIN item ON item.id=released_item.item_id WHERE item_id = ? GROUP BY item_id";
                                $stmt  = $conn->prepare($query);
                                $stmt->bind_param("i", $getview);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td class='fw-bold fs-3'>
                                            <?= $row['total_balance']; ?>
                                        </td>
                                        <td class='text-danger fw-bold fs-3'>
                                            <?= $total_released = $row['actual_delivery'] - $row['total_balance'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php } ?>
            </div>

            <?php

            } else {
                echo "Error executing query: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();

            // Close the database connection
            $conn->close();
            ?>

        </div>

    </body>

    </html>

<?php } else {
    header("Location: login.php");
} ?>