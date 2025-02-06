<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvatarEndomorph extends Model
{
    protected $table = 'avatars_endomorphs';
    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }
}
