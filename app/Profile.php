<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $primaryKey = 'profile_id';
    protected $table = 'profiles';
    protected $fillable = ['user_id', 'bio', 'phone', 'address','image'];

    public function user()
    {
        return $this->belongsTo('User');
    }
}
