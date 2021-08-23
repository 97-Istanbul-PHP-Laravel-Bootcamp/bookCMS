<style>
    .mb-5 {
        margin-bottom: 5px !important;
    }

    .well {
        background: #dae0e9;
    }

    .well-sm {
        padding: 10px;
    }

    .well {
        border: 0;
        padding: 20px;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }

</style>
<div class="row mt-3">
    <div class="col-sm-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form method="post" action="{{ route('admin.hbook.save') }}" class="form-horizontal"
                    id="j-hbook-info-form">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="hara_id" value="{{ $hara->id }}">
                    <input type="hidden" name="board" value="{{ $board }}">

                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-primary"><i class="fas fa-rss-square"></i> İletişim Bilgileri</h4>
                            <div class="mb-15">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Ad Soyad</label>
                                            <input name="name" type="text" class="form-control required" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Telefon</label>
                                            <input name="mpno" type="text" class="form-control required" value="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>E-Posta</label>
                                            <input name="mail" type="text" class="form-control required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-primary"><i class="far fa-check-square"></i> Ekstra Bilgiler</h4>
                            <div class="form-group">
                                <label>Rezervasyon Notu</label>
                                <textarea name="note" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-primary"><i class="fas fa-users"></i> Misafir Bilgileri</h4>
                            @for ($i = 1; $i <= $hara->adt; $i++)
                                <div class="well well-sm mb-5">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div style="font-size: 18px; padding-top: 5px;">{{ $i }}.
                                                Yetişkin
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <input name="gst_[adt][{{ $i }}][name]" type="text"
                                                class="form-control required" placeholder="Ad Soyad" />
                                        </div>

                                        <div class="col-sm-4">
                                            <input name="gst_[adt][{{ $i }}][idno]" type="text"
                                                class="form-control required" placeholder="Kimlik/Pasaport No" />
                                        </div>
                                    </div>
                                </div>
                            @endfor
                            @for ($i = 1; $i <= $hara->kid; $i++)
                                <div class="well well-sm mb-5">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div style="font-size: 18px; padding-top: 5px;">{{ $i }}.
                                                Çocuk
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <input name="gst_[kid][{{ $i }}][name]" type="text"
                                                class="form-control required" placeholder="Ad Soyad" />
                                        </div>

                                        <div class="col-sm-4">
                                            <input name="gst_[kid][{{ $i }}][idno]" type="text"
                                                class="form-control required" placeholder="Kimlik/Pasaport No" />
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            @for ($i = 1; $i <= $hara->bby; $i++)
                                <div class="well well-sm mb-5">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div style="font-size: 18px; padding-top: 5px;">{{ $i }}.
                                                Bebek
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <input name="gst_[bby][{{ $i }}][name]" type="text"
                                                class="form-control required" placeholder="Ad Soyad" />
                                        </div>

                                        <div class="col-sm-4">
                                            <input name="gst_[bby][{{ $i }}][idno]" type="text"
                                                class="form-control required" placeholder="Kimlik/Pasaport No" />
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-primary"><i class="fas fa-calculator"></i> Ücret Bilgisi</h4>
                            <table class="table table-stripped table-bordered mb-10">
                                <thead>
                                    <tr>
                                        <th><span class="small">Pansiyon</span></th>
                                        <th class="text-right"><span class="small">Kişi Sayısı</span></th>
                                        <th class="text-right"><span class="small">Toplam Fiyat</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="bold">{{ App\Models\Hotel::getBoardR($board) }}</div>
                                        </td>
                                        <td>
                                            <div class="bold text-right">{{ $gstCount }} Kişi</div>
                                        </td>
                                        <td>
                                            <div class="bold text-right">{{ $room->fee_[$board] }} TL</div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-2 mb-2">
                        <i class="far fa-paper-plane fa-fw"></i> Rezervasyon Yap </button>
                </form>
            </div>
        </div>
    </div>
</div>
