<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = "hotel";
    protected $guarded = [];

    protected $casts = [
        'info_s' => 'array',
        'photo_s' => 'array'
    ];


    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }
    public function getRoom()
    {
        return $this->hasMany(Room::class, 'hotel_id', 'id');
    }

    public static function getSpecR($obj = NULL, $prop = 'name')
    {
        $obj_ = [
            'parking' => [
                'name' => 'Ücretsiz Otopark',
            ],
            'wifi' => [
                'name' => 'Ücretsiz Wifi'
            ],
            'pool' => [
                'name' => 'Yüzme Havuzu'
            ],
            'gym' => [
                'name' => 'Fitness Center'
            ],
            'concierge' => [
                'name' => 'Otel Concierge'
            ],
            'spa' => [
                'name' => 'SPA Salonu'
            ],
            'room_service' => [
                'name' => '7/24 Oda Servisi'
            ]
        ];

        return getR($obj_, $obj, $prop);
    }

    public static function getBoardR($obj = NULL, $prop = 'name')
    {
        $obj_ = [
            'UAI' => array(
                'name' => "Ultra Herşey Dahil"
            ),
            'AI' => array(
                'name' => "Herşey Dahil"
            ),
            'BB' => array(
                'name' => "Oda Kahvaltı"
            ),
            'FB' => array(
                'name' => "Tam Pansiyon"
            ),
            'HB' => array(
                'name' => "Yarım Pansiyon"
            ),
            'OB' => array(
                'name' => "Sadece Yatak"
            ),
            'UAI_NOALC' => array(
                'name' => "Alkol Hariç Full credit"
            ),
            'FC' => array(
                'name' => "Full credit"
            )
        ];

        return getR($obj_, $obj, $prop);
    }


    public function setSpecXAttribute($value)
    {
        $this->attributes['spec_x'] = encodeX($value);
    }

    public function getSpecXAttribute($value)
    {
        return decodeX($value);
    }


    public function setBoardXAttribute($value)
    {
        $this->attributes['board_x'] =  encodeX($value);
    }

    public function getBoardXAttribute($value)
    {
        return decodeX($value);
    }
}
