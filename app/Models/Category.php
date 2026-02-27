<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Menggunakan UUID agar laravel otomatis mengisi ID dengan UUID saat insert data
    use HasUuids;

    // Masa assignment protection

    protected $fillable = [
        'name',
        'description',
    ];
}
