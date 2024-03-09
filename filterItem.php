<?php
// Establish a connection to your MySQL database
include 'database.php';

// Check if the filter condition is provided in the AJAX request, otherwise use a default filter
$filterCondition = isset($_POST['filter']) ? $_POST['filter'] : 'all';

// Use a prepared statement to prevent SQL injection
if ($filterCondition == 'all') {
    $sql  = "SELECT * FROM item";
    $stmt = $conn->prepare($sql);
} else {
    // Modify this based on your specific filtering conditions
    $sql  = "SELECT * FROM item WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filterCondition);
}

// Execute the prepared statement
$stmt->execute();
$result = $stmt->get_result();

if ($result) {

    while ($row = $result->fetch_assoc()) {
        echo "
    <div class='row mb-1 text-white bg-success'>
        <div class='col-6 mt-2'>
            <p class='border-bottom text-capitalize'><b>Item: </b>{$row['item']}</p>
            <p class='border-bottom text-capitalize'><b>Description: </b>{$row['description']}</p>
            <p class='border-bottom text-capitalize'><b>Unit of Measurement: </b>{$row['unit_measure']}</p>
        </div>
        <div class='col-5 mt-2'>
            <p class='border-bottom text-capitalize'><b>Stock No: </b>{$row['stock_no']}</p>
            <p class='border-bottom text-capitalize'><b>Re-order point: </b>{$row['re_order']}</p>
            <p class='border-bottom text-capitalize'><b>Actual Delivery: </b>{$row['actual_delivery']}</p>
        </div>
        <div class='col-1 text-center mt-2'>
            <button type='button' class='btn btn-light fs-4 p-1 m-1' data-bs-toggle='modal' data-bs-target='#editItem{$row['id']}'><span><i class='bx bx-edit text-primary'></i></span></button>
            <button type='button' class='btn btn-light fs-4 p-1 m-1' data-bs-toggle='modal' data-bs-target='#deleteItem{$row['id']}'><span><i class='bx bx-trash text-danger'></i></span></button>
            <button type='button' class='btn btn-light fs-4 p-1 m-1' data-bs-toggle='modal' data-bs-target='#archiveItem{$row['id']}'><span><i class='bx bx-archive-in'></i></span></button>
        </div>
    </div>

    <!-- Edit modal -->
    <div class='modal fade' id='editItem{$row['id']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Edit Items</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <form action='crud.php' method='post'>
                    <div class='modal-body'>
                        <div class='form-group mb-2'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <label class='form-label'>Item:</label>
                            <input type='text' class='form-control mb-1' name='item' value='{$row['item']}'>
                            <label class='form-label'>Description:</label>
                            <input type='text' class='form-control mb-1' name='description' value='{$row['description']}'>
                            <label class='form-label'>Unit of Measurement:</label>
                            <input type='text' class='form-control mb-1' name='uom' value='{$row['unit_measure']}'>
                            <label class='form-label'>Stock No:</label>
                            <input type='text' class='form-control mb-1' name='stockno' value='{$row['stock_no']}'>
                            <label class='form-label'>Re-order Point:</label>
                            <input type='text' class='form-control mb-1' name='reorder' value='{$row['re_order']}'>
                            <label class='form-label'>Actual Delivery:</label>
                            <input type='text' class='form-control mb-1' name='actualDelivery' value='{$row['actual_delivery']}'>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' name='stock-edit' class='btn btn-primary'>Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete modal -->
    <div class='modal fade' id='deleteItem{$row['id']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='deleteItemLabel{$row['id']}'>Confirm Deletion</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <form action='crud.php' method='post'>
                    <div class='modal-body'>
                        <p>Are you sure you want to delete the item '{$row['item']}'?</p>
                        <input type='hidden' value='{$row['id']}' name='itemId'>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary btn-sm' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' name='stock-delete' class='btn btn-danger btn-sm'>Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Archive modal -->
    <div class='modal fade' id='archiveItem{$row['id']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5'>Confirm Archiving</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <form action='crud.php' method='post'>
                    <div class='modal-body'>
                        <p>Are you sure you want to archive this item '{$row['item']}'?</p>
                        <input type='hidden' value='{$row['id']}' name='itemId'>
                        <input type='hidden' value='1' name='status'>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary btn-sm' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' name='stock-archive' class='btn btn-danger btn-sm'>Archive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    ";
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