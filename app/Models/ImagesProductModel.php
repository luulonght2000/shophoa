<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesProductModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'filenames'
    ];

    public function setFilenamesAttribute($value)
    {
        $this->attributes['filenames'] = json_encode($value);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\ProductModel::class);
    }
}
