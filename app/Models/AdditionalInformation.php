<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','phone', 'mobile', 'country', 'address', 'bio',
        'website','instragram', 'facebook', 'twitter', 'youtube'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
