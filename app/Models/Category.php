<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    protected $keyType = 'int'; 
    protected $fillable = [
        'category_name',
        'description'
    ];


    public function product()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}