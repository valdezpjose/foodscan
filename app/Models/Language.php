<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Language extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = "languages";
    protected $fillable = ['name', 'code', 'status', 'display_mode'];
    protected $casts = [
        'id'     => 'integer',
        'name'   => 'string',
        'code'   => 'string',
        'display_mode'  => 'integer',
        'status' => 'integer',
    ];

    public function getImageAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('language'))) {
            return asset($this->getFirstMediaUrl('language'));
        }
        return asset('images/item/thumb.png');
    }
}