<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'comment_id', 'path', 'name'];

    public function comments()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }
}
