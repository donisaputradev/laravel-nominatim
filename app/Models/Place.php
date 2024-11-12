<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id'];

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
