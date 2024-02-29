<?php include 'header.php'; ?>

<body>
    <div class="container-lg shadow-sm">
        <div class="text-center h1 mono">Stock Card System</div>

        <div class="row mb-3">
            <div class="col-1 text-center p-0 m-0">
                <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24">
            </div>
            <div class="col-11 p-0">
                <p class="ps-5 m-0">Department of Agriculture</p>
                <p class="ps-5 m-0"><strong>Regional Field Office No. 5</strong></p>
            </div>
        </div>

        <div class="row bg-light p-2">
            <div>
                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addItem">Add Item</button>
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
            <form id="addItemData">
                <div class="modal-body">

                    <div class="form-group mb-2">
                        <label for="" class="form-label">Item:</label>
                        <input type="text" class="form-control mb-1">
                        <label for="" class="form-label">Description:</label>
                        <input type="text" class="form-control mb-1">
                        <label for="" class="form-label">Unit of Measurement:</label>
                        <input type="text" class="form-control mb-1">
                        <label for="" class="form-label">Stock No:</label>
                        <input type="text" class="form-control mb-1">
                        <label for="" class="form-label">Re-order Point:</label>
                        <input type="text" class="form-control mb-1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>