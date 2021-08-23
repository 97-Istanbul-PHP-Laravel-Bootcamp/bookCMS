<style>
    .w-room-list {
        padding: 15px 15px 15px 15px;
        border: 1px solid #3598dc;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
    }

</style>
@php
use App\Models\Hotel;
use App\Models\Room;
@endphp
<div class="row mt-3">
    <div class="col-sm-12">
        @if ($roomList)
            @foreach ($roomList as $data_)
                @php
                    $hotel = $data_['hotel'];
                    $room_ = $data_['room_'];
                @endphp
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 class="font-weight-bold text-primary">{{ $hotel->name }}</h3>
                        <h5 class="font-weight-bold text-primary"><i class="fa fa-info-circle"></i> Otel Bilgileri</h5>
                        <p class="card-text">
                            <span class="mr-2"><span class="font-weight-bold">Konum</span> :
                                {{ $loc_[$hotel->location_id] }}</span>
                            <span class="mr-2"><span class="font-weight-bold">Adres</span> :
                                {{ $hotel->info_s['address'] }}</span>
                            <span class="mr-2"><span class="font-weight-bold">Telefon</span> :
                                {{ $hotel->info_s['phone'] }}</span>
                        </p>
                        <h5 class="font-weight-bold text-primary"><i class="fa fa-info-circle"></i> Otel Hizmetleri</h5>
                        <p class="card-text">
                            @foreach ($hotel->spec_x as $spec)
                                <span class="mr-2"><i class="far fa-check-circle  text-success"></i>
                                    {{ Hotel::getSpecR($spec) }}</span>
                            @endforeach
                        </p>
                        <hr class="sm" />
                        @foreach ($room_ as $room)
                            <div class="w-room-list mb-4">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="text-primary font-weight-bold">{{ $room->name }}</h4>
                                        <hr class="sm">
                                        <div class="font-weight-bold">
                                            <i class="fas fa-angle-double-right"></i> Giriş Tarihi :
                                            {{ diex($hara->cin_date) }}<br>
                                            <i class="fas fa-angle-double-right"></i> Çıkış Tarihi :
                                            {{ diex($hara->cout_date) }} <br>
                                            <i class="fas fa-angle-double-right"></i>
                                            {{ $hara->adt }} Yetişkin <br>
                                            @if ($hara->kid > 0)
                                                <i class="fas fa-angle-double-right"></i>
                                                {{ $hara->kid }} Çocuk <br>
                                            @endif
                                            @if ($hara->bby > 0)
                                                <i class="fas fa-angle-double-right"></i>
                                                {{ $hara->bby }} Bebek <br>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <h4 class="text-primary font-weight-bold">Oda Bilgileri</h4>
                                        <hr class="sm">
                                        @foreach ($room->info_s as $spec => $value)
                                            <span class="mr-2"> <span
                                                    class="font-weight-bold">{{ Room::getRoomSpecR($spec) }}</span>
                                                : {{ $value }} {{ Room::getRoomSpecR($spec, 'text') }}</span>
                                        @endforeach
                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <h4 class="blue sbold">{{ count($dateRange_) - 1 }} Gece İçin</h4>
                                        <hr class="sm">
                                        @foreach ($room->fee_ as $board => $fee)
                                            <div>{{ Hotel::getBoardR($board) }} : {{ $fee }} TL</div>
                                        @endforeach
                                    </div>
                                </div>
                                <form method="post" action="{{ route('admin.hbook.info') }}" style="margin-top: 10px"
                                    class="text-right j-hbook-hara-form">
                                    @csrf
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <input type="hidden" name="hara_id" value="{{ $hara->id }}">
                                    <div style="display: inline-block; width: 330px;">
                                        <div class="input-group">
                                            <select name="board" class="form-control">
                                                @foreach ($room->fee_ as $board => $fee)
                                                    <option value="{{ $board }}">
                                                        {{ Hotel::getBoardR($board) }} </option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary ">Rezervasyon Yap</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-danger ">
                <h5><i class="icon fas fa-ban"></i> Oda Bulunamadı!</h5>
                İstemiş olduğunuz tarihler arasında uygun bir oda bulunamadı !!
            </div>
        @endif

    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('.j-hbook-hara-form').ajaxForm({
            target: "#j-hara-response"
        });
    });
</script>
