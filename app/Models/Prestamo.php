<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos';
    protected $fillable = [
        'user_id',
        'libro_id',
        'estado'
    ];

    //scopes
    public function scopeOfSearch($query, $param)
    {
        if (!empty($param)) {
            return $query->whereHas('user', function (Builder $query) use ($param) {
                $query->where('name', 'like', '%'.$param.'%');
            })
            ->orWhereHas('libro', function (Builder $query) use ($param) {
                $query->where('nombre', 'like', '%'.$param.'%');
            });
        }

        return $query;
    }

    //relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}
