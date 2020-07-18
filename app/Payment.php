<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
	use Notifiable;

    protected $table = 'payments';

    protected $fillable = [
    	'name', 'email', 'is_active'
    ];
}
