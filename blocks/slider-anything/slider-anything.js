(function ($) {
    $(document).ready(function() {
        $.each($(".slider-anything"), function () {
            let slider_instance = $(this);
            let id = $(this).attr("slider-id");
            let config = window["slider_anything_"+id];
            let responsive = {};
            responsive[config.size_mobile] = {items : config.item_mobile};
            responsive[config.size_tablet] = {items : config.item_tablet};
            responsive[config.size_desktop] = {items : config.item_desktop};
            console.log("%o",responsive);
            tns({
                container:$(this).find(".slider-anything-container").get(0),
                center: config.center,
                autoplay:config.autoplay,
                loop: config.loop,
                mouseDrag: config.mouse_drag,
                gutter: config.gutter,
                nav: config.dots,
                controls: config.arrows,
                speed: config.speed,
                autoplayTimeout:config.time_by_slide,
                slideBy: config.slideby,
                autoplayHoverPause:config.pause_on_hover,
                items: config.item_desktop,
                autoplayButton:false,
                autoplayButtonOutput:false,
                rewind:config.rewind,
                responsive: responsive,
                onInit: () => {
                    console.log("loaded !");
                    slider_instance.addClass("slider-loaded");
                }
            });
        });
    });
})(jQuery);