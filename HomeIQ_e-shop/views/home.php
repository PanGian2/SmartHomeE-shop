<?php require_once("partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../public/styles/home.css">
<link rel="stylesheet" href="../public/styles/productLink.css">
</head>

<body style="padding-top: 9em;">
    <?php
    require_once("partials/navbar.php");
    require_once("../utils/flash_messages.php");

    // flash("registerError");
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
        flash("loggedIn");
    }
    flash("notLoggedIn");
    flash("notAdmin");
    flash("orderSuccess");
    ?>
    <main>
        <section id="carousel">
            <div id="carouselExampleCaptions" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../imgs/bence-boros-anapPhJFRhM-unsplash.jpg" class="d-block w-100" height="500" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <strong class="fs-5">Έξυπνη Τεχνολογία για την Καθημερινότητά σας</strong>
                            <p>Ανακαλύψτε την άνεση και την ευκολία του να διαχειρίζεστε το σπίτι σας με τη χρήση των πιο προηγμένων τεχνολογιών.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../imgs/vinicius-amnx-amano-ALpEkP29Eys-unsplash.jpg" class="d-block w-100" height="500" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <strong class="fs-5">Ασφάλεια και Άνεση στο Σπίτι σας</strong>
                            <p>Προστατέψτε το σπίτι σας και απολαύστε την ηρεμία της νου και της ψυχής σας με τις προηγμένες λύσεις ασφαλείας και άνεσης που προσφέρουμε.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../imgs/sebastian-scholz-nuki-IJkSskfEqrM-unsplash.jpg" class="d-block w-100" height="500" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <strong class="fs-5">Έλεγχος μέσω του Smartphone</strong>
                            <p>Ανακαλύψτε την ευκολία του να διαχειρίζεστε το σπίτι σας από οπουδήποτε, με τις εξυπνες λύσεις μας που συνδέονται με το smartphone σας.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        <section id="category" class="container-fluid px-3">
            <div class="row my-3 text-center">
                <h1 class="mb-4 fs-2">Επιλεξτε κατηγορια</h1>
                <div class="col-lg-3 col-md-6 categories">
                    <img src="../imgs/led-lights.jpg" alt="Lighting Category" class="img-fluid w-md-75 product_img">
                    <h2 class="fs-3"><a href="products/product_category.php?category=Φωτισμός" class="product_link">Φωτισμός</a></h2>
                </div>
                <div class="col-lg-3 col-md-6 categories">
                    <img src="../imgs/smart-heating.jpg" alt="Heating Category" class="img-fluid w-md-75 product_img">
                    <h2 class="fs-3"><a href="products/product_category.php?category=Ψύξη-Θέρμανση" class="product_link">Ψύξη-Θέρμανση</a></h2>
                </div>
                <div class="col-lg-3 col-md-6 categories">
                    <img src="../imgs/smart_access.jpg" alt="Security Category" class="img-fluid w-md-75 product_img">
                    <h2 class="fs-3"><a href="products/product_category.php?category=Ασφάλεια-Πρόσβαση" class="product_link">Ασφάλεια-Πρόσβαση</a></h2>
                </div>
                <div class="col-lg-3 col-md-6 categories">
                    <img src="../imgs/speakers.jpg" alt="Socket Category" class="img-fluid w-md-75 product_img">
                    <h2 class="fs-3"><a href="products/product_category.php?category=Πρίζες" class="product_link">Πρίζες</a></h2>
                </div>

            </div>
        </section>

        <section id="shBenefits" class="container-fluid px-3">
            <div class="row my-4 text-center">
                <h1 class="fs-2">Γιατί HomeIQ?</h1>
                <p>Το κατάστημά μας ξεχωρίζει για πολλούς λόγους, και αυτοί οι λόγοι καθιστούν την επιλογή μας αναπόφευκτη.
                    Καταρχάς, παρέχουμε δωρεάν εγκατάσταση για αγορές άνω των 100 ευρώ, προσφέροντας έτσι ένα ακόμα κίνητρο για την αγορά από εμάς.
                    Επιπλέον, οι ειδικοί μας είναι πάντα στη διάθεσή σας για να σας παρέχουν συμβουλές και υποστήριξη σχετικά με το smart home,
                    βοηθώντας σας να επιλέξετε τα κατάλληλα προϊόντα που θα καλύψουν τις ανάγκες σας. Και το πιο σημαντικό, προσφέρουμε starter kits που
                    περιλαμβάνουν μια πληθώρα προϊόντων απαραίτητων για το ξεκίνημα του έξυπνου σπιτιού σας. Επιλέγοντας το κατάστημά μας, επιλέγετε
                    ποιότητα, εξυπηρέτηση και την ασφάλεια μιας πλήρως εξοπλισμένης και αξιόπιστης εμπειρίας αγορών για το smart home σας.</p>
                <div class="text-center">
                    <a class="btn btn-primary" href="starterKits.php" style="width: fit-content;">Δείτε τώρα τα Starter Kits μας</a>
                </div>

            </div>
        </section>
        <section id="tips" class="container-fluid px-3">
            <div class="row my-4 text-center">
                <h1 class="fs-2">Γιατί Smart Home?</h1>
                <p>Η αγορά προϊόντων έξυπνου σπιτιού προσφέρει μια πληθώρα οφελών και ευκαιριών που βελτιώνουν την καθημερινή μας ζωή.
                    Με τη χρήση αυτών των προϊόντων, η έννοια της άνεσης, της ασφάλειας και της αποδοτικότητας φτάνει σε νέα επίπεδα.
                    Ένα έξυπνο σπίτι μπορεί να παρέχει επιτήρηση και έλεγχο σε κάθε γωνιά του, εξοικονομώντας πολύτιμο χρόνο και ενέργεια.
                    Από την αυτοματοποίηση των φώτων και της θέρμανσης μέχρι τη δυνατότητα να ελέγχουμε τα πάντα από το κινητό μας τηλέφωνο,
                    η τεχνολογία έξυπνου σπιτιού αναδεικνύει μια ολοκληρωμένη εμπειρία διαβίωσης. Πέραν της άνεσης, η ασφάλεια αποτελεί έναν
                    ακόμα σημαντικό παράγοντα, καθώς οι έξυπνες συσκευές μπορούν να παρέχουν προηγμένα συστήματα προστασίας και ειδοποίησης.
                    Με την αγορά προϊόντων έξυπνου σπιτιού, επενδύουμε σε ένα καλύτερο, πιο ασφαλές και ευέλικτο μέλλον για τον εαυτό μας και την
                    οικογένειά μας.
                </p>
                <p>
                    Παρακάτω θα δείτε μερικά tips απο τους συνεργάτες μας στο Skroutz
                </p>
                <iframe wight="60%" height="400" src="https://www.youtube.com/embed/l3kFBybncUQ?si=44rEqDac7O1SlzJV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </section>
        <section id="newsletter" class="container-fluid px-3">
            <div class="row my-5 justify-content-center">
                <div class="card" style="width: 30rem; background-color: #3d5a80;">
                    <div class="card-body" style="color: whitesmoke;">
                        <h1 class="card-title fs-4">Γράψου στο Newsletter</h1>
                        <p class="card-text">Μη χάσετε τις προσφορές μας και τις τελευταίες ειδήσεις για την τεχνολογία του smart home!
                            Εγγραφείτε στο newsletter μας για να λαμβάνετε αποκλειστικά δελτία και ενημερώσεις σχετικά με νέες αφίξεις προϊόντων,
                            ειδικές προσφορές και χρήσιμα tips για το πώς να κάνετε το σπίτι σας ακόμα πιο έξυπνο και λειτουργικό.</p>
                        <form>
                            <div class="mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">@</span>
                                    <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="addon-wrapping">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 p-1.5">Υποβολή</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
<?php require_once("partials/footer.php"); ?>