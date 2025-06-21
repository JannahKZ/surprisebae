<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecoService extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image', 'category_id'];

    public function dates()
    {
        return $this->hasMany(DecoServiceDate::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
