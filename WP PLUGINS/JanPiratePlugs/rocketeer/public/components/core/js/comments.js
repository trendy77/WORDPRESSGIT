/**
 * Created by jaskokoyn on 12/5/2015.
 */
(function($, w){
    var commentsApp                     =   new Vue({
        el: '#system_comments',
        data: {
            comment_body:                   '',
            offset:                         0,
            comments:                       []
        },
        methods: {
            add_comment:                    function(){
                var formObj             =   {
                    _token:                 $("input[name=_token]").val(),
                    comment:                this.comment_body,
                    mid:                    this.mid
                };

                $.post( ajaxurl + "/comments/add", formObj ).always(function(response){
                    if(response.status == 2){
                        commentsApp.comment_body        =   '';
                        commentsApp.get_comments();
                    }else{
                        alert( comment_fail_i18n );
                    }
                });
            },
            get_comments:                   function(){
                var formObj             =   {
                    _token:                 $("input[name=_token]").val(),
                    offset:                 this.offset,
                    mid:                    this.mid
                };

                $.get( ajaxurl + "/comments/get", formObj ).always(function(response){
                    if( response.status != 2 || response.comments.length === 0 ){
                        return;
                    }

                    response.comments.forEach(function(ele,ind,arr){
                        commentsApp.comments.unshift(ele);
                    });

                    commentsApp.offset  =   commentsApp.comments.length;
                });
            }
        }
    });

    commentsApp.get_comments();
})(jQuery, window);