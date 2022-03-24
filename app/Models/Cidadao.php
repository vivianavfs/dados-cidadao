<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidadao extends Model
{
    use HasFactory;

    protected $table = 'cidadaos';
    protected $guarded = [];
    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function contato()
    {
        return $this->hasOne(Contato::class)->latestOfMany();
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class)->latestOfMany();
    }
}
