<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Support\UuidScopeTrait;

class SupplierProjectTask extends Model
{
    use UuidScopeTrait;

    protected $guarded = ['id'];

    protected static function boot() {
        parent::boot();

        static::deleting(function($that) {
            $that->supplierQuoteDetails()->delete();
        });
    }

    public function supplierUserTask(){
        return $this->belongsTo(SupplierUserTask::class, 'supplier_user_task_id', 'id' )->select(array('id', 'uuid', 'name'));
    }

    public function supplierQuoteDetails(){
        return $this->hasMany(SupplierQuoteDetail::class, 'supplier_project_task_id', 'id' )
            ->select(array('id', 'uuid', 'supplier_id', 'user_notes', 'supplier_notes', 'supplier_rate',
                'supplier_total', 'sent_at', 'accepted_at', 'status'))->with('supplier');
    }
}
