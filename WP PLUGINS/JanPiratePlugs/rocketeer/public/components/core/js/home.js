/**
 * Created by jaskokoyn on 11/25/2015.
 */
(function($, w){
    $('.flexslider').flexslider({
        controlNav:                         false,
        directionNav:                       false
    });

    $(document).on('click', '.btn-prev', function(e){
        e.preventDefault();
        $('.flexslider').flexslider("prev");
        $(this).blur();
    });

    $(document).on('click', '.btn-next', function(e){
        e.preventDefault();
        $('.flexslider').flexslider("next");
        $(this).blur();
    });

    $("#trending-carousel").owlCarousel({
        items:                              4,
        pagination:                         false
    });

    var owl = $(".owl-carousel").data('owlCarousel');

    $(document).on('click', '.carousel-options', function(e){
        e.preventDefault();
        owl.next();
    });

    var vm                              =   new Vue({
        el: '#homeApp',
        data: {
            media_items:                    [],
            offset:                         0,
            stop_searching:                 false
        },
        methods: {
            getCategory:                    function(cid){
                var category            =   {};
                categories.forEach(function(ele,ind,arr){
                    if(ele.id === cid){
                        category        =   ele;
                    }
                });
                return category;
            },
            getMediaItems:                  function(){
                if(vm.stop_searching){
                    return null;
                }

                this.stop_searching     =   true;
                var formObj             =   {
                    _token:                 media_token,
                    offset:                 this.offset
                };

                $.post( ajaxurl + "/process/get-media-items", formObj).always(function(response){
                    vm.stop_searching   =   false;

                    if( response.items.length === 0 ){
                        vm.stop_searching   =   true;
                        return null;
                    }

                    vm.offset           +=  response.items.length;

                    response.items.forEach(function(ele,ind,arr){
                        vm.media_items.push(ele);
                    });
                });
            },
            shareFB:                        function(m){
                FB.ui({
                    method: 'share',
                    href: m.full_url
                }, function(response){});
            },
            shareTwitter:                   function(m){
                window.open(
                    "https://twitter.com/share?url=" + m.full_url + '&text=' + encodeURI(m.title),
                    "_blank",
                    "width=500, height=300"
                );
            }
        }
    });

    vm.getMediaItems();

    if(infinite_pagination == 2){
        $(document).on( 'scroll', window, function(){
            var height              =   $(document).height();
            var scrollTop           =   $(window).scrollTop();

            if( (height/2) < scrollTop ){
                vm.getMediaItems();
            }
        });
    }
})(jQuery, window);