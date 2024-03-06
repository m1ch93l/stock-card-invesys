<?php
session_start();
if (isset($_SESSION['admin'])) {

    include 'header.php';

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
                    <button type="button" class="btn btn-outline-light btn-sm fw-bold" data-bs-toggle="modal"
                        data-bs-target="#addItem">Add Item</button>
                </div>
                <div class="col-3">
                    <select id="filterSelect" class="form-select form-select-sm fw-bold text-uppercase">
                        <option disabled selected>Select Item</option>
                        <?php include 'database.php';
                        $stmt = $conn->prepare("SELECT id, item FROM item");

                        if ($stmt && $stmt->execute()) {
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "'>" . htmlspecialchars($row['item'], ENT_QUOTES) . "</option>";
                            }

                            $stmt->close();
                        } else {
                            echo "Error preparing statement: " . $conn->error;
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="col-7">
                    <button type="button" class="btn btn-outline-light btn-sm fw-bold" data-bs-toggle="modal"
                        data-bs-target="#addRelease">Release</button>
                </div>
                <div class="col-1">
                    <a href="archive.php" type="button" class="btn btn-danger btn-sm fw-bold border-light">Archive</a>
                </div>
            </div>

            <!-- Display the filtered data here -->
            <div class="row mt-2">
                <div id="filteredItem"></div>
                <div class="col-9">
                    <div id="filteredData"></div>
                </div>
                <div class="col-3">
                    <div id="filteredDelivery"></div>
                </div>
            </div>

        </div>
    </body>

    <!-- Modal -->
    <div class="modal fade" id="addItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Items</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="crud.php" method="post">
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Item:</label>
                            <input type="text" class="form-control mb-1" name="item" required>
                            <label for="" class="form-label">Description:</label>
                            <input type="text" class="form-control mb-1" name="description">
                            <label for="" class="form-label">Unit of Measurement:</label>
                            <input type="text" class="form-control mb-1" name="uom">
                            <label for="" class="form-label">Stock No:</label>
                            <input type="text" class="form-control mb-1" name="stockno">
                            <label for="" class="form-label">Re-order Point:</label>
                            <input type="text" class="form-control mb-1" name="reorder">
                            <label for="" class="form-label">Actual Delivery:</label>
                            <input type="text" class="form-control mb-1" name="actualDelivery" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="stock-add" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addRelease" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Release</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="crud.php" method="post" onsubmit="return validateForm()">
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Date:</label>
                            <input type="text" class="form-control mb-1" value="<?php
                            $currentDate = date('F j, Y');
                            echo $currentDate ?>" readonly>
                            <label for="" class="form-label">Item:</label>
                            <select id="itemId" name="itemId" class="form-select border-success mb-1">
                                <option disabled selected>Select Item</option>
                                <?php include 'database.php';
                                $stmt = $conn->prepare("SELECT id, item FROM item");

                                if ($stmt && $stmt->execute()) {
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "'>" . htmlspecialchars($row['item'], ENT_QUOTES) . "</option>";
                                    }

                                    $stmt->close();
                                } else {
                                    echo "Error preparing statement: " . $conn->error;
                                }

                                $conn->close();
                                ?>
                            </select>
                            <label for="" class="form-label">Reference:</label>
                            <input type="text" class="form-control mb-1" name="refer">
                            <label for="" class="form-label">Recipient:</label>
                            <input type="text" class="form-control mb-1" name="releasedBy" required>
                            <label for="" class="form-label">Balance:</label>
                            <input type="text" class="form-control mb-1" name="balance" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="release-add" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Function to update the content based on the selected filter
            function updateContent() {
                var selectedFilter = $("#filterSelect").val();

                // Use AJAX to send the selected filter to a PHP script for processing
                $.ajax({
                    type: "POST",
                    url: "filter.php", // Update this with the actual PHP script name
                    data: { filter: selectedFilter },
                    success: function (response) {
                        // Update the content with the response from the server
                        $("#filteredData").html(response);
                    },
                    error: function () {
                        alert("Error processing request");
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "filterDelivery.php", // Update this with the actual PHP script name
                    data: { filter: selectedFilter },
                    success: function (response) {
                        // Update the content with the response from the server
                        $("#filteredDelivery").html(response);
                    },
                    error: function () {
                        alert("Error processing request");
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "filterItem.php", // Update this with the actual PHP script name
                    data: { filter: selectedFilter },
                    success: function (response) {
                        // Update the content with the response from the server
                        $("#filteredItem").html(response);
                    },
                    error: function () {
                        alert("Error processing request");
                    }
                });
                // Save the selected filter to localStorage
                localStorage.setItem("selectedFilter", selectedFilter);
            }

            // Retrieve the selected filter from localStorage on page load
            var storedFilter = localStorage.getItem("selectedFilter");
            if (storedFilter) {
                // Set the selected filter to the stored value
                $("#filterSelect").val(storedFilter);

            } else {
                // If there's no stored filter, select the default value (first option)
                var defaultFilter = $("#filterSelect").val();
                updateContent();
            }

            // Call the function initially to load all data or the stored filter
            updateContent();

            // Attach an event listener to the select dropdown
            $("#filterSelect").change(function () {
                // Call the function when the user changes the filter
                updateContent();
            });

        });

        function validateForm() {
            var selectedItem = document.getElementById("itemId").value;

            // Check if an item is selected
            if (selectedItem == "Select Item") {
                alert("Please select an item before submitting the form.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

    </script>

    </html>

<?php } else {
    header("Location: login.php");
} ?>