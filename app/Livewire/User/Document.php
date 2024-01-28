<?php

namespace App\Livewire\User;

use App\Models\Document as ModelsDocument;
use App\Models\Recycle;
use App\Exports\DocumentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Value;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Document extends Component
{
    // Validation rules for Livewire properties
    #[Rule('required')]
    public $title, $doctype, $filetype;
    public $selectedDocument;

    #[Rule('file|mimes:pdf,doc,docx|max:1024000')]
    public $document;

    // Additional properties used in the component
    public $path;
    public $volume;
    public $records_medium;
    public $totalDocuments;
    public $records_location;
    public $restrictions;
    public $description;
    public $inclusive_dates;
    public $reference_num;
    public $unreadAlertsCount;
    public $showTable = true;
    public $createForm = false;
    public $updateForm = false;
    public $totalAdministrative;
    public $totalFinancial;
    public $totalLegalRecords;
    public $totalPersonnelRecords;
    public $totalSocialServices;
    public $dueDate;
    public $perPage = 5;
    public $search= '';
    public $showNotificationModal = true;
    public $concatenatedType;
    public $administrativeType;
    public $financialType;
    public $legalrecordsType;
    public $personnelrecordsType;
    public $socialservicesType;
    public $locationOptions;
    public $restrictOptions;
    public $fileOptions;
    public $administrativeOptions;
    public $financialOptions;
    public $legalOptions;
    public $personnelOptions;
    public $socialOptions;
    public $docOptions;

    // Trait usage for file uploads and pagination
    use WithFileUploads;
    use WithPagination;

    // Property to store downloaded documents
    public $downloads;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $rules = [
        'reference_num' => 'required|unique:documents,reference_num',
    ];
    public function generateExcelReport()
    {
        // Use the Excel facade to download the report using the DocumentsExport class
        return Excel::download(new DocumentsExport, 'documents_report.xlsx');
    }

    public function removeAlert($index)
    {
        // Remove the alert from the session using the provided index
        $alerts = session('alerts', []);

        if (isset($alerts[$index])) {
            unset($alerts[$index]);
            session(['alerts' => $alerts]);
        }

        // You can also emit an event or perform any other necessary actions
    }

    public function closeNotificationModal()
    {
        // Perform any necessary actions when closing the modal
        $this->showNotificationModal = false;
    }


    // Define the sortable fields
    protected $sortableFields = [
        'filetype','doctype','created_at', 'due_date','restrictions','inclusive_dates'
    ];

    // Show details of a specific document
    public function showDocumentDetails($documentId)
    {
        // Find the document with the given ID
        $this->selectedDocument = ModelsDocument::find($documentId);
    }

    // Close the details view
    public function closeDetails()
    {
        // Set the selectedDocument property to null, hiding the details view
        $this->selectedDocument = null;
    }

    // Initialize the downloads property with all documents on component mount
    public function mount(){
        $this->downloads = ModelsDocument::all();
    }

    // Sort the documents based on a specified field
    public function sortBy($field)
    {
        // Check if the specified field is sortable
        if (in_array($field, $this->sortableFields)) {
            // Toggle the sort direction if sorting by the same field
            if ($field === $this->sortField) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                // Set the sort field and direction for a new sorting criteria
                $this->sortDirection = 'asc';
                $this->sortField = $field;
            }
        }
    }

    // Get the content of a document and return it as a response
    public function getDocumentContent($documentId)
    {
        // Find the document by ID
        $document = ModelsDocument::find($documentId);

        // Check if the document exists
        if ($document) {
            // Construct the file path using the storage_path and the document's path
            $filePath = storage_path("app/{$document->path}");

            // Check if the file exists at the specified path
            if (file_exists($filePath)) {
                // Read the content of the file
                $fileContent = file_get_contents($filePath);

                // Return the document content as a response with appropriate headers
                return Response::make($fileContent, 200, [
                    'Content-Type' => 'application/pdf', // Adjust the content type based on your document type
                    'Content-Disposition' => "inline; filename={$document->document}",
                ]);
            }
        }
        // If the document is not found or the file doesn't exist, return a response with a 404 status
        return response('Document not found', 404);
    }

    // Render the Livewire component with paginated documents
    public function render()
    {
        $this->locationOptions = Value::pluck('location')->toArray();
        $this->restrictOptions = Value::pluck('restrict')->toArray();
        $this->fileOptions = Value::pluck('file')->toArray();
        $this->administrativeOptions = Value::pluck('administrative')->toArray();
        $this->financialOptions = Value::pluck('financial')->toArray();
        $this->legalOptions = Value::pluck('legal')->toArray();
        $this->personnelOptions = Value::pluck('file')->toArray();
        $this->socialOptions = Value::pluck('file')->toArray();
        $this->docOptions = Value::pluck('doc')->toArray();
        // Build the query to retrieve documents and handle search functionality
        $query = ModelsDocument::orderBy($this->sortField, $this->sortDirection);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('filetype', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('doctype', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('document', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('reference_num', 'LIKE', '%' . $this->search . '%');
            });
        }

        // Paginate the results and pass them to the view
        $documents = $query->paginate($this->perPage);
        $this->totalDocuments = ModelsDocument::count();
        $this->totalAdministrative = ModelsDocument::where('filetype', 'Administrative')->count();
        $this->totalFinancial = ModelsDocument::where('filetype', 'Financial')->count();
        $this->totalLegalRecords = ModelsDocument::where('filetype', 'LegalRecords')->count();
        $this->totalPersonnelRecords = ModelsDocument::where('filetype', 'PersonnelRecords')->count();
        $this->totalSocialServices = ModelsDocument::where('filetype', 'SocialServices')->count();

        // Calculate the unread alerts count
        $this->unreadAlertsCount = count(session('alerts', []));

        return view('livewire.user.document', compact('documents'))->layout('layouts.user-app');
    }

    // Re-render the Livewire component to perform a search
    public function performSearch()
    {
        $this->render();
    }

    // Handle updates to the search property
    public function updatedSearch()
    {}

    // Reset state to show the table view
    public function goBack()
    {
        $this->showTable = true;
        $this->createForm = false;
        $this->updateForm = false;
    }

    // Switch to the form view for creating a new document
    public function showForm()
    {
        $this->showTable = false;
        $this->createForm = true;
    }

    // Save a new document
    public function save()
    {
        // Validate form input
        $this->validate([
            'filetype' => 'required',
            'reference_num'=>'required|unique:documents,reference_num',
            'document' => 'required|file|mimes:pdf|max:1024000',
            'doctype' => 'required',
            'dueDate' => $this->doctype == 'Temporary' ? 'required|date' : '',
            'volume' => 'required',
            'records_medium'=>'required',
            'records_location'=>'required',
            'restrictions'=>'required',
            'description'=>'',
            'inclusive_dates'=>'required|date', // Corrected attribute name here
            'administrativeType' => 'required_if:filetype,Administrative',
            'financialType' => 'required_if:filetype,Financial',
            'legalrecordsType' => 'required_if:filetype,LegalRecords',
            'personnelrecordsType' => 'required_if:filetype,personnelrecordsType',
            'socialservicesType' => 'required_if:filetype,socialservicesType',
        ]);

        // Set up file storage path and create a new document instance
        $currentDate = Carbon::now()->format('Y-m-d');
        $this->path = $this->document->store("Documents/{$currentDate}");
        $this->concatenatedType = $this->filetype . ' | ' .$this->administrativeType.$this->financialType.$this->legalrecordsType.$this->personnelrecordsType.$this->socialservicesType;
        $document = new ModelsDocument([
            'filetype' => $this->concatenatedType,
            'description' => $this->description,
            'doctype' => $this->doctype,
            'path' => $this->path,
            'document' => $this->document->getClientOriginalName(),
            'volume' => $this->volume,
            'records_medium'=>$this->records_medium,
            'records_location'=>$this->records_location,
            'restrictions'=>$this->restrictions,
            'description'=>$this->description,
            'inclusive_dates' => Carbon::parse($this->inclusive_dates)->format('Y-m-d'),
            'reference_num'=>$this->reference_num,
        ]);

        // Set the due date only for temporary documents
        if ($this->doctype == 'Temporary') {
            $parsedDueDate = Carbon::parse($this->dueDate);
            $document->due_date = $parsedDueDate->format('Y-m-d');
        }

        // Save the document and handle success/failure
        $result = $document->save();

        if ($result) {
            // Flash success messages
            session()->flash('status', 'File uploaded');
            session()->flash('success', 'Document saved successfully');

            // Delete Livewire temporary files and reset form fields
            $this->deleteLivewireTmp();
            $this->goBack();

            // Schedule deletion task for temporary documents
            if ($this->doctype == 'Temporary') {
                $this->scheduleDeleteTask($document->id, $document->due_date);
            }

            $this->reset();
        } else {
            // Flash an error message if document save fails
            session()->flash('status', 'Error uploading file');
        }
    }


    // Delete Livewire temporary files
    protected function deleteLivewireTmp()
    {
        $livewireTmpPath = storage_path('app/livewire-tmp');

        if (File::exists($livewireTmpPath)) {
            File::deleteDirectory($livewireTmpPath);
        }
    }

    // Download a document
    public function downloadfile(ModelsDocument $uploadfile)
    {
        $filePath = storage_path("app/{$uploadfile->path}");

        if (file_exists($filePath)) {
            $fileSize = filesize($filePath);

            // Provide a response to start the download with proper headers
            return response()->download(
                $filePath,
                $uploadfile->document,
                ['Content-Length' => $fileSize]
            );
        }

        // Flash a message if the file is not found
        session()->flash('status', 'File not found');
    }

    public function checkAndMoveToRecycleBin()
    {
        // Get the documents with due dates that have passed
        $documentsToMove = ModelsDocument::where('due_date', '<', now())
            ->where('doctype', 'Temporary')
            ->get();

        // Move each document to the recycle bin and set 'total_due' to 1
        foreach ($documentsToMove as $document) {
            $this->moveToRecycleBin($document);
        }
    }

    protected function moveToRecycleBin($document)
    {
        // Save the due date before deleting the document
        $dueDate = $document->due_date;

        // Move the file to the recycle bin folder
        $recycleBinPath = 'RecycleBin';
        Storage::makeDirectory($recycleBinPath);
        $recycleBinFileName = "{$recycleBinPath}/{$document->path}";
        Storage::move($document->path, $recycleBinFileName);
        $document->delete();

        Recycle::create([
            'filetype' => $document->filetype,
            'doctype' => $document->doctype,
            'path' => $recycleBinFileName,
            'document' => $document->document,
            'due_date' => $dueDate, // Transfer due_date to Recycle
            'volume' => $document->volume,
            'records_medium' => $document->records_medium,
            'records_location' => $document->records_location,
            'restrictions' => $document->restrictions,
            'description' => $document->description,
            'inclusive_dates' => $document->inclusive_dates,
            'reference_num' => $document->reference_num,
            'total_due' => 1,
            'deleted_at' => now(),
        ]);

        // Log that the document has been moved
        \Log::info("Document '{$document->document}' moved to recycle bin due to exceeded due date");
    }
    public function scheduleDeleteTask($documentId, $dueDate)
    {
        $this->checkDueDates();
        // Instead of calling 'schedule:run', call the new function directly
        $this->checkAndMoveToRecycleBin();
    }
    public function checkDueDates()
    {
        // Get the documents with due dates within the next 5 days
        $documentsAlmostDue = ModelsDocument::where('due_date', '>', now())
            ->where('due_date', '<', now()->addDays(5))
            ->where('total_due', 0) // Only consider documents not already alerted
            ->get();

        foreach ($documentsAlmostDue as $document) {
            // Generate alert for documents almost due
            $this->generateAlert("Document '{$document->document}' is almost due in 5 days.");
            // Set 'total_due' to 1 to mark the document as alerted
            $document->update(['total_due' => 1]);
        }

        // Get the documents with due dates that have already passed
        $documentsOverdue = ModelsDocument::where('due_date', '<', now())
            ->where('total_due', 0) // Only consider documents not already alerted
            ->get();

        foreach ($documentsOverdue as $document) {
            // Generate alert for overdue documents
            $this->generateAlert("Document '{$document->document}' is already overdue.");
            // Set 'total_due' to 1 to mark the document as alerted
            $document->update(['total_due' => 1]);
        }
    }
    protected function generateAlert($message)
    {
        $alerts = session('alerts', []);
        $alerts[] = $message;
        session(['alerts' => $alerts]);
    }

}
