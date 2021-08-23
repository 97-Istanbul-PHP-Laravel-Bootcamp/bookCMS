@props([
    'list' => getCid_(),
    'name' => 'pc_',
    'prc' => '',
    'cid' => '1',
])

<div class="input-group">
    <input type="text" class="form-control" name="{{ $name }}[prc]" value={{ $prc }}>
    <div class="input-group-append">
        <select class="form-control" name="{{ $name }}[cid]">
            @forelse ($list as $key => $value)
                <option value="{{ $key }}" @if ($cid == $key) selected @endif>
                    {{ $value }}
                </option>
            @empty

            @endforelse
        </select>
    </div>
</div>
