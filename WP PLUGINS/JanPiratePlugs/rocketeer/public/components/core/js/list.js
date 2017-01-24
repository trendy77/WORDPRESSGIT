/**
 * Created by jaskokoyn on 11/22/2015.
 */
(function($, w){
    Vue.transition('listTrans', {
        css: false,
        enter: function (el, done) {
            // element is already inserted into the DOM
            // call done when animation finishes.

            if(list_animation == ""){
                done();
                return null;
            }
            $(el).hide();

            setTimeout(function(){
                $(el).transition({
                    animation: list_animation,
                    onComplete: done
                });
            }, 500);
        },
        enterCancelled: function (el) {
            $(el).stop()
        },
        leave: function (el, done) {
            // same as enter
            if(list_animation == ""){
                done();
                return null;
            }

            $(el).transition( {
                animation: list_animation,
                onComplete: done
            });
        },
        leaveCancelled: function (el) {
            $(el).stop()
        }
    });

    var vm                              =   new Vue({
        el: '#listApp',
        data: {
            current_item: 0
        },
        methods: {
            prevItem: function(event){
                this.current_item--;
            },
            nextItem: function(event){
                this.current_item++;
            }
        }
    });
})(jQuery, window);