<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'date_of_birth', 'place_of_birth', 'gender', 'religion', 'phone', 'mobile', 'country', 'address', 'bio', 'website','instagram', 'facebook', 'twitter', 'youtube'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
