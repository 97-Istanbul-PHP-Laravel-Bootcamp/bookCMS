<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hara;
use App\Models\Hbook;
use App\Models\Hfee;
use App\Models\Location;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HbookController extends Controller
{
    public function new(Request $request)
    {
        $data_ = [
            'title' => 'Yeni Rezervasyon',
            'location_' => Location::get_()
        ];

        return view('admin.hbook.new', $data_);
    }

    public function hara(Request $request)
    {
        $haraData_ = [
            'user_id' => Auth::user()->id,
            'location_id' => $request->location_id,
            'date' => date('Y-m-d'),
            'cin_date' => diex($request->cin_date),
            'cout_date' => diex($request->cout_date),
            'adt' => $request->adt,
            'kid' => $request->kid,
            'bby' => $request->bby,
        ];

        $hara = Hara::create($haraData_);
        $roomList_ = Hfee::hara($hara);
        $dateRange_ = getDatesFromRange($hara->cin_date, $hara->cout_date);

        $data_ = [
            'roomList' => $roomList_,
            'loc_' => Location::get_(),
            'hara' => $hara,
            'dateRange_' => $dateRange_
        ];


        return view('admin.hbook.hara', $data_);
    }

    public function info(Request $request)
    {
        $hara = Hara::findOrFail($request->hara_id);
        $room = Room::findOrFail($request->room_id);

        $roomList_ = Hfee::hara($hara);
        $selectRoom = $roomList_[$room->hotel_id]['room_'][$room->id];

        $gstCount =  $hara->adt + $hara->kid + $hara->bby;
        $data_ = [
            'hara' => $hara,
            'room' => $selectRoom,
            'board' => $request->board,
            'gstCount' => $gstCount
        ];

        return view('admin.hbook.info', $data_);
    }


    public function save(Request $request)
    {
        $hara = Hara::findOrFail($request->hara_id);
        $room = Room::findOrFail($request->room_id);

        $roomList_ = Hfee::hara($hara);
        $selectRoom = $roomList_[$room->hotel_id]['room_'][$room->id];

        $hbookData_['user_id'] = Auth::user()->id;
        $hbookData_['room_id'] = $room->id;
        $hbookData_['hotel'] = $room->hotel->name;
        $hbookData_['info_s'] = [
            'room_name' => $room->name,
            'room_info_' => $room->info_s,
            'loc_id' => $room->hotel->location_id,
            'loc_name' => $room->hotel->location->name,
            'hotel_id' => $room->hotel->id,
            'hotel_adr' => $room->hotel->info_s['address'],
            'hotel_phone' => $room->hotel->info_s['phone'],
            'hotel_mail' => $room->hotel->info_s['mail'],
            'hotel_star' => $room->hotel->star,
            'hara_id' => $hara->id,
            'note' => $request->note
        ];
        $hbookData_['prc'] = $selectRoom->fee_[$request->board];
        $hbookData_['cid'] = 1;
        $hbookData_['name'] = $request->name;
        $hbookData_['mail'] = $request->mail;
        $hbookData_['mpno'] = $request->mpno;
        $hbookData_['date'] = $hara->date;
        $hbookData_['cin_date'] = $hara->cin_date;
        $hbookData_['cout_date'] = $hara->cout_date;
        $hbookData_['gst_s'] = $request->gst_;
        $hbookData_['board'] = $request->board;

        $hbook = Hbook::create($hbookData_);

        // Code ürettik
        $hbook->code = generateCodeByID($hbook->id);
        $hbook->save();

        // mail gönderme fonksiyonu
        
        return redirect()->route('admin.hbook.new');
    }
}
