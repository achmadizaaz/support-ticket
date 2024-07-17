<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory, HasUlids;

    protected $fillable = ['id', 'name', 'is_admin', 'level', 'guard_name'];
    
    // Scope
    public function scopeFilter($query, array $filters){
    $query->when($filters['search'] ?? false, function($query, $search){
        return $query->where('name', 'like', '%' . $search . '%') 
                ->orWhere('level', 'like', '%' . $search . '%');
    });
}
}
