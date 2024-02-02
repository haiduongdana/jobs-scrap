<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'scrap_info',
        'scraped_data',
        'status',
    ];
}
