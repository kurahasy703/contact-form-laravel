<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * マスアサインメント許可属性
     */
    protected $fillable = [
        'content',
    ];

    /**
     * 1対多リレーション（Category -> Contact）
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
