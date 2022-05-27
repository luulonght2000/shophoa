<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo('App\Models\ProductModel');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\CustomerModel');
    }
}
