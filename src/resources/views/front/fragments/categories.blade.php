@if(!empty($categories) && count($categories))
<div class="row">
    <div class="col-12" style="margin-bottom: 15px;"><h3>Categories</h3></div>
    @foreach ($categories as $item)
        <div class="col-6" style="margin-bottom: 30px;">
            <div class="blockItem" style="padding: 0 0 20px; border: 1px solid #ccc; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
                @php
                    $img = !empty($item->images->prev) ? $item->images->prev : '';
                    empty($img) && !empty($item->images->full) ? $img = $item->images->full : false;
                    empty($img) ? $img = '/images/noImg.jpg' : false;
                @endphp
                <IMG src="{{ $img }}" style="display: block; width: 100%; height: 300px; object-position: 50%; object-fit: contain; background-color: {{ \Crghome\Shop\Helpers\HelperLibs::getTrumbColorImage($img, '#fff') }};" />
                <div class="h4" style="padding: 5px 15px 20px;">{{ $item->name }}</div>
                <a class="btn btn-success" href="{{ route('site.shop.category', $item) }}" style="margin: 0 15px;">Подробнее</a>
            </div>
        </div>
    @endforeach
</div>
@endif