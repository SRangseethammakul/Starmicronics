<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class warranty_system extends Model
{
    protected $table = 'warranty_systems';
    protected $primaryKey = 'id';
    protected $fillable = [
        'serial_number',
        'good_group',
        'good_code',
        'good_description',
        'cartoon',
        'shipped_qty',
        'invoice',
        'customer',
        'shipped_date',
        'location',
        'expired_date',
        'Warranty'
    ];
    public $timestamps = false;
}

