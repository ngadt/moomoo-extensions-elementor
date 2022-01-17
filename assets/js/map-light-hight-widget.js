(function($){
    $(window).on('elementor/frontend/init', () => {
        
        function mapLightHightWidget($element){         
          var _this = this;
            this.mapLightHight = function () {

                var map = $("#map-light-hight #box-map");
                var mapOrigWidth = map.data('width');
                var mapOrigHeight = map.data('height');
                var container = $("#map-light-hight");
                var containerWidth = container.width();
                var scale = containerWidth / mapOrigWidth;
                scale = scale > 1 ? scale : scale;
               
                map.css({
                    transform: 'scale(' + scale + ')',
                    transformOrigin: '0 0'
                });

                container.css({
                    height: (mapOrigHeight * scale),
                });
            }

            this.mapLightHightHover = function () {
                var $target = $('#map-light-hight #box-map map area, .map-light-hight .map-hover-detail > div');
                
                $(document).mouseover(function (e) {
                    if (!$target.is(e.target) && $target.has(e.target).length === 0) {
                       $target.removeClass('active');
                      $('.map-hover img').css("opacity", 0);
                      $('.map-images').css("opacity", 1);
                     // $('.map-light-hight .map-hover-detail > div').removeClass('active');
                    }
                   
                });
                $('#map-light-hight #box-map map area').hover(function () {

                    var $this = $(this),
                        mapHover = $this.data('hover'),
                        mapHoverDetails = $this.data('hover-details'),
                        windowWidth = window.outerWidth;
                   
                    $('.map-light-hight .map-hover-detail > div').removeClass('active');

                    $('#' + mapHover).css("opacity", 1);
                    $('.map-images').css("opacity", 0);
                    if ($('html').hasClass('mobile')) {
                        return false;
                    }
                    $('#' + mapHoverDetails).addClass('active');
                }, function () {
                    var $this = $(this),
                        mapHover = $this.data('hover'),
                        mapHoverDetails = $this.data('hover-details'),
                        windowWidth = window.outerWidth;

                    $('#' + mapHover).css("opacity", 0);
                    $('#' + mapHoverDetails).removeClass('active');
                });
                 $('.map-hover-detail > div').hover(function () {
                    var $this = $(this),
                        $area = $('#map-light-hight #box-map map area[data-hover-details="' + $this.attr('id') + '"]'),
                        mapHover = $area.data('hover'),
                        mapHoverDetails = $this.attr('id');
                       

                    $('#' + mapHover).css("opacity", 1);
                    $('#' + mapHoverDetails).addClass('active');
                }, function () {
                    var $this = $(this),
                        $area = $('#map-light-hight #box-map map area[data-hover-details="' + $this.attr('id') + '"]'),
                        mapHover = $area.data('hover'),
                        mapHoverDetails = $this.attr('id');

                    $('#' + mapHover).css("opacity", 0);
                    $('#' + mapHoverDetails).removeClass('active');
                });
                jQuery('.map-light-hight map area').click(function(e){
                    //console.log('adsasd');
                    if(jQuery(window).width() <= 992){
                        e.preventDefault();
                       // window.location.replace("https://ogroup.com/our-team/");
                    }
                });
            }
            this.init = function () {
                _this.mapLightHight();
                $(window).on('load resize orientationchange', function () {
                    _this.mapLightHight();
                });
                _this.mapLightHightHover();
            }

            this.init();
           
       };
       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-team-memeber-map-light-hight.default', mapLightHightWidget);
    });
})(jQuery)

