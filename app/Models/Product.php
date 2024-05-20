<?php

namespace App\Models;

use App\Constant\UploadPathConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function setImageAttribute($value)
    {
        if ($value != null) {
            $this->attributes['image'] = UploadPathConstant::PRODUCT_IMAGE . $value;
        }
    }

    public function getImageAttribute()
    {
        return $this->attributes['image'] ?  URL::to('/') . '/' . $this->attributes['image'] : null;
    }

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
