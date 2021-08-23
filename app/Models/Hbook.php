<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hbook extends Model
{
    use HasFactory;

    protected $table = "hbook";
    protected $guarded = [];

    protected $casts = [
        'info_s' => 'array',
        'gst_s' => 'array'
    ];
}
