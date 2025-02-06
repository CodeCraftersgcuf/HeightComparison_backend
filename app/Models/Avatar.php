<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    public function endomorph()
    {
        return $this->hasMany(AvatarEndomorph::class,'avatar_id');
    }

    // Define relationship with AvatarEctomorph
    public function ectomorph()
    {
        return $this->hasMany(AvatarEctomorph::class,'avatar_id');
    }

    // Define relationship with AvatarMesomorph
    public function mesomorph()
    {
        return $this->hasMany(AvatarMesomorph::class,'avatar_id');
    }
}
