<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'duracao',
        'calorias_gastas',
        'data' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'data' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getDataFormatadaAttribute()
    {
        return $this->data 
            ? $this->data->format('d/m/Y')
            : null;
    }

    public function getDataHoraFormatadaAttribute()
    {
        return $this->data 
            ? $this->data->format('d/m/Y H:i')
            : null;
    }
}