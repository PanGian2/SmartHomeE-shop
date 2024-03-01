<?php require_once("../partials/boilerplate.php"); ?>

</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php";
    require_once("../../models/order.php"); ?>
    <?php
    $o = new Order();
    $orders = $o->getOrders()->toArray();

    //Depending on the occasion, display the appropriate flash messages on top of the page
    flash("deleteSuccess");
    flash("deleteError");

    flash("createSuccess");
    flash("createError");
    ?>
    <main>

        <section id="form_tables" class="table-responsive align-items-center my-3 mx-2">
            <h1 class="text-center">Όλες οι Παραγγελίες</h1>
            <table class="table table-secondary table-hover caption-top">
                <caption>Συνολικές παραγγελίες: <?php echo count($orders) ?></caption>
                <thead>
                    <tr class="table-dark">
                        <th></th>
                        <th scope="col">Κωδικός Παραγγελίας</th>
                        <th scope="col">Κατάσταση</th>
                        <th scope="col">Ημερ/νια Παραγγελίας</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td scope='row' style='width: 8%;'>
                                <a class='btn btn-primary my-1' href='show.php?id=<?php echo $order->_id ?>'>Show</a>
                            </td>
                            <td><?php echo $order->_id ?></td>
                            <td><?php echo $order->status ?> </td>
                            <td><?php echo $order->dateTimeOrdered ?> </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </section>

    </main>

</body>

</html>