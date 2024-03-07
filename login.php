<?php include 'header.php'; ?>

<body>
    <div class="container-fluid py-5 my-4">
        <div class="row my-5 py-5">
            <div class="col-4"></div>
            <div class="col-4 d-flex justify-content-center align-items-center">
                <div class="card shadow-md p-3" style="width:400px">
                    <form action="crud.php" method="post">
                        <div class="text-center fs-1 text-capitalize mb-5 fw-bold text-success">Welcome to SCS</div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" id="floatingInput"
                                placeholder="name@example.com" required>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="floatingPassword"
                                placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button type="submit" name="user-login"
                            class="form-control btn btn-success p-2 text-uppercase fw-bold">login</button>
                    </form>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</body>

</html>