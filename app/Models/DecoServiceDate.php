<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecoServiceDate extends Model
{
    use HasFactory;

    protected $fillable = ['date'];

    public function decoService()
    {
        return $this->belongsTo(DecoService::class);
    }

}
