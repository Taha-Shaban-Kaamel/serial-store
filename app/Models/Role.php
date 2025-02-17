<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name','label'];
    public function abilities(){
        return $this->belongsToMany(Ability::class , 'role_ability')->withTimestamps();
    }
    public function allowTo($ability){
        $this->abilities()->save($ability);
    }
}

// abillity -> Role
// Role -> abillity
