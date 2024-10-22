<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BelongingWhatsappMessage extends Model
{
    use HasFactory;

    public function isSentSuccessfully()
    {
        return $this->is_sent && $this->failed_at === null;
    }

    public function isFailed()
    {
        return $this->is_sent && $this->failed_at != null;
    }
}
