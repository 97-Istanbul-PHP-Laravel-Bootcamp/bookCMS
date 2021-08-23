<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>
                    <form method="post" action="{{ route('admin.room.hfee') }}">
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        @csrf
                        @if ($term_)
                            @foreach ($term_ as $term)
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><i
                                                class="fa fa-table mr-2"></i>{{ $term->showDates() }}</h3>
                                    </div>
                                    @if ($room->hotel->board_x)
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Pansiyon</th>
                                                        <th>Yetişkin 12+</th>
                                                        <th>Çocuk 4-11</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($room->hotel->board_x as $board)
                                                        @php
                                                            $feeObj = $hfee_[$term->id][$board];
                                                        @endphp
                                                        <tr>
                                                            <td>{{ App\Models\Hotel::getBoardR($board) }}</td>
                                                            <td>
                                                                <x-pc
                                                                    name="fee_[{{ $term->id }}][{{ $board }}][adt_pc_]"
                                                                    prc="{{$feeObj->adt_prc}}"
                                                                    cid="{{$feeObj->adt_cid}}" />
                                                            </td>
                                                            <td>
                                                                <x-pc
                                                                    name="fee_[{{ $term->id }}][{{ $board }}][kid_pc_]"
                                                                    prc="{{$feeObj->kid_prc}}"
                                                                    cid="{{$feeObj->kid_cid}}" />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-danger">
                                            Bu otele ait pansiyon tipi seçilmemiştir.
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-success btn-block mt-2 mb-2">Fiyatları Kaydet</button>
                        @else
                            <div class="alert alert-danger">
                                Bu odaya ait geçerli bir dönem bulunmamaktadır. Lütfen dönem giriniz.
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
</section>
