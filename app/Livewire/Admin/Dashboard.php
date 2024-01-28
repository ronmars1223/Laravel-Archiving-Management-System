<?php

namespace App\Livewire\Admin;

use App\Models\Document;
use App\Models\User;
use Livewire\Component;
use App\Models\Recycle;

class Dashboard extends Component
{
    public $totalUser, $totalDocument, $approveUser, $totalDoctype, $totalDoctype1, $totalRecycles;
    public $totalAdministrative, $totalFinancial, $totalLegalRecords, $totalPersonnelRecords, $totalSocialServices;
    public $totalDue; // Add this property

    public function render()
    {
        $this->totalUser = User::count();
        $this->totalDocument = Document::count();
        $this->totalRecycles = Recycle::count();
        $this->totalDoctype = Document::where('doctype', 'Permanent')->count();
        $this->totalDoctype1 = Document::where('doctype', 'Temporary')->count();
        $this->approveUser = User::where('remember_token', 1)->count();
        $this->totalAdministrative = Document::where('filetype', 'Administrative')->count();
        $this->totalFinancial = Document::where('filetype', 'Financial')->count();
        $this->totalLegalRecords = Document::where('filetype', 'LegalRecords')->count();
        $this->totalPersonnelRecords = Document::where('filetype', 'PersonnelRecords')->count();
        $this->totalSocialServices = Document::where('filetype', 'SocialServices')->count();
        $this->totalDue = Recycle::where('doctype', 'Temporary')->count();

        return view('livewire.admin.dashboard')
            ->layout('layouts.admin-app');
    }
}
