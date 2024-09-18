<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'category_id', 'slug', 'no', 'subject', 'content', 'progress', 'status', 'created_by', 'updated_by'];

   // Scope
    public function scopeFilter($query, array $filters){
        $query->with(['user'])->when($filters['search'] ?? false, function($query, $search){
            return $query->whereAny(['no', 'subject', 'status'], 'LIKE', '%' . $search . '%')
            ->orWhereHas('user', function($query) use ($search){
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('category', function($query) use ($search){
                $query->where('name', 'like', '%' . $search . '%');
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'ticket_id');
    }
}
