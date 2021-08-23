@extends('admin.layout.default')

@section('title', $title)

@section('breadcrumb')
<li class="breadcrumb-item active">{{ $title }}</li>
@endsection


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header text-right">
                        <a href="{{ route('admin.hotel.edit') }}" class="btn btn-md btn-outline-secondary">+ Otel
                            Ekle</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="10">#</th>
                                    <th>Otel Adı</th>
                                    <th>Dönemler</th>
                                    <th>Odalar</th>
                                    <th width="115"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotelCursor as $hotel)
                                    <tr>
                                        <td>
                                            <i
                                                class="nav-icon far fa-circle text-{{ statusCSS($hotel->status) }}"></i>
                                        </td>
                                        <td>{{ $hotel->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.term.edit', ['obj' => 'HOTEL', 'obj_id' => $hotel->id]) }}"
                                                class="btn btn-sm btn-outline-primary j-modal">Ekle</a>
                                            @forelse ($term_[$hotel->id] as $term)
                                                <a href="{{ route('admin.term.edit', ['obj' => 'HOTEL', 'obj_id' => $hotel->id, 'term_id' => $term->id]) }}"
                                                    class="btn btn-outline-secondary btn-sm j-modal">{{ $term->showDates() }}</a>
                                            @empty

                                            @endforelse
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.room.edit', ['hotel_id' => $hotel->id]) }}"
                                                class="btn btn-sm btn-outline-primary">Ekle</a>
                                            @forelse ($hotel->getRoom as $room)
                                                <a href="{{ route('admin.room.edit', ['hotel_id' => $hotel->id, 'room_id' => $room->id]) }}"
                                                    class="btn btn-outline-secondary btn-sm">{{ $room->name }}</a>
                                            @empty

                                            @endforelse
                                        </td>
                                        <td style="text-align: right">
                                            <a href="{{ route('admin.hotel.edit', ['hotel_id' => $hotel->id]) }}"
                                                class="btn btn-outline-primary btn-md">
                                                <i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.hotel.delete', ['hotel_id' => $hotel->id]) }}"
                                                class="btn btn-outline-danger btn-md">
                                                <i class="fa fa-trash"></i></a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
