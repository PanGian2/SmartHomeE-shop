<?php require_once("partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../public/styles/home.css">
<link rel="stylesheet" href="../public/styles/productLink.css">
</head>

<body style="padding-top: 9em;">
    <?php
    require_once("partials/navbar.php");
    require_once("../utils/flash_messages.php");
    ?>
    <main>
        <div class="container mt-3">
            <h1 class="text-center mb-4">Ανακαλύψτε τα Starter Kits για Έξυπνο Σπίτι!</h1>
            <p class="text-center">Βασισμένοι στην πείρα και τη γνώση μας στον τομέα των προϊόντων έξυπνου σπιτιού, παρουσιάζουμε τα νέα μας starter kits που έχουν σχεδιαστεί
                για να σας βοηθήσουν να ξεκινήσετε την ταξιδιωτική σας εμπειρία προς ένα έξυπνο σπίτι. Κάθε κιτ περιλαμβάνει μια επιλογή από τα πιο δημοφιλή προϊόντα μας,
                τα οποία έχουν επιλεγεί με προσοχή από τους ειδικούς μας.</p>

            <p class="text-center"> Ξεκινήστε τη διαδρομή σας προς το έξυπνο σπίτι σήμερα με ένα από τα starter kits μας. Ανυπομονούμε να σας δούμε να απολαμβάνετε την απλότητα και την έξυπνη λειτουργία που μπορεί να προσφέρει ένα έξυπνο σπίτι!</p>
            <div class="row my-3 gy-2">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title fs-4">Κιτ 1: Αρχάριοι</h2>
                            <p class="card-text">Μπορείτε να ξεκινήσετε την εμπειρία σας με αυτό το starter kit που περιλαμβάνει τρία προϊόντα που όλοι πρέπει να έχουν!</p>
                            <ul class="list-group">
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65de31fbfcd216b28d02fe54"><strong>2x</strong> Ταινία LED 10W/m 220-240V 2000-6500K RGBW IP20 Bluetooth</a></li>
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65de3170fcd216b28d02fe53"><strong>2x</strong> Λάμπα LED 6W 806lm E27 230V 2700K Θερμό Λευκό Bluetooth Filament</a></li>
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65e08c077290e3b87906fd86"><strong>1x</strong> Πρίζα Σούκο Ασύρματη WiFi 16A 230V 3680W Λευκή & energy monitoring Version 1.0</a></li>
                            </ul>
                            <div class="row align-items-center text-center mt-3">
                                <div class="col-sm-5">
                                    <strong>Σύνολο: <span id="cartTotalPrice">53.50</span> €</strong>
                                </div>
                                <div class="col-sm-7">
                                    <form action="../controllers/cart.php" method="post">
                                        <input type="hidden" name="formType" value="addKitCart">
                                        <input type="hidden" name="kit" value="kit1">
                                        <button type="submit" class="btn btn-primary">Προσθήκη στο Καλάθι</button>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card kit-card">
                        <div class="card-body">
                            <h2 class="card-title fs-4">Κιτ 2: Μεσαίο</h2>
                            <p class="card-text">Αναβαθμίστε το σπίτι σας με αυτό το starter kit που περιλαμβάνει τρία ασυναγώνιστα προϊόντα.</p>
                            <ul class="list-group">
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65de31fbfcd216b28d02fe54"><strong>2x</strong> Ταινία LED 10W/m 220-240V 2000-6500K RGBW IP20 Bluetooth</a></li>
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65e08caf7290e3b87906fd87"><strong>1x</strong> Πολύπριζο 3 Θέσεων WiFi 10A Με διακόπτη Λευκό 1,5m & 3xUSB Version 1.0</a></li>
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65de2b80fcd216b28d02fe50"><strong>1x</strong> Βαλβίδα Καλοριφέρ Smart</a></li>
                            </ul>
                            <div class="row align-items-center text-center mt-3">
                                <div class="col-sm-6">
                                    <strong>Σύνολο: <span id="cartTotalPrice">164.40</span> €</strong>
                                </div>
                                <div class="col-sm-6">
                                    <form action="../controllers/cart.php" method="post">
                                        <input type="hidden" name="formType" value="addKitCart">
                                        <input type="hidden" name="kit" value="kit2">
                                        <button type="submit" class="btn btn-primary">Προσθήκη στο Καλάθι</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card kit-card">
                        <div class="card-body">
                            <h2 class="card-title fs-4">Κιτ 3: Προχωρημένο</h2>
                            <p class="card-text">Επαναπροσδιορίστε τον τρόπο ζωής σας με αυτό το starter kit που περιλαμβάνει τρία από τα πιο προηγμένα προϊόντα.</p>
                            <ul class="list-group">
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65e08de17290e3b87906fd89"><strong>1x</strong> Kit εισόδου πόρτας WiFi Θυροτηλεόραση 1εισ. 1εσωτ. Ασημί-Λευκό</a></li>
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65de2e1bfcd216b28d02fe51"><strong>1x</strong> Χρονοθερμοστάτης χώρου χωνευτός 1Θ. Μαύρος WiFi</a></li>
                                <li class="list-group-item"><a class="product_link" href="products/product.php?id=65de2b80fcd216b28d02fe50"><strong>2x</strong> Βαλβίδα Καλοριφέρ Smart</a></li>
                            </ul>
                            <div class="row align-items-center text-center mt-3">
                                <div class="col-sm-6">
                                    <strong>Σύνολο: <span id="cartTotalPrice">607.50</span> €</strong>
                                </div>
                                <div class="col-sm-6">
                                    <form action="../controllers/cart.php" method="post">
                                        <input type="hidden" name="formType" value="addKitCart">
                                        <input type="hidden" name="kit" value="kit3">
                                        <button type="submit" class="btn btn-primary">Προσθήκη στο Καλάθι</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<?php require_once("partials/footer.php"); ?>