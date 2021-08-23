<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\VarDumper;

class Hfee extends Model
{
    use HasFactory;

    protected $table = "hfee";
    protected $guarded = [];
    public $timestamps = false;


    public static function getFeeByRoom($room_id)
    {
        $hfeeCursor = Hfee::where('room_id', $room_id)->get();

        foreach ($hfeeCursor as $hfee) {
            $res_[$hfee->term_id][$hfee->board] = $hfee;
        }

        return $res_;
    }

    public static function hara($hara)
    {

        /**
        $hotelCursor = Hotel::where('status' , 'a')->where('location_id' , $hara->location_id)->get();
        foreach($hotelCursor as $hotel){
            $room_[] = $hotel->getRoom;
        }
         */

        $room_ = DB::table('room')
            ->select()
            ->whereRaw("hotel_id IN (SELECT id FROM hotel WHERE location_id = ? AND status='a')", $hara->location_id)
            ->get();


        // 1 - Eğer hbook->cin_date >= hara->cin_date VE hbook->cout_date <= hara->cout_date
        // 2 - Eğer hbook->cin_date <= hara->cin_date VE hbook->cout_date >= hara->cout_date
        // 3 - Eğer hbook->cin_date <= hara->cout_date VE hbook->cout_date >= hara->cin_date

        $dateSQL_ = [
            '(cin_date >="' . $hara->cin_date . '" AND cout_date <= "' . $hara->cout_date . '")',
            '(cin_date <="' . $hara->cin_date . '" AND cout_date >= "' . $hara->cout_date . '")',
            '(cin_date <="' . $hara->cout_date . '" AND cout_date >= "' . $hara->cin_date . '")',
        ];

        $hbook_ = DB::table('hbook')->select('room_id', DB::raw('COUNT(*) AS _cnt'))
            ->whereRaw(implode(' OR ', $dateSQL_))
            ->where('status', 'a')
            ->groupBy('room_id')
            ->get();


        foreach ($hbook_ as $row) {
            $stock_[$row->room_id] = $row->_cnt;
        }
      
        foreach ($room_ as $room) {
            if (array_key_exists($room->id, $stock_)) {
                if ($room->stock - $stock_[$room->id] >= 1) {
                    $room_id_[] = $room->id;
                }
            } else {
                $room_id_[] = $room->id;
            }
        }

        $roomCursor = Room::findMany($room_id_);

        foreach ($roomCursor as $room) {
            $room->fee_ = Hfee::calcFee($room, $hara);
            if ($room->fee_) {
                $result_[$room->hotel_id]['hotel'] = $room->hotel;
                $result_[$room->hotel_id]['room_'][$room->id] = $room;
            }
        }


        return $result_;
    }


    public static function calcFee($room, $hara)
    {
        $date_ = getDatesFromRange($hara->cin_date, $hara->cout_date);

        $totalPrc_ = null;

        foreach ($date_ as $key => $date) {
            $fee_ = Hfee::search($room, $date);


            // Yetişkin Sayısı
            for ($i = 1; $i <= $hara->adt; $i++) {
                foreach ($fee_ as $board => $hfeeObj) {
                    $totalPrc_[$board] += $hfeeObj->adt_prc;
                }
            }

            // Çocuk Sayısı
            for ($i = 1; $i <= $hara->kid; $i++) {
                foreach ($fee_ as $board => $hfeeObj) {
                    $totalPrc_[$board] += $hfeeObj->kid_prc;
                }
            }
        }

        return $totalPrc_;
    }

    public static function search($room, $date)
    {
        $term = DB::table('term')->select()
            ->where('obj', 'HOTEL')
            ->where('obj_id', $room->hotel_id)
            ->where('strt_date', '<=', $date)
            ->where('fnsh_date', '>=', $date)->first();

        if (!$term->id) {
            return false;
        }

        $hfeeCursor = Hfee::where('term_id', $term->id)
            ->where('room_id', $room->id)
            ->get();

        foreach ($hfeeCursor as $hfee) {

            $hfee->term = $term;

            $hfee_[$hfee->board] = $hfee;
        }

        return $hfee_;
    }
}
