<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_ACTIVE = 'Active';
    const STATUS_SUSPENDED = 'Suspended';
    const STATUS_CANCELED = 'Canceled';

    protected $fillable = [
        'order_id',
        'name',
        'email',
        'card_number',
        'card_exp_month',
        'card_exp_year',
        'plan_name',
        'plan_id',
        'price',
		'parent_id',
        'price_currency',
        'txn_id',
        'payment_type',
        'payment_status',
        'status',
        'receipt',
        'type',
        'user_id',
        'customer_id',
    ];

    /**
     * @return string
     */
    public function getBadgeClass(){
        switch ($this->status){
            case self::STATUS_ACTIVE:
                $badge = 'badge-success';
                break;
            case self::STATUS_SUSPENDED:
                $badge = 'badge-warning';
                break;
            case self::STATUS_CANCELED:
                $badge = 'badge-danger';
                break;
            default:
                $badge = "";
        }
        return $badge;
    }
}
