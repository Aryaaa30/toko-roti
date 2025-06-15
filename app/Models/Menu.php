<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'images',
        'stok',
        'kategori',
        'available'
    ];

    public function reviews()
{
    return $this->hasMany(Review::class);
}

    // Method untuk mendapatkan array gambar dari JSON
    public function getImagesArray()
    {
        if (empty($this->images)) {
            return [];
}
        return json_decode($this->images, true) ?: [];
    }
}
