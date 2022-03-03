<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';
    protected $fillable = [
        'nombre',
        'autor',
        'isbn',
        'cantidad',
        'fecha_publicacion',
        'editorial_id'
    ];

    //scopes
    public function scopeOfSearch($query, $param)
    {
        if (!empty($param)) {
            return $query->where('nombre', 'like', '%'.$param.'%')
                ->orWhere('autor', 'like', '%'. $param . '%');
        }

        return $query;
    }

    //scope
    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }
}
