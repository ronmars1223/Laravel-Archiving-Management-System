<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Document extends Model
{
    use SoftDeletes;
    use HasFactory;
    // ModelsDocument.php
    protected $fillable = ['title', 'doctype', 'path', 'document', 'due_date','filetype','volume','records_medium','records_location','restrictions','description','reference_num','inclusive_dates','total_due'];
    protected $dates = ['created_at', 'updated_at','deleted_at'];
    protected $listeners = ['openViewModal'];
}
