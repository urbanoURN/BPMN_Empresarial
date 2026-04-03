<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    // $fillable me protegera contra asignación masiva
    protected $fillable = [
        'name',
        'description',
        'bpmn_xml',
    ];
}