<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';
    protected $guarded = [];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];
}
