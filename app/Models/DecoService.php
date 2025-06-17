<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecoService extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'description', 'price', 'image_url', 'category_id', 'date'];

    public function dates()
    {
        return $this->hasMany(DecoServiceDate::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
