<div class="container mt-5">
    <div class="row">
        <!-- Change Password Section -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title m-0 font-weight-bold text-primary">Change Password</h3>

                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <form wire:submit.prevent="changePassword">
                        <div class="form-group">
                            <label for="currentPassword">Current Password</label>
                            <input type="password" wire:model.lazy="currentPassword" class="form-control" id="currentPassword" required>
                            @error('currentPassword') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="newPassword">New Password</label>
                            <input type="password" wire:model.lazy="newPassword" class="form-control" id="newPassword" required>
                            @error('newPassword') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="confirmNewPassword">Confirm New Password</label>
                            <input type="password" wire:model.lazy="confirmNewPassword" class="form-control" id="confirmNewPassword" required>
                            @error('confirmNewPassword') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Additional Forms on the Right Side -->
        <div class="col-md-6 col-lg-8">
            <!-- Form for adding location -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="location">Enter New Records Location</label>
                    <input type="text" wire:model='location' class="form-control" id="location" required>
                    @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add Location</button>
                </div>
            </form>

            <!-- Form for adding restrictions -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="restrict">Enter New Restrictions</label>
                    <input type="text" wire:model='restrict' class="form-control" id="restrict" required>
                    @error('restrict') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add Restrictions</button>
                </div>
            </form>

            <!-- Form for adding file type -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="file">Enter New File type</label>
                    <input type="text" wire:model='file' class="form-control" id="file" required>
                    @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add File Type</button>
                </div>
            </form>

            <!-- Form for adding administrative type -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="administrative">Enter New Administrative Type</label>
                    <input type="text" wire:model='administrative' class="form-control" id="administrative" required>
                    @error('administrative') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add Administrative Type</button>
                </div>
            </form>

            <!-- Form for adding financial type -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="financial">Enter New Financial type</label>
                    <input type="text" wire:model='financial' class="form-control" id="financial" required>
                    @error('financial') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add Financial Type</button>
                </div>
            </form>

            <!-- Form for adding legal type -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="legal">Enter New Legal type</label>
                    <input type="text" wire:model='legal' class="form-control" id="legal" required>
                    @error('legal') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add Legal Type</button>
                </div>
            </form>

            <!-- Form for adding personnel type -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="personnel">Enter New Personnel type</label>
                    <input type="text" wire:model='personnel' class="form-control" id="personnel" required>
                    @error('personnel') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add Personnel Type</button>
                </div>
            </form>

            <!-- Form for adding social type -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="social">Enter New Social type</label>
                    <input type="text" wire:model='social' class="form-control" id="social" required>
                    @error('social') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add Social Type</button>
                </div>
            </form>

            <!-- Form for adding doc type -->
            <form wire:submit.prevent="addValue" class="mb-4">
                <div class="form-group my-1">
                    <label for="doc">Enter New Time Value type</label>
                    <input type="text" wire:model='doc' class="form-control" id="doc" required>
                    @error('doc') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Add Doc Type</button>
                </div>
            </form>
        </div>
    </div>
</div>
