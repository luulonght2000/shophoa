<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(\App\Models\CategoryModel::class);
    }

    public function style()
    {
        return $this->belongsTo('App\Models\StyleModel');
    }

    public function comment()
    {
        return $this->hasMany('App\Models\CommentModel');
    }
}
