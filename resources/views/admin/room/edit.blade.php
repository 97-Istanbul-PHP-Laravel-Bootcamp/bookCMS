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
                    @if ($room->id)
                        <div class="mt-2 mb-2">
                            <a href="#" class="btn btn-md btn-danger">Odayı sil</a>
                            <a href="{{ route('admin.room.hfee', ['room_id' => $room->id]) }}"
                                class="btn btn-md btn-primary j-modal">Fiyatları
                                Güncelle</a>
                        </div>
                    @endif
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <form method="post" action="{{ route('admin.room.save') }}">
                            @csrf
                            @if ($room)
                                <input type="hidden" name="id" value="{{ $room->id }}">
                                <input type="hidden" name="hotel_id" value="{{ $room->hotel_id }}">
                            @endif

                            @if ($hotel)
                                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                            @endif

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Durum</label>
                                    <x-status selected="{{ $room->status }}" />
                                </div>
                                <div class="form-group">
                                    <label>Oda Adı</label>
                                    <input type="text" name="name" class="form-control" value="{{ $room->name }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Stok Sayısı</label>
                                    <input type="text" name="stock" class="form-control" value="{{ $room->stock }}">
                                </div>
                                <div class="form-group">
                                    <label>Oda Özellikleri</label>
                                    <div class="row">
                                        @foreach (App\Models\Room::getRoomSpecR(true) as $key => $value)
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <input type="number" name="info_s[{{ $key }}]"
                                                        class="form-control" min="0" value="{{ $room->info_s[$key] }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">{{ $value }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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
