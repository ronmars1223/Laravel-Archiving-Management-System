<?php

namespace App\Livewire\Admin;
use App\Models\Document as ModelsDocument;
use App\Models\Recycle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Recyclebin extends Component
{
    public $search = '';
    public $totalRecycles;
    public $recycleToDelete;
    public $recycleToRestore;
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $selectedDocument;

    protected $sortableFields = [
        'filetype','doctype','created_at', 'due_date',
    ];
    public function sortBy($field)
    {
        if (in_array($field, $this->sortableFields)) {
            if ($field === $this->sortField) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortDirection = 'asc';
                $this->sortField = $field;
            }
        }
    }

    public function render()
    {
        //find the doctype,document,due_date./
        $recycles =Recycle::where('doctype', 'like', '%' . $this->search . '%')
        ->orWhere('doctype', 'LIKE', '%' . $this->search . '%')
        ->orWhere('document', 'LIKE', '%' . $this->search . '%')
        ->orWhere('reference_num', 'LIKE', '%' . $this->search . '%')
        ->get();
        $this->totalRecycles = $recycles->count(); // Calculate the total number of recycles
        return view('livewire.admin.recyclebin', compact('recycles'))->layout('layouts.admin-app'); // Change variable name to $recycles
    }

    public function performSearch()
    {
        $this->render();
    }

    public function updatedSearch()
    {
        // This method is automatically called when the $search property is updated.
        // You can leave it empty or add additional logic if needed.
    }

    public function restore($recycleId)
    {
        // Find the recycle record by ID
        $recycle = Recycle::find($recycleId);

        // Check if the recycle record exists
        if ($recycle) {
            // Find the corresponding document record
            $document = ModelsDocument::withTrashed()->where('document', $recycle->document)->first();

            if ($document) {
                // Extract the original date-based path from the document record
                $originalPath = $document->path;

                // Restore the document by setting deleted_at to null
                $result = $document->restore();

                if ($result) {
                    // Move the file back to the original date-based path
                    Storage::move($recycle->path, $originalPath);

                    // Permanently delete the record from the recycles table
                    $recycle->forceDelete();

                    // Flash success messages
                    session()->flash('status', 'Document and associated data restored successfully');
                    session()->flash('success', 'Document restored successfully');
                } else {
                    // Flash an error message if there was an issue restoring the document
                    session()->flash('status', 'Error restoring document');
                }
            } else {
                // Flash an error message if the corresponding document is not found
                session()->flash('status', 'Document not found in documents table');
            }
        } else {
            // Flash an error message if the recycle record is not found
            session()->flash('status', 'Document not found in recycle bin');
        }
    }


    public function delete($recycleId)
    {
        // Find the recycle record by ID
        $recycle = Recycle::find($recycleId);

        // Check if the recycle record exists
        if ($recycle) {
            // Find the corresponding document record
            $document = ModelsDocument::withTrashed()->where('document', $recycle->document)->first();

            if ($document) {
                // Delete the document file from the original date-based folder
                $originalPath = $document->path;
                Storage::delete($originalPath);

                // Delete the file from the RecycleBin folder
                $recycleBinFilePath = "RecycleBin/{$document->path}";
                Storage::delete($recycleBinFilePath);

                // Permanently delete the record from the documents table
                $document->forceDelete();

                // Delete the record from the recycles table
                $recycle->forceDelete();

                // Flash a success message
                session()->flash('success', 'Document permanently deleted successfully');
            } else {
                // Flash an error message if the corresponding document is not found
                session()->flash('error', 'Document not found in documents table');
            }
        } else {
            // Flash an error message if the recycle record is not found
            session()->flash('error', 'Recycle record not found');
        }
    }
    public function deleteConfirmation($recycleId)
    {
        $this->recycleToDelete = $recycleId;
    }
    public function restoreConfirmation($recycleId)
    {
        $this->recycleToRestore = $recycleId;
    }
}
