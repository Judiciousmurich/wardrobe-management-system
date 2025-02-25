<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClothingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'color',
        'size',
        'brand',
        'purchase_date',
        'notes',
        'image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_date' => 'date',
    ];

    /**
     * Get the user that owns the clothing item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}