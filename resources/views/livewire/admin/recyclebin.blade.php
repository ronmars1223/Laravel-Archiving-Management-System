<div>
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

<div class="card my-2">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="m-0 font-weight-bold text-primary">Disposal ({{ $totalRecycles }})</h3>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="input-group mb-3" style="width:45%">
        <input type="text" wire:model="search" class="form-control" placeholder="Search..." wire:keydown.enter="performSearch">
        <div class="input-group-append">
            <button wire:click="performSearch" class="btn btn-primary">Search</button>
        </div>

    </div>
    <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 13px;">
                      <thead>
                            <tr style="background-color: #4e73df; color: #ffffff;">
                                <th class="align-middle" style="width: 12%;">
                                    <div style="cursor: pointer; color: #ffffff; display: flex; align-items: center;">
                                        <span style="margin-right: 5px;">Document References Number</span>
                                    </div>
                                </th>
                                <th class="align-middle" style="width: 10%;">
                                    <div wire:click="sortBy('filetype')" style="cursor: pointer; color: #ffffff; display: flex; align-items: center;">
                                        <span style="margin-right: 5px;">Record Series</span>
                                        @if ($sortField === 'filetype')
                                            <span>{!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}</span>
                                        @else
                                            <span>&nbsp;</span>
                                        @endif
                                    </div>
                                </th>
                                <th class="align-middle" style="width: 15%;">Records Titile and Description</th>
                                <th class="align-middle" style="width: 12%;">
                                    <div wire:click="sortBy('inclusive_dates')" style="cursor: pointer; color: #ffffff; display: flex; align-items: center;">
                                        <span style="margin-right: 5px;">Period Covered Inclusive Date</span>
                                        @if ($sortField === 'inclusive_dates')
                                            <span>{!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}</span>
                                        @else
                                            <span>&nbsp;</span>
                                        @endif
                                </th>
                                <th class="align-middle" style="width: 8%;">Volume</th>
                                 <th class="align-middle" style="width: 10%;">Records Medium</th>
                                <th class="align-middle" style="width: 8%;">
                                    <div wire:click="sortBy('restrictions')" style="cursor: pointer; color: #ffffff; display: flex; align-items: center;">
                                        <span style="margin-right: 5px;">Restrictions</span>
                                        @if ($sortField === 'restrictions')
                                            <span>{!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}</span>
                                        @else
                                            <span>&nbsp;</span>
                                        @endif
                                </th>
                                <th class="align-middle" style="width: 10%;">Records Location</th>
                                <th class="align-middle" style="width: 11%;">
                                    <div style="cursor: pointer; color: #ffffff; display: flex; align-items: center;">
                                        <span style="margin-right: 5px;">Retention Period</span>
                                </th>
                                <th class="align-middle" style="width: 9%;">Restore</th>
                                <th class="align-middle" style="width: 9%;">Delete</th>
                        </tr>
                    </thead>
            <tbody>
                @forelse($recycles as $recycle)
                    <tr>
                            <td>{{ $recycle->reference_num }}</td>{{--1 referencenumber --}}
                            <td>{{ $recycle->filetype }}</td>{{--1 File Type --}}
                            <td>{{ $recycle->document }}</td>{{-- 2Documents and Description --}}
                            <td>{{ \Carbon\Carbon::parse($recycle->inclusive_dates)->toDateString() }}</td>
                            <td>{{ $recycle->volume }}</td>{{-- 5Records Volume --}}
                            <td>{{ $recycle->records_medium }}</td>{{-- 6Records Midium --}}
                            <td>{{ $recycle->restrictions}}</td>{{-- 8Documents Restrictions --}}
                            <td>{{ $recycle->records_location}}</td>{{--7 Documents Located --}}
                            <td>{{ \Carbon\Carbon::parse($recycle->due_date)->toDateString() }}</td>{{-- 9Documents when created --}}
                            <td class="text-center">
                                <button wire:click="restoreConfirmation({{ $recycle->id }})" data-toggle="modal" data-target="#restoreModal" class="btn btn-success btn-sm">Restore</button>
                            </td>
                            <td class="text-center">
                                <button wire:click="deleteConfirmation({{ $recycle->id }})" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="20" class="text-center">
                            <h4 class="text-center">Document Not Found</h4>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
    <!-- Restore Modal -->
    <div wire:ignore.self class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreModalLabel">Confirm Restoration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #000; border: none; outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to restore this record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button wire:click="restore({{ $recycleToRestore }})" class="btn btn-success" data-dismiss="modal">Restore</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #000; border: none; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record permanently?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button wire:click="delete({{ $recycleToDelete }})" class="btn btn-danger" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
    </div>


