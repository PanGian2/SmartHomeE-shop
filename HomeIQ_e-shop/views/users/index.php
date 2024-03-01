<?php require_once("../partials/boilerplate.php"); ?>
</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php"; ?>
    <?php
    $u = new User();
    $users = $u->getUsers()->toArray();

    //Depending on the occasion, display the appropriate flash messages on top of the page
    flash("deleteSuccess");
    flash("deleteError");

    flash("createSuccess");
    flash("createError");
    ?>
    <main>

        <section id="form_tables" class="table-responsive align-items-center my-3 mx-2">
            <h1 class="text-center">Όλοι οι χρήστες</h1>
            <div>
                <a href="new.php" class="btn btn-success my-2">Add User</a>
            </div>
            <table class="table table-secondary table-hover caption-top">
                <caption>Συνολικοί χρήστες: <?php echo count($users) ?></caption>
                <thead>
                    <tr class="table-dark">
                        <th></th>
                        <th scope="col">Ρόλος</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ονομα</th>
                        <th scope="col">Επιθετο</th>
                        <th scope="col">Τηλέφωνο</th>
                        <th scope="col">Πολη</th>
                        <th scope="col">Διευθυνση</th>
                        <th scope="col">Τ.Κ</th>
                        <th scope="col">Newsletter</th>

                    </tr>
                </thead>
                <tbody>
                    <?php


                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td scope='row' style='width: 8%;'>
                        <a class='btn btn-primary my-1' href='show.php?id=", $user->_id, "'>Show</a>
                        </td>";
                        echo "<td>", $user->role == 1 ? "Απλός" : "Admin" . "</td>";
                        echo "<td>", $user->email . "</td>";
                        echo "<td>", $user->name . "</td>";
                        echo "<td>", $user->surname . "</td>";
                        echo "<td>", $user->phone . "</td>";
                        echo "<td>", $user->city . "</td>";
                        echo "<td>", $user->address . "</td>";
                        echo "<td>", $user->postalCode . "</td>";
                        echo "<td>", $user->inNewsletter == 1 ? "Ναι" : "Όχι" . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

        </section>

    </main>

</body>

</html>