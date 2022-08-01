<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ML_Categories extends Model
{
    use HasFactory;
    protected $keyType = 'string';

    protected $table = 'ml_categories';

    protected $fillable = [
        'id','name', 'picture', 'permalink', 'total_items','path_from_root','children_categories','date_created'
    ];
}
