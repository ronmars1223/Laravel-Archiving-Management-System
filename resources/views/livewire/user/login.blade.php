<div>
    <x-slot name="title">
        Admin Login
    </x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="wrap d-md-flex">
                    <div class="img" style="background-image: url({{ asset('images/bg-1.png') }});">
                    </div>
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4" style="color: rgb(79, 111, 255); font-weight: bold;">User Login</h3>
                            </div>
                            <div class="w-100">
                                <p class="social-media d-flex justify-content-end">
                                </p>
                            </div>
                        </div>
                        <form wire:submit.prevent='login'>
                            <div class="form-group">
                                <label for="inputEmail">Email Address</label>
                                @error('email')
                                    <span class="text-danger">The email field is required.</span>
                                @enderror
                                <input class="form-control py-4" wire:model='email' type="email"
                                    placeholder="Enter Email address"/>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password</label>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input class="form-control py-4" wire:model='password' id="password" type="password"
                                    placeholder="Enter password" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">
                                    <span wire:loading.remove wire:target='login'>Login</span>
                                    <span wire:loading wire:target='login'>Login.....</span>
                                </button>
                            </div>
                        </form>
                        <div class="d-md-flex">
                            <div class="w-50 text-left">
                                <a href="{{ route('admin.login') }}" class="admin-login-link">Login as Admin</a>
                            </div>
                            <div class="w-50 text-right">
                             <a href="{{ route('user.register') }}" class="admin-login-link">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
