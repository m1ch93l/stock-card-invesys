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
                    <a href="index.php" type="button" class="btn btn-sm fw-bold fs-7 text-white"><i
                            class='bx bx-arrow-back'></i></a>
                </div>
                <div class="col-2">
                    <input id="archivefilterInput" type="date" class="form-control form-control-sm">
                </div>
                <div class="col-8">

                </div>
                <div class="col-1">

                </div>
            </div>

            <!-- Display the filtered data here -->
            <div class="row mt-2">
                <div class="col-9">
                    <div id="filteredData"></div>
                </div>
            </div>

        </div>
    </body>

    <script>
        $(document).ready(function () {

            function updateContent() {
                var selectedFilter = $("#archivefilterInput").val();

                // Use AJAX to send the selected filter to a PHP script for processing
                $.ajax({
                    type: "POST",
                    url: "archiveFilter.php", // Update this with the actual PHP script name
                    data: { filter: selectedFilter },
                    success: function (response) {
                        // Update the content with the response from the server
                        $("#filteredData").html(response);
                    },
                    error: function () {
                        alert("Error processing request");
                    }
                });

                localStorage.setItem("selectedFilter", selectedFilter);
            }

            // Retrieve the selected filter from localStorage on page load
            var storedFilter = localStorage.getItem("selectedFilter");
            if (storedFilter) {
                // Set the selected filter to the stored value
                $("#archivefilterInput").val(storedFilter);
            }

            // Call the function initially to load all data or the stored filter
            updateContent();

            // Attach an event listener to the date input
            $("#archivefilterInput").change(function () {
                // Call the function when the user changes the filter
                updateContent();
            });
        });
    </script>

    </html>

<?php } else {
    header("Location: login.php");
} ?>