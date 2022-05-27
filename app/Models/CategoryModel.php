<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'category_models';

    public function product()
    {
        return $this->hasMany(\App\Models\ProductModel::class);
    }
}
