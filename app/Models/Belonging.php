<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Belonging extends Model
{
  use HasFactory, Notifiable;
  protected $fillable = [
    'name',
    'email',
    'phone',
    'color',
    'status',
    'belonging_type_id',
    'belonging_size_id',
    'color_name',
    'notes',
    'slot_id',
    'code',
    'visitor_type_id',
    'added_by_id',
  ];

  public function size()
  {
    return $this->belongsTo(BelongingSize::class, 'belonging_size_id');
  }

  public function type()
  {
    return $this->belongsTo(BelongingType::class, 'belonging_type_id');
  }
  public function visitor()
  {
    return $this->belongsTo(VisitorType::class, 'visitor_type_id');
  }
  public function slot()
  {
    return $this->belongsTo(Slot::class);
  }

  public function whatsappMessage()
  {
    return $this->hasOne(BelongingWhatsappMessage::class);
  }
}
