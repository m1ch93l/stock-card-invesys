<?php

include 'header.php';
include 'database.php';

?>

<body>
    <div class="container-lg shadow-sm">
        <div class="text-center h1 mono">Stock Card System</div>

        <div class="row mb-3">
            <div class="col-1 text-center p-0 m-0">
                <img src="" alt="logo" width="30" height="24">
            </div>
            <div class="col-11 p-0">
                <p class="ps-5 m-0">Department of Agriculture</p>
                <p class="ps-5 m-0"><strong>Regional Field Office No. 5</strong></p>
            </div>
        </div>
        <div class="row bg-light p-2">
            <div class="col-1">
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addItem">Add Item</button>
            </div>
            <div class="col-2">
                <select id="filterSelect" class="form-select form-select-sm border-success">
                    <option disabled selected>Select Item</option>
                    <?php
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
            <div class="col-9">
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addItem">Add Item</button>
            </div>
        </div>

        <!-- Display the filtered data here -->
        <div id="filteredData"></div>

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
                        <input type="text" class="form-control mb-1" name="item">
                        <label for="" class="form-label">Description:</label>
                        <input type="text" class="form-control mb-1" name="description">
                        <label for="" class="form-label">Unit of Measurement:</label>
                        <input type="text" class="form-control mb-1" name="uom">
                        <label for="" class="form-label">Stock No:</label>
                        <input type="text" class="form-control mb-1" name="stockno">
                        <label for="" class="form-label">Re-order Point:</label>
                        <input type="text" class="form-control mb-1" name="reorder">
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
            // Save the selected filter to localStorage
            localStorage.setItem("selectedFilter", selectedFilter);
        }

        // Retrieve the selected filter from localStorage on page load
        var storedFilter = localStorage.getItem("selectedFilter");
        if (storedFilter) {
            // Set the selected filter to the stored value
            $("#filterSelect").val(storedFilter);
        }

        // Call the function initially to load all data or the stored filter
        updateContent();

        // Attach an event listener to the select dropdown
        $("#filterSelect").change(function () {
            // Call the function when the user changes the filter
            updateContent();
        });
    });
</script>

</html>