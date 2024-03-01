<?php
// Βρίσκουμε το απόλυτο path για τον φάκελο "admin"
// $imgPath = 'HomeIQ_e-shop/imgs';

// Επιλέγουμε τον φάκελο ανάλογα με το αρχείο που καλεί το navbar.php
$imgPath = '';
$viewsPath = "";
$currentFile = $_SERVER['PHP_SELF'];
$currentDir = dirname($currentFile);

$viewsPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/views/';
$imgPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/imgs/';
//}
?>
<header>
    <nav class="navbar navbar-expand-lg fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand ms-3" href="<?php echo $viewsPath ?>home.php">
                <img src="<?php echo $imgPath; ?>logo_transparent.png" alt="Bootstrap" width="100" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-label="Toggle navigation" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">HomeIQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" id="navbarNav">
                    <ul class="navbar-nav  mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo $viewsPath ?>home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $viewsPath ?>aboutUs.php">Σχετικά με μας</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">Προϊόντα</a>
                        </li>
                    </ul>
                    <form class="d-flex mb-3 mb-lg-1 position-relative" role="search" id="search" method="get">
                        <input class="form-control" name="search" id="searchInput" type="search" placeholder="Αναζήτηση Προϊόντος" aria-label="Search">
                        <input type="submit" hidden>
                        <div id="searchResults" class="position-absolute top-100 start-0 mt-1" style="z-index: 1000;">
                            <ul id="searchList" class="list-group"></ul>
                        </div>
                    </form>

                    <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == 2) : ?>
                        <div id="icons" class="d-flex align-items-center ms-1"><?php if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) : ?>
                                <div class="dropdown">
                                    <button class="btn " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle mx-4" viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu text-center me-5">
                                        <li><a class="dropdown-item btn btn-primary" href="<?php echo $viewsPath ?>users/user-profile.php">Προβολή Προφίλ</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="btn btn-danger " href="<?php echo $viewsPath ?>partials/logout.php">Αποσύνδεση</a></li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <a href="<?php echo $viewsPath ?>admin_home.php" class="btn btn-outline-primary ">Μετάβαση στην σελίδα διαχείρισης</a>

                        </div>
                    <?php else : ?>
                        <div id="icons" class="d-flex align-items-center me-4">
                            <a href="<?php echo $viewsPath ?>favorites.php" class="position-relative me-4" aria-label="Go to your favorite products">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart mx-1" viewBox="0 0 16 16">
                                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                </svg>
                                <?php
                                if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                                    $usr = new User();
                                    $user = $usr->getUserById($_SESSION["userID"]);
                                    echo '<span class="position-absolute top-0 ms-0 translate-middle badge rounded-pill bg-primary">';
                                    echo count($user["favorites"]);
                                    echo ' <span class="visually-hidden">favorite products</span>';
                                }
                                ?>
                            </a>
                            <?php if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) : ?>
                                <div class="dropdown">
                                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User Menu">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle mx-4" viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                        </svg>

                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <li><a class="dropdown-item btn btn-primary" href="<?php echo $viewsPath ?>users/user-profile.php">Προβολή Προφίλ</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="btn btn-danger " href="<?php echo $viewsPath ?>partials/logout.php">Αποσύνδεση</a></li>
                                    </ul>
                                </div>
                            <?php else : ?>
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" aria-label="User Menu">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle mx-4" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                    </svg>
                                </button>
                            <?php endif; ?>

                            <a href="<?php echo $viewsPath ?>cart.php" class="position-relative" aria-label="Go to cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart ms-4 me-1" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                </svg>
                                <?php if (isset($_COOKIE["cart"])) {

                                    echo '<span class="position-absolute top-0 ms-0 translate-middle badge rounded-pill bg-primary">';
                                    echo unserialize($_COOKIE["cart"])->totalQty;
                                    echo ' <span class="visually-hidden">products in the cart</span>';
                                    echo "</span>";
                                }
                                ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <?php require("navbar-categories.php"); ?>
    <?php require("navbar-login.php"); ?>
    <?php require("navbar-register.php"); ?>


</header>