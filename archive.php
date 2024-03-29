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
                    <input id="archivefilterInput" type="date" value="" class="form-control form-control-sm">
                </div>
                <div class="col-8">

                </div>
                <div class="col-1">

                </div>
            </div>

            <!-- Display the filtered data here -->
            <div class="row mt-2">
                <div class="col-12">
                    <div id="filteredAData"></div>
                </div>
            </div>

        </div>
    </body>

    <script>
        $(document).ready(function () {
            function updateContent() {
                var selectedFilter = $("#archivefilterInput").val();
                $.ajax({
                    type: "POST",
                    url: "archiveFilter.php",
                    data: { filter: selectedFilter },
                    success: function (response) {
                        $("#filteredAData").html(response);
                    },
                    error: function () {
                        alert("Error processing request");
                    }
                });
                localStorage.setItem("selectedFilter", selectedFilter);
            }

            var storedFilter = localStorage.getItem("selectedFilter");
            if (storedFilter) {
                $("#archivefilterInput").val(storedFilter);
            }

            updateContent(); // Call the function initially to load all data or the stored filter

            $("#archivefilterInput").change(function () {
                updateContent();
            });
        });
    </script>

    </html>

<?php } else {
    header("Location: login.php");
} ?>