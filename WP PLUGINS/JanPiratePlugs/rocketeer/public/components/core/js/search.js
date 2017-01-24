/**
 * Created by jaskokoyn on 12/13/2015.
 */
(function($, w){
    var vm                              =   new Vue({
        el: '#searchApp',
        data: {
            media_items:                    media_items
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
            }
        }
    });
})(jQuery, window);