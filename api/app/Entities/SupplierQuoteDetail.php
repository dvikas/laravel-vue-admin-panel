<?php

namespace App\Entities;

use App\Notifications\SupplierQuote;
use Illuminate\Database\Eloquent\Model;
use App\Support\UuidScopeTrait;
use Illuminate\Notifications\Notifiable;

class SupplierQuoteDetail extends Model
{
    use UuidScopeTrait;

    protected $guarded = ['id'];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
