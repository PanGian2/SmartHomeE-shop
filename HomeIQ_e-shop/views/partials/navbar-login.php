<div class="modal modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Λογαριασμός Χρήστη</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row gx-1 gy-2 text-center">
                    <div class="col-12  col-lg-6 ps-1 pe-3" id="register">
                        <h2>Δεν έχεις λογαριασμό;</h2>
                        <p>Γίνε μέλος της κοινότητάς μας και επωφελήσου από αποκλειστικές προσφορές, ειδικές εκπτώσεις και πρώτη πρόσβαση σε νέες προσφορές!
                            Με τον προσωπικό σας λογαριασμό, μπορείτε να διαχειριστείτε εύκολα τις παραγγελίες σας, να αποθηκεύσετε τα αγαπημένα σας προϊόντα και
                            να λάβετε εξατομικευμένες προτάσεις βασισμένες στις προτιμήσεις σας.</p>
                        <button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#registerModal">Δημιούργησε τώρα λογαριασμό</button>
                    </div>
                    <div class="col-12  col-lg-6 px-3">
                        <h2 class="mb-4">Έχεις λογαριασμό;</h2>
                        <h3 class="fs-4 mb-2">Συνδέσου με τα Social Media</h3>

                        <a href="#" class="btn mb-2" style="background-color: #3B5998; color: white;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-facebook me-1 mb-1" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                            </svg> Σύνδεση με Facebook
                        </a>
                        <a href="#" class="google btn mb-2" style="background-color: #dd4b39; color: white;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-google me-1 mb-1" viewBox="0 0 16 16">
                                <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z" />
                            </svg> Σύνδεση με Google+
                        </a>
                        <h3 class="fs-4 mt-3">Ή συνδέσου με email</h3>
                        <div class="alert alert-danger" id="logAlert" style="display: none;"></div>
                        <form action="<?php echo $controllersPath ?>users.php" method="post" class="navNeeds-validation" novalidate>
                            <input type="hidden" name="formType" id="logFormType" value="login">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="emailLogin" name="email" placeholder="name@example.com" required>
                                <label for="emailLogin">Email address</label>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="form-floating input-group mb-3" style="border-radius: 10px;">
                                <input type="password" class="form-control password" id="passwordLogin" name="password" placeholder="password" required>
                                <label for="passwordLogin">Κωδικός</label>
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
                            <button type="submit" class="btn btn-primary">Σύνδεση</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>