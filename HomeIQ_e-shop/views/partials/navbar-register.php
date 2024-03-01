<?php
$configPath = "";
$currentFile = $_SERVER['PHP_SELF'];
$currentDir = dirname($currentFile);
$configPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/';
include_once $configPath . "config.php";
$source = substr($_SERVER["PHP_SELF"], 21);
?>
<div class="modal" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Δημιουργία Λογαριασμού</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="regAlert" style="display: none;"></div>
                <form action="../controllers/users.php" method="post" class="navNeeds-validation" novalidate>
                    <input type="hidden" name="formType" id="regFormType" value="createUser">
                    <input type="hidden" name="source" value="<?php echo $source ?>">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-12">
                            <label for="name" class="form-label">Όνομα</label>
                            <input type="text" class="form-control" name="name" id="name" required autofocus>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label for="surname" class="form-label">Επίθετο</label>
                            <input type="text" class="form-control" name="surname" id="surname" required>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="emailRegister" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="emailRegister" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="telRegister" class="form-label">Κινητό</label>
                        <input type="tel" class="form-control" id="telRegister" name="tel" pattern="[0-9]{10}" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Πόλη</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-8 col-md-12">
                            <label for="address" class="form-label">Διεύθυνση</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <label for="postalCode" class="form-label">T.K</label>
                            <input type="number" class="form-control" id="postalCode" name="postalCode" required>
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Κωδικός</label>
                        <div class="input-group">
                            <input type="password" class="form-control password" id="passwordInput" name="password" required>
                            <span class="input-group-text hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash togglePassword" viewBox="0 0 16 16" id="" style="cursor: pointer;">
                                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                    <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                                </svg>
                            </span>
                            <span class="input-group-text shown" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye untogglePassword" viewBox="0 0 16 16" style="cursor: pointer;">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </span>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPasswordInput" class="form-label">Επαλήθευση Κωδικού</label>
                        <div class="input-group">
                            <input type="password" class="form-control password" id="confirmPasswordInput" required>
                            <span class="input-group-text hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash togglePassword" viewBox="0 0 16 16" style="cursor: pointer;">
                                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                    <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                                </svg>
                            </span>
                            <span class="input-group-text shown" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye untogglePassword" viewBox="0 0 16 16" style="cursor: pointer;">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </span>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <input type="checkbox" class="form-check-input" id="newsletterInput" name="newsletterInput" value="1">
                        <label for="newsletterInput" class="form-check-label">Επιθυμώ να λαμβάνω
                            ενημερωτικά email</label>
                    </div>
                    <div class="mb-2 text-center">
                        <button type="submit" class="btn btn-success">Δημιουργία Λογαριασμού</button>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>