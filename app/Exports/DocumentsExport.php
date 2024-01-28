<?php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocumentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Get total counts before fetching the documents
        $permanentCount = Document::where('doctype', 'Permanent')->count();
        $temporaryCount = Document::where('doctype', 'Temporary')->count();

        // Fetch documents
        $documents = Document::select(
            'reference_num',
            'filetype',
            'doctype',
            'volume',
            'records_medium',
            'records_location',
            'restrictions',
            'document',
            'description',
            'inclusive_dates',
            'due_date'
        )->get();

        // Use a variable to track counts for each document type
        $permanentCounter = 0;
        $temporaryCounter = 0;

        // Map documents and update counts
        $documents = $documents->map(function ($document) use (&$permanentCounter, &$temporaryCounter, $permanentCount, $temporaryCount) {
            // Add total counts to each row
            $document['permanent_total'] = $permanentCount;
            $document['temporary_total'] = $temporaryCount;

            return $document;
        });

        return $documents;
    }

    public function headings(): array
    {
        return [
            'Reference Number',
            'File Type',
            'Document Type',
            'Volume',
            'Records Medium',
            'Records Location',
            'Document Restrictions',
            'Document',
            'Description',
            'Inclusive Dates',
            'Due Date',
            'Permanent Documents Total',
            'Temporary Documents Total',
        ];
    }
}
