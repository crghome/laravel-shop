@isset($client)
@php
    $clientPhoto = !empty($client?->images?->prev) && file_exists(public_path() . '/' . $client->images?->prev) ? $client->images->prev : '';
    empty($clientPhoto) && !empty($client?->images?->full) && file_exists(public_path() . '/' . $client->images?->full) ? $clientPhoto = $client->images?->full : false;
    empty($clientPhoto) ? $clientPhoto =  '/img/noImgUser.jpg' : false;
@endphp
<!--begin::Top-->
<div class="d-flex">
    <!--begin::Pic-->
    <div class="flex-shrink-0 mr-7">
        <div class="symbol symbol-50 symbol-lg-120">
            <img alt="Pic" src="{{ $clientPhoto }}" style="object-fit: cover;">
        </div>
    </div>
    <!--end::Pic-->
    <!--begin: Info-->
    <div class="flex-grow-1">
        <!--begin::Title-->
        <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
            <!--begin::User-->
            <div class="mr-3">
                <!--begin::Name-->
                <p href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3"><span class="text-muted font-weight-bold mr-lg-8 mr-2 mb-lg-0"><span class="mr-1"><i class="text-success  @if($client->moderated) fas fa-user-check @else fas fa-user-alt-slash @endif "></i></span></span>{{ $client->name }}</p>
                <p class="d-flex align-items-center text-dark font-size-h6 font-weight-bold mr-3">{{ $client->login }} {{ $client->last_name }} {{ $client->patronymic }}</p>
                <!--end::Name-->
                <!--begin::Contacts-->
                <div class="d-flex flex-wrap my-2">
                    {{-- <span href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"><span class="mr-1"><i class="text-success  @if($client->moderated) fas fa-user-check @else fas fa-user-alt-slash @endif "></i></span></span> --}}
                    <a href="mailto:{{ $client->email??'---' }}" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2" target="_blank"><span class="mr-1"><i class="text-black-25 fas fa-mail-bulk"></i></span>{{ $client->email??'---' }}</a>
                    <a href="tel:{{ $client->phone??'---' }}" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2" target="_blank"><span class="mr-1"><i class="text-black-25 fas fa-phone-alt"></i></span>{{ $client->phone??'---' }}</a>
                </div>
                <!--end::Contacts-->
            </div>
            <!--begin::User-->
            <!--begin::Actions-->
            @isset($pageBtnAction)
            <div class="my-lg-0 my-1">
                @foreach(($pageBtnAction??[]) AS $item)
                    <a href="{{ $item->href }}" class="btn btn-sm {{ $item->class }} font-weight-bolder mr-2">{{ $item->text }}</a>
                @endforeach
            </div>
            @endisset
            <!--end::Actions-->
        </div>
        <!--end::Title-->
        <!--begin::Content-->
        <div class="d-flex align-items-center flex-wrap justify-content-between">
            <!--begin::Description-->
            {{-- <div class="flex-grow-1 font-weight-bold text-dark-50 py-2 py-lg-2 mr-5">
                {{ implode(', ', (array_map(function($it){ return $it['name']; }, $client->roles?->toArray()??[]))) }}<br>
                {{ implode(', ', (array_map(function($it){ return $it['name']; }, $client->permissions?->toArray()??[]))) }}
            </div> --}}
            <!--end::Description-->
            <!--begin::Progress-->
            {{-- <div class="d-flex mt-4 mt-sm-0">
                <span class="font-weight-bold mr-4">Progress</span>
                <div class="progress progress-xs mt-2 mb-2 flex-shrink-0 w-150px w-xl-250px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progres = rand(0, 100) }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="font-weight-bolder text-dark ml-4">{{ $progres }}%</span>
            </div> --}}
            <!--end::Progress-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Info-->
</div>
<!--end::Top-->
<!--begin::Separator-->
<div class="separator separator-solid my-7"></div>
<!--end::Separator-->
<!--begin::Bottom-->
<div class="d-flex align-items-center flex-wrap">
    <!--begin: Item-->
    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
        <span class="mr-4">
            <span class="fas fa-building"></span>
            <span class="font-bold">адрес:</span>
        </span>
        <div class="d-flex flex-column text-dark-75">
            {{ $item->address??'---' }}
        </div>
    </div>
    <!--end: Item-->

    <!--begin: Item-->
    {{-- <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
        <span class="mr-4">
            <span class="svg-icon svg-icon-2x">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Sale2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <polygon fill="#000000" opacity="0.3" points="12 20.0218549 8.47346039 21.7286168 6.86905972 18.1543453 3.07048824 17.1949849 4.13894342 13.4256452 1.84573388 10.2490577 5.08710286 8.04836581 5.3722735 4.14091196 9.2698837 4.53859595 12 1.72861679 14.7301163 4.53859595 18.6277265 4.14091196 18.9128971 8.04836581 22.1542661 10.2490577 19.8610566 13.4256452 20.9295118 17.1949849 17.1309403 18.1543453 15.5265396 21.7286168"></polygon>
                        <polygon fill="#000000" points="14.0890818 8.60255815 8.36079737 14.7014391 9.70868621 16.049328 15.4369707 9.950447"></polygon>
                        <path d="M10.8543431,9.1753866 C10.8543431,10.1252593 10.085524,10.8938719 9.13585777,10.8938719 C8.18793881,10.8938719 7.41737243,10.1252593 7.41737243,9.1753866 C7.41737243,8.22551387 8.18793881,7.45690126 9.13585777,7.45690126 C10.085524,7.45690126 10.8543431,8.22551387 10.8543431,9.1753866" fill="#000000" opacity="0.3"></path>
                        <path d="M14.8641422,16.6221564 C13.9162233,16.6221564 13.1456569,15.8535438 13.1456569,14.9036711 C13.1456569,13.9520555 13.9162233,13.1851857 14.8641422,13.1851857 C15.8138085,13.1851857 16.5826276,13.9520555 16.5826276,14.9036711 C16.5826276,15.8535438 15.8138085,16.6221564 14.8641422,16.6221564 Z" fill="#000000" opacity="0.3"></path>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </span>
        <div class="d-flex flex-column text-dark-75">
            <span class="font-weight-bolder font-size-sm">Expenses</span>
            <span class="font-weight-bolder font-size-h5">
            <span class="text-dark-50 font-weight-bold">$</span>164,700</span>
        </div>
    </div> --}}
    <!--end: Item-->
    <!--begin: Item-->
    {{-- <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
        <span class="mr-4">
            <span class="svg-icon svg-icon-2x">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5"></rect>
                        <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5"></rect>
                        <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"></path>
                        <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5"></rect>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </span>
        <div class="d-flex flex-column text-dark-75">
            <span class="font-weight-bolder font-size-sm">Net</span>
            <span class="font-weight-bolder font-size-h5">
            <span class="text-dark-50 font-weight-bold">$</span>782,300</span>
        </div>
    </div> --}}
    <!--end: Item-->
    <!--begin: Item-->
    {{-- <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
        <span class="mr-4">
            <span class="svg-icon svg-icon-2x">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Hummer.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M18.4246212,12.6464466 L21.2530483,9.81801948 C21.4483105,9.62275734 21.764893,9.62275734 21.9601551,9.81801948 L22.6672619,10.5251263 C22.862524,10.7203884 22.862524,11.0369709 22.6672619,11.232233 L19.8388348,14.0606602 C19.6435726,14.2559223 19.3269901,14.2559223 19.131728,14.0606602 L18.4246212,13.3535534 C18.2293591,13.1582912 18.2293591,12.8417088 18.4246212,12.6464466 Z M3.22182541,17.9497475 L13.1213203,8.05025253 C13.5118446,7.65972824 14.1450096,7.65972824 14.5355339,8.05025253 L15.9497475,9.46446609 C16.3402718,9.85499039 16.3402718,10.4881554 15.9497475,10.8786797 L6.05025253,20.7781746 C5.65972824,21.1686989 5.02656326,21.1686989 4.63603897,20.7781746 L3.22182541,19.363961 C2.83130112,18.9734367 2.83130112,18.3402718 3.22182541,17.9497475 Z" fill="#000000" opacity="0.3"></path>
                        <path d="M12.3890873,1.28248558 L12.3890873,1.28248558 C15.150511,1.28248558 17.3890873,3.52106183 17.3890873,6.28248558 L17.3890873,10.7824856 C17.3890873,11.058628 17.1652297,11.2824856 16.8890873,11.2824856 L12.8890873,11.2824856 C12.6129449,11.2824856 12.3890873,11.058628 12.3890873,10.7824856 L12.3890873,1.28248558 Z" fill="#000000" transform="translate(14.889087, 6.282486) rotate(-45.000000) translate(-14.889087, -6.282486)"></path>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </span>
        <div class="d-flex flex-column flex-lg-fill">
            <span class="text-dark-75 font-weight-bolder font-size-sm">73 Projects</span>
            <a href="#" class="text-primary font-weight-bolder">View</a>
        </div>
    </div> --}}
    <!--end: Item-->
    <!--begin: Item-->
    {{-- <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
        <span class="mr-4">
            <span class="svg-icon svg-icon-2x">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <polygon fill="#000000" opacity="0.3" points="5 15 3 21.5 9.5 19.5"></polygon>
                        <path d="M13.5,21 C8.25329488,21 4,16.7467051 4,11.5 C4,6.25329488 8.25329488,2 13.5,2 C18.7467051,2 23,6.25329488 23,11.5 C23,16.7467051 18.7467051,21 13.5,21 Z M9,8 C8.44771525,8 8,8.44771525 8,9 C8,9.55228475 8.44771525,10 9,10 L18,10 C18.5522847,10 19,9.55228475 19,9 C19,8.44771525 18.5522847,8 18,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 C8,13.5522847 8.44771525,14 9,14 L14,14 C14.5522847,14 15,13.5522847 15,13 C15,12.4477153 14.5522847,12 14,12 L9,12 Z" fill="#000000"></path>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </span>
        <div class="d-flex flex-column">
            <span class="text-dark-75 font-weight-bolder font-size-sm">648 Comments</span>
            <a href="#" class="text-primary font-weight-bolder">View</a>
        </div>
    </div> --}}
    <!--end: Item-->
    <!--begin: Item-->
    @if(false)
    <div class="d-flex align-items-center flex-lg-fill my-1">
        <span class="mr-4">
            <span class="svg-icon svg-icon-2x">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </span>
        <div class="symbol-group symbol-hover">
            @foreach($client->users AS $clientChild)
                <div class="symbol symbol-30 symbol-circle @empty($clientChild->photo) symbol-light-primary @endif" data-toggle="tooltip" title="" data-original-title="{{ $client->name }}">
                    @if(!empty($clientChild->photo))
                    <img alt="Pic" src="/{{ $client->photo }}">
                    @else
                    <span class="symbol-label font-weight-bold">{{ upper(mb_substr($client->login, 0, 1)) }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif
    <!--end: Item-->
</div>
<!--end::Bottom-->
@endisset
