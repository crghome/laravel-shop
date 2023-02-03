@if (!empty($pictures))
<div id="stats-widget-slider-2" class="carousel slide" data-ride="carousel" data-interval="8000">
    <!--begin::Top-->
    <div class="d-flex align-items-center justify-content-between flex-wrap">
        <!--begin::Label-->
        <span class="font-size-h6 text-muted font-weight-bolder text-uppercase pr-2">Картинки</span>
        <!--end::Label-->
        <!--begin::Action-->
        <div class="p-0">
            <a href="#stats-widget-slider-2" class="btn btn-icon btn-light btn-sm mr-1" role="button" data-slide="prev">
                <span class="svg-icon svg-icon-md">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-left.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999)"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </a>
            <a href="#stats-widget-slider-2" class="btn btn-icon btn-light btn-sm" role="button" data-slide="next">
                <span class="svg-icon svg-icon-md">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-right.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </a>
        </div>
        <!--end::Action-->
    </div>
    <!--end::Top-->
    <!--begin::Carousel-->
    <div class="carousel-inner pt-9">
        @foreach ($pictures as $k => $image)
            @php
                empty($image) ? $image = config('app.no_image') : false;
            @endphp
            <!--begin::Item-->
            <div class="carousel-item @if($k == 0) active @endif overlay">
                <!--begin::Section-->
                {{-- <div class="d-flex flex-column justify-content-between h-100">
                    <!--begin::Title-->
                    <h3 class="font-size-h4 text-dark-75 text-hover-primary font-weight-bold cursor-pointer">{{ $item->name }}</h3>
                    <!--end::Title-->
                    <img src="{{ $item->images->full??config('app.no_image') }}" alt="" class="w-100 rounded">
                    <!--begin::Text-->
                    <p class="text-dark-75 font-size-lg font-weight-normal pt-2 mb-0">To start a blog, think of a topic about and first brainstorm ways to write details</p>
                    <!--end::Text-->
                </div> --}}
                <!--end::Section-->
                <div class="overlay-wrapper">
                    <img src="{{ $image }}" alt="" class="w-100 rounded" style="height: 40vw; object-fit: cover;">
                </div>
                <div class="overlay-layer m-5 rounded align-items-start justify-content-end" style="opacity: 1;">
                    <div class="d-flex flex-column align-items-start mt-5 mr-5">
                        <span class="font-size-h4 font-weight-bolder bg-danger p-2 rounded text-white text-hover-primary">{{ $image }}</span>
                        {{-- <span class="font-size-h5 font-weight-bolder text-white mt-2">{{ $item->sliderSlideContent[0]?->descr??'' }}</span> --}}
                    </div>
                </div>
            </div>
            <!--end::Item-->
        @endforeach
    </div>
    <!--end::Carousel-->
</div>
@endif