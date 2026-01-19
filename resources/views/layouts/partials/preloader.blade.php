<!--===== PRELOADER STARTS =======-->
<div class="preloader">
    <div class="loading-container">
        <div class="loading"></div>
        <div id="loading-icon">
            @if (isset($logo2))
                <img src="/img/preloader/vl-preloader-1.2.png" alt="">
            @elseif (isset($logo3))
                <img src="/img/preloader/vl-preloader-1.3.png" alt="">
            @elseif (isset($logo4))
                <img src="/img/preloader/vl-preloader-1.4.png" alt="">
            @elseif (isset($logo5))
                <img src="/img/preloader/vl-preloader-1.5.png" alt="">
            @else
                <img src="/img/preloader/vl-preloader-1.1.png" alt="">
            @endif
        </div>
    </div>
</div>
