<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * マスアサインメント許可属性
     */
    protected $fillable = [
        'name',
    ];

    /**
     * 多対多リレーション（Tag -> Contact）
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class)->withTimestamps();
    }
}
