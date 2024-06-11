<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
    protected $fillable = [
        // 'user_id',
        'name',
        'amount',
        'goal',
        'deadline',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
?> 
