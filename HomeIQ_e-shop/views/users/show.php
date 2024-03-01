<?php require_once("../partials/boilerplate.php"); ?>
<style>
    .table-wrapper {
        max-height: 20em;
        overflow: auto;
    }
</style>
</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php"; ?>
    <?php

    //Get id from the url
    $userId = $_GET["id"];
    $u = new User();
    $user = $u->getUserById($userId);
    $email = "'" . $user->email . "'";
    // $logout = iterator_to_array($user["logout_time"]);
    $dates = [];
    $json = json_encode(iterator_to_array($user["loginHistory"]));

    flash("updateSuccess");
    flash("updateError");

    flash("createSuccess");
    flash("createError");
    ?>
    <main>

        <section id="form_tables" class="table-responsive align-items-center my-3 mx-2">
            <h1 class="text-center">Προβολή Χρήστη</h1>
            <div>
                <a href="index.php" class="btn btn-success my-2">Πίσω στους χρήστες</a>
            </div>
            <table class="table table-secondary table-hover caption-top">
                <caption>Πληροφορίες Χρήστη</caption>
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


                    <tr>
                        <td scope='row' style='width: 14%;'>
                            <a class='btn btn-warning my-1' href='edit.php?id=<?php echo $user->_id ?>'>Edit</a>
                            <form class='d-inline me-0' action='../../controllers/users.php' method='post'>
                                <input type='hidden' name='formType' value='deleteUser'>
                                <input type='hidden' name='userId' value='<?php echo $user->_id ?>'>
                                <button class='btn btn-danger' type='submit'>Delete</button>
                            </form>
                        </td>
                        <td><?php echo $user->role == 1 ? "Απλός" : "Admin" ?></td>
                        <td><?php echo $user->email ?> </td>
                        <td><?php echo $user->name ?> </td>
                        <td><?php echo $user->surname ?> </td>
                        <td><?php echo $user->phone ?> </td>
                        <td><?php echo $user->city ?></td>
                        <td><?php echo $user->address ?> </td>
                        <td><?php echo $user->postalCode ?></td>
                        <td><?php echo $user->inNewsletter == 1 ? "Ναι" : "Όχι" ?></td>
                    </tr>

                </tbody>
            </table>
        </section>
        <section id="form_tables" class="table-responsive align-items-center my-3 mx-2">
            <div class="table-wrapper">
                <table class="table table-secondary table-hover caption-top  text-center">
                    <caption>Ιστορικό Χρήστη</caption>
                    <thead>
                        <tr class="table-dark">
                            <th scope="col">Ώρα σύνδεσης</th>
                            <th scope="col">Ώρα αποσύνδεσης</th>
                            <th scope="col">Διάρκεια (σε λεπτά)</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($user->loginHistory as $h) : ?>
                            <tr>
                                <td><?php echo $h->loginTime ?></td>
                                <td><?php echo $h->logoutTime == null ? "Δεν αποσυνδέθηκε" : $h->logoutTime  ?> </td>
                                <td><?php echo $h->duration == null ? "Άγνωστο" : $h->duration  ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </section>
        <section>
            <canvas id="loginChart" width="400" height="200" class="mt-5"></canvas>
        </section>

    </main>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@^3"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@^2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1"></script>
    <script src="../../utils/chart.js"></script>
    <script>
        let json = <?php echo $json ?>;
        console.log(json[0])
        let loginTimes = []
        let durations = []
        json.forEach(element => {
            loginTimes.push(element.loginTime)
            durations.push(element.duration)
        });
        createLoginLogoutChart(loginTimes, durations)
    </script>

</body>

</html>