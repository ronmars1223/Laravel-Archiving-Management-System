<div>
    <x-slot name="title">
        Admin Login
     </x-slot>
     <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                @if(session()->has('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">
                    <div class="img" style="background-image: url('{{ asset('images/dswd.png') }}');">
              </div>
                    <div class="login-wrap p-4 p-md-5">
                  <div class="d-flex">
                      <div class="w-100">
                        <h3 class="mb-4" style="color: rgb(79, 111, 255); font-weight: bold;">Admin Login</h3>
                      </div>
                            <div class="w-100">
                                <p class="social-media d-flex justify-content-end">
                                </p>
                            </div>
                  </div>
                  <form wire:submit.prevent='login'>
                    <div class="form-group">
                        <label for="inputUsername">Username</label>
                        @error('username')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <input class="form-control py-4" wire:model="username" id="username" type="text" placeholder="Enter username" />
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <input class="form-control py-4" wire:model='password' id="password" type="password" placeholder="Enter password" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">
                            <span wire:loading.remove wire:target='login'>Login</span>
                            <span wire:loading wire:target='login'>Login.....</span>
                        </button>
                    </div>
                    <div class="d-md-flex">
                        <div class="w-50 text-left">
                            <a href="{{ route('user.login') }}" class="admin-login-link">Login as User</a>
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
