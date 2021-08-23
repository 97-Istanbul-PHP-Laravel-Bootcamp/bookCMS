@extends('admin.layout.default')

@section('title', $title)

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-body">
                    <form id="j-hara-form" method="post" action="{{ route('admin.hbook.hara') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Konum</label>
                                    <x-select name="location_id" :list=$location_ />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Giriş Tarihi</label>
                                    <input type="text" class="form-control j-datepicker" name="cin_date">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Çıkış Tarihi</label>
                                    <input type="text" class="form-control j-datepicker" name="cout_date">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Misafir Bilgisi</label>
                                    <span id="j-gst-select-btn" class="btn btn-sm btn-block"
                                        style="border:1px solid #ced4da; line-height:28px; text-align:left; ">
                                        1 Yetişkin
                                    </span>
                                </div>
                                <div style="display: none">
                                    <div id="j-gst-select">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Misafir Seç</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Yetişkin (12+)</label>
                                                    <select name="adt" class="form-control">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Çocuk (2-12)</label>
                                                    <select name="kid" class="form-control">
                                                        <option>0</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bebek</label>
                                                    <select name="bby" class="form-control">
                                                        <option>0</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn btn-primary btn-block j-gst-btn">Seç</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-block" value="Otel Ara">
                        </div>
                    </form>
                </div>
            </div>

            <div id="j-hara-response">
                
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script>
        $(function() {
            $.datetimepicker.setLocale('tr');
            $('.j-datepicker').datetimepicker({
                timepicker: false,
                format: 'd/m/Y',
                mask: true
            });

            $('#j-gst-select-btn').colorbox({
                inline: true,
                href: "#j-gst-select"
            });

            $('.j-gst-btn').on('click', function() {
                var adt = $('select[name=adt]').val();
                var kid = $('select[name=kid]').val();
                var bby = $('select[name=bby]').val();
                var txt_ = [];

                txt_.push(adt + ' Yetişkin');
                if (kid > 0) {
                    txt_.push(kid + ' Çocuk');
                }

                if (bby > 0) {
                    txt_.push(bby + ' Bebek');
                }

                $('#j-gst-select-btn').text(txt_.join(', '));

                $.colorbox.close();
            });

            var $haraForm = $('#j-hara-form');

            $haraForm.submit(function(){
                $haraForm.ajaxSubmit({
                    success : function(responseText){
                        $('#j-hara-response').html(responseText);
                    }
                });
                return false;
            });
        });
    </script>
@endsection
