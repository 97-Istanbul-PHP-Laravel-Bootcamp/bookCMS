@extends('admin.layout.default')

@section('title', $title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.hotel') }}">Oteller</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <form method="post" action="{{ route('admin.hotel.save') }}" enctype="multipart/form-data">
                            @csrf
                            @if ($hotel)
                                <input type="hidden" name="id" value="{{ $hotel->id }}">
                            @endif

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Partner</label>
                                    <x-select name="partner_id" selected="{{ $hotel->partner_id }}" :list=$partner_ />
                                </div>

                                <div class="form-group">
                                    <label>Lokasyon</label>
                                    <x-select name="location_id" selected="{{ $hotel->location_id }}" :list=$location_ />
                                </div>

                                <div class="form-group">
                                    <label>Otel Adı</label>
                                    <input type="text" class="form-control" name="name" value="{{ $hotel->name }}"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>Adres</label>
                                    <textarea class="form-control" rows="3" name="info_s[address]"
                                        placeholder="Otele ait tam adresi">{{ $hotel->info_s['address'] }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Web Sitesi</label>
                                    <input type="text" class="form-control" name="info_s[website]"
                                        value="{{ $hotel->info_s['website'] }}">
                                </div>

                                <div class="form-group">
                                    <label>E-posta</label>
                                    <input type="text" class="form-control" name="info_s[email]"
                                        value="{{ $hotel->info_s['email'] }}">
                                </div>

                                <div class="form-group">
                                    <label>Telefon</label>
                                    <input type="text" class="form-control" name="info_s[phone]"
                                        value="{{ $hotel->info_s['phone'] }}">
                                </div>

                                <div class="form-group">
                                    <label>Yıldız</label>
                                    <input type="number" class="form-control" name="star" value="{{ $hotel->star }}"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="fileUp">Resim Yükle</label>
                                    @foreach ($hotel->photo_s['gallery_'] as $key => $value)
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="gallery_[]"
                                                    class="custom-file-input" id="fileUp" value="{{$value}}">
                                                <label class="custom-file-label" for="fileUp">Dosya Seç</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Resim Yükle</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="gallery_[]" class="custom-file-input" id="fileUp">
                                            <label class="custom-file-label" for="fileUp">Dosya Seç</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Resim Yükle</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Tesis Özellikleri</label>
                                    @foreach (App\Models\Hotel::getSpecR(true) as $key => $value)
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox"
                                                id="cbox-spec-{{ $key }}" value="{{ $key }}"
                                                name="spec_x[{{ $key }}]" @if (in_array($key, $hotel->spec_x)) checked="checked" @endif>
                                            <label for="cbox-spec-{{ $key }}" class="custom-control-label">
                                                {{ $value }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <label>Pansiyon Tipleri</label>
                                    @foreach (App\Models\Hotel::getBoardR(true) as $key => $value)
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox"
                                                id="cbox-board-{{ $key }}" value="{{ $key }}"
                                                name="board_x[{{ $key }}]" @if (in_array($key, $hotel->board_x)) checked="checked" @endif>
                                            <label for="cbox-board-{{ $key }}" class="custom-control-label">
                                                {{ $value }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Gönder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('custom_js')
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
