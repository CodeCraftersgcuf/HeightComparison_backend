<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvatarMesomorph extends Model
{
    protected $table = 'avatars_mesomorphs';
    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }
}
