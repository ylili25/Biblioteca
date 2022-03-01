<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;

    protected $table = 'editoriales';
    protected $fillable = ['nombre'];

    //scopes
    public function scopeOfSearch($query, $param)
    {
        if (!empty($param)) {
            return $query->where('nombre', 'like', '%'.$param.'%');
        }

        return $query;
    }
}
