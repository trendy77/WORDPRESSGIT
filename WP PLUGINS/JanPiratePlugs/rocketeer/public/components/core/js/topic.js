/**
 * Created by jaskokoyn on 12/22/2015.
 */
(function($, w){
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
        el: '#topicApp',
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
            getMoment:                      function(t){
                return moment(t).fromNow();
            },
            getMediaItems:                  function(){
                if(vm.stop_searching){
                    return null;
                }

                this.stop_searching     =   true;
                var formObj             =   {
                    _token:                 media_token,
                    tid:                    topic_id,
                    offset:                 this.offset
                };

                $.post( ajaxurl + "/process/get-topic-items", formObj).always(function(response){
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