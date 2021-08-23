<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>
                    <form method="post" action="{{ route('admin.term.save') }}">
                        @csrf

                        @if ($term)
                            <input type="hidden" name="id" value="{{ $term->id }}">
                        @endif
                        <input type="hidden" name="obj_id" value="{{ request()->get('obj_id') }}">
                        <input type="hidden" name="obj" value="{{ request()->get('obj') }}">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Giriş Tarihi :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" name="strt_date" class="form-control j-datemask"
                                        data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy"
                                        data-mask required value="{{ $term->strt_date }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Çıkış Tarihi :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" name="fnsh_date" class="form-control j-datemask"
                                        data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy"
                                        data-mask required value="{{ $term->fnsh_date }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Gönder</button>
                            <a href="{{route('admin.term.delete' , ['term_id' => $term->id])}}" class="btn btn-md btn-danger" style="float: right" onclick="return areYouSureDelete()">Sil</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>


<script>
    $(function() {
        $('.j-datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
    })
</script>


