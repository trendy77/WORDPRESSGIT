/**
 * Created by jaskokoyn on 12/7/2015.
 */
(function($, w){
    var vm                              =   new Vue({
        el: '#profileApp',
        data: {
            liked_offset:                   0,
            created_offset:                 0,
            liked_media_items:              [],
            created_media_items:            [],
            following:                      following
        },
        methods: {
            get_liked_items:                function(){
                var formObj             =   {
                    _token:                 $("input[name=_token]").val(),
                    offset:                 this.liked_offset,
                    uid:                    profile_id
                };

                $.post( ajaxurl + '/profile/get-media-likes', formObj).always(function(response){
                    if(response.status == 1){
                        return null;
                    }

                    response.items.forEach(function(ele,ind,arr){
                        vm.liked_media_items.push(ele);
                    });

                    vm.liked_offset     =   vm.liked_media_items.length;
                });
            },
            get_created_items:              function(){
                var formObj             =   {
                    _token:                 $("input[name=_token]").val(),
                    offset:                 this.created_offset,
                    uid:                    profile_id
                };

                $.post( ajaxurl + '/profile/get-media-submissions', formObj).always(function(response){
                    if(response.status == 1){
                        return null;
                    }

                    response.items.forEach(function(ele,ind,arr){
                        vm.created_media_items.push(ele);
                    });

                    vm.created_offset   =   vm.created_media_items.length;
                });
            },
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
            toggleFollow:                   function(token, uid, $event){
                $event.preventDefault();

                $.post( ajaxurl + "/user/toggle-follow", { _token: token, uid: uid } ).always(function(response){
                    if(response.status == 2){
                        vm.following    =  !vm.following;
                    }else{
                        alert( follow_fail_i18n );
                    }
                });
            }
        }
    });

    vm.get_liked_items();
    vm.get_created_items();
})(jQuery, window);