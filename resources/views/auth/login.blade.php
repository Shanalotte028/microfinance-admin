<x-header class="bg-dark sb-nav-fixed" style="--bs-bg-opacity: .95;"/>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark">
                            <div class="card-header"><h3 class="text-center font-weight-muted my-4 text-light">Login</h3></div>
                            <div class="card-body">
                                <form method="post" action="/login">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input class="form-control text-dark" id="inputEmail" name="email" type="email" name="email" placeholder="name@example.com" />
                                        <label for="inputEmail">Email address</label>
                                        <x-form-error name="email"></x-form-error>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control text-dark" id="inputPassword" name="password" type="password" placeholder="Password" />
                                        <label for="inputPassword">Password</label>
                                        <x-form-error name="password"></x-form-error>
                                    </div>
                                    <div class="form-check mb-3 text-muted">
                                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                        <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                    </div>
                                    <div class="mt-4 mb-0 text-center">
                                        <button class="btn btn-success w-50 d-block mx-auto mb-2" type="submit">Login</button>
                                        <a class="small text-muted d-block mt-2" href="password.html">Forgot Password?</a>
                                    </div>   
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small text-"><a href="/register" class="text-muted">Need an account? Sign up!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</div>
</div>
<x-footer/>
<x-foot/>