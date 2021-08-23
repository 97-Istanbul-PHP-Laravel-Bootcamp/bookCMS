<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = "room";
    protected $guarded = [];

    protected $casts = [
        'info_s' => 'array'
    ];

    public function hotel()
    {
        return $this->hasOne(Hotel::class, 'id', 'hotel_id');
    }

    public static function getRoomSpecR($obj = NULL, $prop = 'name')
    {
        $obj_ = array(
            'bed' => array(
                'name' => "Yatak",
                'text' => 'Adet',
            ),
            'tv' => array(
                'name' => "Televizyon",
                'text' => 'Adet',
            ),
            'minibar' => array(
                'name' => "Minibar",
                'text' => 'Adet',

            ),
            'game_console' => array(
                'name' => "Oyun Konsolu",
                'text' => 'Adet',
            ),
            'dimension' => array(
                'name' => "M2",
                'text' => 'm2',
            ),
            'locker' => array(
                'name' => "Kasa",
                'text' => 'Adet',
            ),
            'projector' => array(
                'name' => "Projeksiyon",
                'text' => 'Adet',
            )
        );

        return getR($obj_, $obj, $prop);
    }

    public function setInfoSAttribute($value)
    {
        $value = array_filter($value, function ($v) {
            return !is_null($v) && $v !== '';
        });
        $this->attributes['info_s'] = $value;
    }
}
