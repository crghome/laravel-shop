@if(!empty($products) && count($products))
<div class="row">
    <div class="col-12" style="margin-bottom: 15px;"><h3>Products</h3></div>
    @foreach ($products as $item)
        <div class="col-4" style="margin-bottom: 30px;">
            <div class="blockItem" style="border: 1px solid #ccc; box-shadow: 0 3px 10px rgba(0,0,0,0.15); height: 100%;">
                @php
                    $img = !empty($item->images->prev) ? $item->images->prev : '';
                    empty($img) && !empty($item->images->full) ? $img = $item->images->full : false;
                    empty($img) ? $img = '/images/noImg.jpg' : false;
                @endphp
                <a href="{{ route('site.shop.product', $item) }}"><IMG src="{{ $img }}" style="display: block; width: 100%; height: 300px; object-position: 50%; object-fit: contain; background-color: {{ \Crghome\Shop\Helpers\HelperLibs::getTrumbColorImage($img, '#fff') }};" /></a>
                <div style="padding: 15px 15px 25px;">
                    <div class="h4" style="margin: 0 0 25px;"><a href="{{ route('site.shop.product', $item) }}">{{ $item->name }}</a></div>
                    <div class="h5" style="margin: 0 0 25px;">
                        @if(!empty($item->price))
                            @if(!empty($item->suffixPrice)){{ $item->suffixPrice }} @endif
                            @if(!empty($item->price_old))<span style="text-decoration: line-through; font-size: 14px;">{{ $item->price_old }}</span> @endif
                            <span>{{ number_format($item->price, 0, '.', ' ') }}</span> руб
                        @endif
                    </div>
                    <div style="margin: 0 0 15px; height: 146px; overflow: hidden;">{!! $item->prevText !!}</div>
                    <div style="display: flex; column-gap: 10px;">
                        <a class="btn btn-default" href="{{ route('site.shop.product', $item) }}" style="">Cart</a>
                        <a class="btn btn-success" href="{{ route('site.shop.product', $item) }}" style="">Buy</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif