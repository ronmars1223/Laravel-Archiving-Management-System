<div>
    <x-slot name="title">
        Approve User
    </x-slot>
    <div class="container-fluid">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('removed'))
            <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                {{ session('removed') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card my-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="m-0 font-weight-bold text-primary">Approve User({{ $totalUser }})</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color: #4e73df; color: #ffffff;">
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Approve</th>
                                <th>Remove</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users->sortBy('id') as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->fname . ' ' .$user->mname .' '.$user->lname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{!! $user->custom_token == 1 ? '<span class="text-success">Approved</span>' : '<span class="text-danger">Not Approved</span>' !!}
                                    </td>
                                    <td>
                                        @if ($user->custom_token == 1)
                                            <button disabled class="btn btn-success">Approved</button>
                                        @else
                                            <button wire:click='approve({{ $user->id }})'
                                                class="btn btn-success">Approve</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->custom_token == 0)
                                            <button disabled class="btn btn-warning">Removed</button>
                                        @else
                                        <button wire:click='remove({{ $user->id }})' class="btn btn-warning">Remove</button>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click='delete({{ $user->id }})' class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <h4 class="text-center">User Not Found</h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tr>
                            <td colspan="8">
                                {{ $users->links('livewire-pagination-links') }}
                            </td>
                        </tr>
                    </table>
                    <div class="text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
