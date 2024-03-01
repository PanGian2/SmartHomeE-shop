<header>
    <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand ms-3" href="<?php echo $viewsPath ?>home.php">
                <img src="<?php echo $imgPath; ?>logo_transparent.png" alt="HomeIQ Admin" width="100" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">HomeIQ Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?php echo $viewsPath; ?>admin_home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $viewsPath; ?>users/index.php">Χρήστες</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $viewsPath; ?>products/index.php">Προϊόντα</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $viewsPath; ?>orders/index.php">Παραγγελίες</a>
                        </li>
                    </ul>
                    <?php if (!isset($_SESSION["loggedIn"])) : ?>
                        <button class="btn btn-light my-2 my-lg-0" data-bs-toggle="modal" data-bs-target="#adminLoginModal">Login</button>
                    <?php else : ?>
                        <a href="<?php echo $viewsPath ?>partials/logout.php" class="btn btn-danger my-2 my-lg-0">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <?php require("navbar-admin-login.php"); ?>
</header>