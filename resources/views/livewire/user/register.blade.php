<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">
                    <div class="img" style="background-image: url('{{ asset('images/bg2.png') }}');">
              </div>
                    <div class="login-wrap p-4 p-md-5">
                  <div class="d-flex">
                      <div class="w-100">
                        <h3 class="mb-4" style="color: rgb(79, 111, 255); font-weight: bold;">Sign Up</h3>
                      </div>
                            <div class="w-100">
                                <p class="social-media d-flex justify-content-end">
                                </p>
                            </div>
                  </div>
                        <form wire:submit.prevent='create' class="signin-form">
                            <div class="form-group mb-3">
                                <label for="inputFirstName">First name</label>
                                <input class="form-control" wire:model='fname' id="fname" name="fname" placeholder="Enter your First Name" required>
                                  @error('fname')
                                  <span class="text-danger">{{ $message }}</span>
                                  @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="inputMiddleName">Middle name</label>
                                <input class="form-control" wire:model='mname' id="mname" name="mname" placeholder="Enter your Middle Name" required>
                                  @error('mname')
                                  <span class="text-danger">{{ $message }}</span>
                                  @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="inputLastName">Last name</label>
                              <input class="form-control" wire:model='lname' type="text" placeholder="Enter your Last Name"required />
                                @error('lname')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                    <div class="form-group mb-3">
                        <label for="inputEmail">Email address</label>
                        <input class="form-control" wire:model='email' type="email" placeholder="name@example.com" required/>
                         @error('email')
                        <span class="text-danger">{{ $message }}</span>
                         @enderror
                    </div>

                    <div class="form-group mb-3">
                        <div class="form-floating mb-3 mb-md-0">
                            <label for="inputPassword">Password</label>
                            <input class="form-control" wire:model='password' type="password" placeholder="Create a password" required/>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                       </div>
                    </div>
                <div class="form-group">
                    <div class="d-grid"><button class="btn btn-primary btn-block"  type="submit" href="login.html">Create Account</button></div>
                </div>
              </form>
              <p class="text-center">Have an account?<a href="{{ route('user.login') }}">Go to login</a></div>
            </div>
          </div>
            </div>
        </div>
</div>
