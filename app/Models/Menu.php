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
        'available',
        'flavor'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Method untuk mendapatkan rating rata-rata
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    // Method untuk mendapatkan jumlah review
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
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
