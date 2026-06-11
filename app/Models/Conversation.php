<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $primaryKey = 'conversation_id';

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id', 'conversation_id');
    }
}