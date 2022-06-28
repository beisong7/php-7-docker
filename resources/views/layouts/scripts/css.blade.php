<link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
<style>
    .side-nav .side-nav-inner .side-nav-menu>li.active, .side-nav .side-nav-inner .side-nav-menu>li:hover {
        background-color: rgba(63,135,245,0.15);
    }

    .side-nav .side-nav-inner .side-nav-menu>li.active a, .side-nav .side-nav-inner .side-nav-menu>li:hover > a, .side-nav .side-nav-inner .side-nav-menu>li:hover > a span i{
        color: #3f87f5;
    }

    .side-nav .side-nav-inner .side-nav-menu>li.active:after {
        transform: scaleY(1);
        -webkit-transform: scaleY(1);
        -moz-transform: scaleY(1);
        -o-transform: scaleY(1);
        -ms-transform: scaleY(1);
        opacity: 1;
    }
    .side-nav .side-nav-inner .side-nav-menu>li:after{
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        transform: scaleY(0.0001);
        -webkit-transform: scaleY(0.0001);
        -moz-transform: scaleY(0.0001);
        -o-transform: scaleY(0.0001);
        -ms-transform: scaleY(0.0001);
        transition: opacity 0.15s cubic-bezier(0.215, 0.61, 0.355, 1);
        -webkit-transition: opacity 0.15s cubic-bezier(0.215, 0.61, 0.355, 1);
        -moz-transition: opacity 0.15s cubic-bezier(0.215, 0.61, 0.355, 1);
        -o-transition: opacity 0.15s cubic-bezier(0.215, 0.61, 0.355, 1);
        -ms-transition: opacity 0.15s cubic-bezier(0.215, 0.61, 0.355, 1);
        opacity: 0;
        border-right: 2px solid;
        border-color: #3f87f5;
    }

</style>