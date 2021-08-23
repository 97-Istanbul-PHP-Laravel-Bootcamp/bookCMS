<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hfee;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Term;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function edit(Request $request)
    {
        $data_ = [
            'title' => 'Oda Ekle Düzenle',
            'room' => new Room(),
        ];

        if ($request->get('room_id')) {
            $data_['room'] = Room::findOrFail($request->get('room_id'));
        }

        if ($request->get('hotel_id')) {
            $data_['hotel'] = Hotel::findOrFail($request->get('hotel_id'));
        }


        return view('admin.room.edit', $data_);
    }


    public function save(Request $request)
    {

        $room = Room::updateOrCreate(
            ['id' => $request->id],
            [
                'hotel_id' => $request->hotel_id,
                'status' => $request->status,
                'name' => $request->name,
                'info_s' => $request->info_s,
                'stock' => $request->stock,
            ]
        );

        return redirect()->route('admin.room.edit', ['room_id' => $room->id]);
    }


    public function hfee(Request $request)
    {

        $room = Room::findOrFail($request->get('room_id'));
        $term_ = Term::where('obj', 'HOTEL')->where('obj_id', $room->hotel_id)->get();
        $hfee_ = Hfee::getFeeByRoom($room->id);

        $data_ = [
            'title' => 'Fiyat Düzenle',
            'room' => $room,
            'term_' => $term_,
            'hfee_' => $hfee_
        ];

        return view('admin.room.hfee', $data_);
    }


    public function hfeeSave(Request $request)
    {
        $room = Room::findOrFail($request->room_id);
        Hfee::where('room_id' , $room->id)->delete();

        foreach ($request->fee_ as $term_id => $term_) {
            foreach ($term_ as $boardKey => $boardFee_) {
                if (is_null($boardFee_['adt_pc_']['prc']) || empty($boardFee_['adt_pc_']['prc'])) {
                    continue;
                }

                Hfee::create([
                    'term_id' => $term_id,
                    'room_id' => $room->id,
                    'hotel_id' => $room->hotel->id,
                    'board' => $boardKey,
                    'adt_prc' => $boardFee_['adt_pc_']['prc'],
                    'adt_cid' => $boardFee_['adt_pc_']['cid'],
                    'kid_prc' => $boardFee_['kid_pc_']['prc'],
                    'kid_cid' => $boardFee_['kid_pc_']['cid'],
                ]);
            }
        }

        return redirect()->route('admin.room.edit', ['room_id' => $room->id]);
    }
}
