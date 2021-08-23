<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Location;
use App\Models\Partner;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        $data_ = [
            'title' => 'Oteller',
            'hotelCursor' => Hotel::where('status', '<>', 't')->paginate(10),
        ];

        $termCursor = Term::where('status', 'a')->where('obj', 'HOTEL')->get();

        foreach ($termCursor as $term) {
            $data_['term_'][$term->obj_id][] = $term;
        }
        return view('admin.hotel.index', $data_);
    }

    public function edit(Request $request)
    {
        $data_ = [
            'title' => "Otel Ekle/Düzenle",
            'partner_' => Partner::get_(),
            'location_' => Location::get_()
        ];

        $data_['hotel'] = new Hotel();

        if ($request->input('hotel_id')) {
            $data_['hotel'] = Hotel::findOrFail($request->input('hotel_id'));
        }

        return view('admin.hotel.edit', $data_);
    }

    public function save(Request $request)
    {


        if ($request->hasFile('gallery_')) {
            foreach ($request->file('gallery_') as $file) {
                if ($file->isValid()) {
                    $gallery_[]= $file->getClientOriginalName();
                    $file->storeAs('/public/img', $file->getClientOriginalName());
                }
            }
        }

        $hotel = Hotel::updateOrCreate(
            ['id' => $request->id],
            [
                'partner_id' => $request->partner_id,
                'location_id' => $request->location_id,
                'name' => $request->name,
                'info_s' => $request->info_s,
                'star' => $request->star,
                'spec_x' => $request->spec_x,
                'board_x' => $request->board_x,
                'photo_s' => ['gallery_' => $gallery_]
            ]
        );

        return redirect()->route('admin.hotel');
    }

    public function delete(Request $request)
    {
    }
}
