<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'route'
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
