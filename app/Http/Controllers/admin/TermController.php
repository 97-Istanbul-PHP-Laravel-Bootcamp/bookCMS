<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;

class TermController extends Controller
{
    public function edit(Request $request)
    {
        $data_ = [
            'title' => "Dönem Ekle/Düzenle",
            'term' => new Term()
        ];

        if ($request->get('term_id')) {
            $data_['term'] = Term::findOrFail($request->get('term_id'));
        }

        return view('admin.term.edit', $data_);
    }


    public function save(Request $request)
    {

        Term::updateOrCreate(
            ['id' => $request->id],
            [
                'obj' => $request->obj,
                'obj_id' => $request->obj_id,
                'strt_date' => $request->strt_date,
                'fnsh_date' => $request->fnsh_date,
                'status' => 'a'
            ]
        );

        return redirect()->route('admin.hotel');
    }

    public function delete(Request $request)
    {
        $term = Term::findOrFail($request->get('term_id'));
        $term->delete();

        return redirect()->route('admin.hotel');
    }
}
