<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillItem extends Model
{
    use HasFactory;

    protected $table = 'bill_items';

    protected $fillable = [
        'bill_id',
        'creator_id',
        'title',
        'category',
        'amount',
        'description',
    ];

    /**
     * Связь с родительским счетом
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    /**
     * Связь с пользователем-создателем
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
