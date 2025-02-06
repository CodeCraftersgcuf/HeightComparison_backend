<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvatarEctomorph extends Model
{
    protected $table = 'avatars_ectomorphs';
    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }
}
