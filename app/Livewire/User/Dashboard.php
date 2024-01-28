<?php

namespace App\Livewire\User;

use App\Models\Document;
use App\Models\User;
use Livewire\Component;
use App\Models\Recycle;

class Dashboard extends Component
{
    public $totalUser, $totalDocument, $approveUser, $pendingUser, $totalDoctype, $totalDoctype1,$totalRecycles;
    public $totalAdministrative, $totalFinancial, $totalLegalRecords, $totalPersonnelRecords, $totalSocialServices,$totalDue;

    public function render()
    {
        $this->totalDocument = Document::count();
        $this->totalRecycles = Recycle::count();
        $this->totalDoctype = Document::where('doctype', 'Permanent')->count();
        $this->totalDoctype1 = Document::where('doctype', 'Temporary')->count();
        $this->totalAdministrative = Document::where('filetype', 'Administrative')->count();
        $this->totalFinancial = Document::where('filetype', 'Financial')->count();
        $this->totalLegalRecords = Document::where('filetype', 'LegalRecords')->count();
        $this->totalPersonnelRecords = Document::where('filetype', 'PersonnelRecords')->count();
        $this->totalSocialServices = Document::where('filetype', 'SocialServices')->count();
        $this->totalDue = Recycle::where('doctype', 'Temporary')->count();


        return view('livewire.user.dashboard')->layout('layouts.user-app');
    }
}
