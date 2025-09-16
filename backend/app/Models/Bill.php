<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    // Заполняемые поля
    protected $fillable = [
        'creator_id',
        'total_sum',
        'payment_date',
        'description',
    ];

    // Временные метки
    protected $dates = [
        'created_at',
        'updated_at',
        'payment_date'
    ];

    // Связь с пользователем
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // Аксессор для форматирования суммы
    public function getTotalSumAttribute($value)
    {
        return number_format((float) $value, 2, '.', '');
    }

    // Мутатор для сохранения суммы
    public function setTotalSumAttribute($value)
    {
        $this->attributes['total_sum'] = (float) $value;
    }

    public function billItems()
    {
        return $this->hasMany(BillItem::class);
    }

    protected $appends = ['formatted_total_sum'];

    public function getFormattedTotalSumAttribute()
    {
        return '₽ ' . number_format($this->total_sum, 2, ',', ' ');
    }
    

    public function getStatusLabel()
    {
        $statuses = [
            'pending' => 'Ожидает оплаты',
            'paid' => 'Оплачен',
            'cancelled' => 'Отменен'
        ];

        return $statuses[$this->status] ?? 'Неизвестный статус';
    }
}
