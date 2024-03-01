<?php require_once("partials/boilerplate.php"); ?>
<style>
    .list-group-item {
        margin: 0.7% 0.5%;
        border: 1px solid black !important;
        border-radius: 5px;
        padding: 1% 0;
        color: black
    }
</style>
</head>

<body>
    <?php require("../utils/flash_messages.php");
    require_once "partials/admin_navbar.php";
    ?>
    <main>

        <section id="welcome" class="text-center container-fluid">
            <h1 class="text-center my-5">Καλωσήλθατε στην Σελίδα Διαχέιρισης</h1>
            <h2 class="mb-4">Επιλέξτε μία από τις σελίδες διαχείρισης</h2>
            <div class="list-group list-group-horizontal-lg text-center">
                <a href="users/index.php" class="list-group-item list-group-item-primary list-group-item-action rounded-end ">Χρήστες</a>
                <a href="products/index.php" class="list-group-item list-group-item-primary list-group-item-action ">Προϊόντα</a>
                <a href="orders/index.php" class="list-group-item list-group-item-primary list-group-item-action ">Παραγγελίες</a>
            </div>
        </section>

    </main>
</body>

</html>