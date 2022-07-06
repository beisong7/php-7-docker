<!-- Header START -->
<div class="header">
    <div class="logo logo-dark">
        <a href="#">
            <img src="{{ url('img/logo.png') }}" alt="Logo" style="max-width: 50px" class="mt-2">

            <img class="logo-fold mt-2" src="{{ url('img/logo.png') }}" alt="Logo" style="margin-left: 15px; max-width: 50px">
        </a>
    </div>
    <div class="logo logo-white">
        <a href="#">
            <img src="{{ url('assets/images/logo/logo-white.png') }}" alt="Logo">
            <img class="logo-fold" src="{{ url('assets/images/logo/logo-fold-white.png') }}" alt="Logo">
        </a>
    </div>
    <div class="nav-wrap">
        <ul class="nav-left">
            <li class="desktop-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>
            <li class="mobile-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#search-drawer">
                    <i class="anticon anticon-search"></i>
                </a>
            </li>
        </ul>
        <ul class="nav-right">

            <li class="dropdown dropdown-animated scale-left">
                <div class="pointer" data-toggle="dropdown">
                    <div class="avatar avatar-image  m-h-10 m-r-15">
                        <img src="{{ $person->image }}"  alt="">
                    </div>
                </div>
                <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                    <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                        <div class="d-flex m-r-50">
                            <div class="m-l-10">
                                <p class="m-b-0 text-dark font-weight-semibold">{{ $person->names }}</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" onclick="window.location = '{{ route('logout') }}'" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                <span class="m-l-10">Logout</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                </div>
            </li>

        </ul>
    </div>
</div>
<!-- Header END -->
