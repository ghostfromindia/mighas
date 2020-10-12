@extends('migas._layout.base')


@section('content')



    @if(!empty($slider))
    <!-- Slideshow - Revolution slider element -->
    <div class="kl-slideshow uh_light_gray kl-revolution-slider">
        <div class="bgback">
        </div>
        <!-- START REVOLUTION SLIDER 5.0 -->
        <div class="kl-slideshow iosslider-slideshow uh_light_gray iosslider--custom-height scrollme">
            <!-- SVG Loader -->
            <div class="kl-loader">
                <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewbox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
					<path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z">
                    </path>
                    <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z" transform="rotate(103.374 20 20)">
                        <animatetransform attributetype="xml" attributename="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatcount="indefinite">
                        </animatetransform>
                    </path>
				</svg>
            </div>
            <!--/ SVG Loader -->

            <div class="bgback">
            </div>

            <!-- Animated Sparkles -->
            <div class="th-sparkles"></div>
            <!--/ Animated Sparkles -->

            <!-- iOS Slider wrapper with animateme scroll efect -->
            <div class="iosSlider kl-slideshow-inner animateme" data-trans="6000" data-autoplay="1" data-infinite="true" data-when="span" data-from="0" data-to="0.75" data-translatey="300" data-easing="linear">
                <!-- Slides -->
                <div class="kl-iosslider hideControls">

                @foreach($slider->photos as $obj)
                    <!-- Slide 3 -->
                        <div class="item iosslider__item @if($loop->index ==1)kl-iosslider-active @endif">
                            <!-- Image -->
                            <div class="slide-item-bg" style="background-image: url({{asset('theme')}}/images/sliders/old-iosslider-3.jpg);">
                            </div>
                            <!--/ Image -->

                            <!-- Captions container -->
                            <div class="container kl-iosslide-caption kl-ioscaption--style5 fromleft klios-alignright kl-caption-posv-middle">
                                <!-- Captions animateme wrapper -->
                                <div class="animateme" data-when="span" data-from="0" data-to="0.75" data-opacity="0.1" data-easing="linear">
                                    <!-- Main Big Title -->
                                    <h2 class="main_title has_titlebig ">
                                        {!! $obj->title !!}
                                    </h2>
                                    <!--/ Main Big Title -->

                                    <!-- Big Title -->
                                    <h3 class="title_big">
                                        {!! $obj->alt_text !!}
                                    </h3>
                                    <!--/ Big Title -->

                                    <!-- Link buttons -->
                                    <div class="more">
                                        <!-- Button full color style -->
                                        <a href="{{$obj->button_link}}" target="_self" class="btn btn-fullcolor" title="Kallyas Collection">
                                            {{$obj->button_text}}
                                        </a>
                                        <!--/ Button full color style -->

                                        <!-- Button full lined style -->
                                        <a href=" {{$obj->button2_link}}" target="_self" class="btn btn-lined" title="">
                                            {{$obj->button2_text}}
                                        </a>
                                        <!--/ Button full lined style -->
                                    </div>
                                    <!-- Link buttons -->

                                    <!-- Small Title -->
                                    <h4 class="title_small">
                                        {!! $obj->description !!}
                                    </h4>
                                    <!--/ Small Title -->
                                </div>
                                <!--/ Captions animateme wrapper -->
                            </div>
                            <!--/ Captions container -->
                        </div>
                        <!--/ Slide 3 -->
                    @endforeach

                </div>
                <!-- Slides -->

                <!-- Navigation Controls - Prev -->
                <div class="kl-iosslider-prev">
                    <!-- Arrow -->
                    <span class="thin-arrows ta__prev"></span>
                    <!--/ Arrow -->

                    <!-- Label - prev -->
                    <div class="btn-label">
                        PREV
                    </div>
                    <!--/ Label - prev -->
                </div>
                <!--/ Navigation Controls - Prev -->

                <!-- Navigation Controls - Next -->
                <div class="kl-iosslider-next">
                    <!-- Arrow -->
                    <span class="thin-arrows ta__next"></span>
                    <!--/ Arrow -->

                    <!-- Label - next -->
                    <div class="btn-label">
                        NEXT
                    </div>
                    <!--/ Label - next -->
                </div>
                <!--/ Navigation Controls - Prev -->
            </div>
            <!--/ iOS Slider wrapper with animateme scroll efect -->

            <!-- Bullets -->
            <div class="kl-ios-selectors-block bullets2">
                <div class="selectors">

                @foreach($slider->photos as $obj)
                    <!-- Item #1 -->
                    <div class="item iosslider__bull-item @if($loop->index == 0) first selected @endif">
                    </div>
                    <!--/ Item #1 -->
                @endforeach
                </div>
                <!--/ .selectors -->
            </div>
            <!--/ Bullets -->

            <div class="scrollbarContainer">
            </div>
        </div>
        <!-- END OF SLIDER WRAPPER -->
        <div class="th-sparkles">
        </div>
    </div>
    <!--/ Slideshow - Revolution slider element -->
    @endif



    <!-- Latest collection section with custom white background color, section gloss overlay and custom paddings + bottom mask style 4 left -->
    <section class="hg_section--relative bg-white section-shadow pt-100 pb-100">
        <!-- Background source -->
        <div class="kl-bg-source">
            <!-- Gloss overlay -->
            <div class="kl-bg-source__overlay-gloss">
            </div>
            <!--/ Gloss overlay -->
        </div>
        <!--/ Background source -->

        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <!-- Title element with icon symbol and custom bottom padding -->
                    <div class="kl-title-block text-center tbk-symbol--icon">
                        <!-- Title with custom alternative font, size and default theme color -->
                        <h3 class="tbk__title kl-font-alt fs-xl tcolor">
                            {{Key::get('hb-banner-title')}}
                        </h3>

                        <!-- Title bottom icon symbol = .fas fa-ellipsis-h / custom size and lightgray2 color -->
                        <div class="tbk__symbol ">
                            <span class="tbk__icon fs-xl light-gray2 fas fa-ellipsis-h"></span>
                        </div>
                        <!--/ Title bottom icon symbol -->
                    </div>
                    <!--/ Title element with icon symbol -->
                @include('migas.components.latest_offers1')
                @include('migas.components.latest_offers2')
                <!-- Offer banners element -->

                    <!--/ Offer banners element -->
                </div>
                <!--/ col-md-12 col-sm-12 -->
            </div>
            <!--/ row -->
        </div>
        <!--/ container -->


        <!--/ Bottom mask style 4 left -->
    </section>
    <!--/ Latest collection section with custom white background color, section gloss overlay and custom paddings + bottom mask style 4 left -->




@endsection