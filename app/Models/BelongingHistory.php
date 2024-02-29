<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BelongingHistory extends Model
{
  use HasFactory;
  protected $table = 'belongings_history';

  protected $fillable = [
    'user_id',
    'item_id',
    'action_type',
    'action_date',
    'description',
  ];
  protected $dates = [
    'action_date',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
