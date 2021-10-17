<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
	  protected $fillable = [
        'Name','Birth_Date', 'Mobile','Address','ID_Number',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

}
