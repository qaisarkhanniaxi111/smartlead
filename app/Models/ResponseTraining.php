<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseTraining extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reply_from_lead', 'ideal_sdr_response'];

}
