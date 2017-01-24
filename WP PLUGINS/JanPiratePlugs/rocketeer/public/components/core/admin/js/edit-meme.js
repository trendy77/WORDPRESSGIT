/**
 * Created by jaskokoyn on 12/17/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    var canvas                          =   document.getElementById("memeCanvas");
    var imgSrc                          =   mediaObj.img_type == 2 ? mediaObj.upl_img : $(".memeSelectCtr[data-mid=" + mediaObj.meme_id + "]").find("img").attr("src");
    var vm                              =   new Vue({
        el: '#editMediaApp',
        data: {
            img_loaded: true,
            top_caption: mediaObj.top_caption,
            bottom_caption: mediaObj.bottom_caption,
            img_type: mediaObj.img_type,
            meme_id: mediaObj.meme_id
        },
        methods: {
            updateMemeTxt: function(event){
                event.preventDefault();
                Meme( imgSrc, canvas, this.top_caption, this.bottom_caption);
            }
        }
    });

    Meme( imgSrc, canvas, vm.$get("top_caption"), vm.$get("bottom_caption"));

    $(document).on('click', '.memeSelectCtr', function(e){
        e.preventDefault();

        imgSrc                          =   $(this).find('img').attr('src');
        Meme( imgSrc, canvas, vm.$get("top_caption"), vm.$get("bottom_caption"));
        vm.img_loaded                   =   true;
        vm.img_type                     =   1;
        vm.meme_id                      =   $(this).data('mid');
    });

    $(document).on( 'click', '#uplImgBtn', function(e){
        e.preventDefault();
        $("#inputImgSrc").click();
    });

    $(document).on( 'change', '#inputImgSrc', function(e){
        e.preventDefault();

        var file                    =   $(this).prop('files')[0];

        if(!file){
            return null;
        }


        var reader                  =   new FileReader();

        reader.onload               =   function (e) {
            imgSrc                  =   e.target.result;
            Meme( imgSrc, canvas, vm.$get("top_caption"), vm.$get("bottom_caption"));
            vm.img_loaded           =   true;
            vm.img_type             =   2;
        };

        reader.readAsDataURL(file);
    });

    $(document).on( "submit", "#mediaForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">Please wait</div>');

        var formData                    =   new FormData();
        var file                        =   $("#inputImgSrc").prop('files');
        formData.append( "_token", $("input[name=_token]").val() );
        formData.append( "title", $("#inputTitle").val() );
        formData.append( "desc", $("#inputDesc").val() );
        formData.append( "cid", $("#inputCid").val() );
        formData.append( "nsfw", $("#inputNSFW").val() );
        formData.append( "page_content", CKEDITOR.instances.inputPageContent.getData() );
        formData.append( "type", vm.img_type );
        formData.append( "meme_data", canvas.toDataURL( "image/png" ) );
        formData.append( "top_caption", vm.top_caption );
        formData.append( "bottom_caption", vm.bottom_caption );
        formData.append( "meme_id", vm.meme_id );
        formData.append( "img_type", vm.img_type );
        formData.append( "status", $("#inputMediaStatus").val() );

        if( vm.img_type == 2 ){
            console.log('swag');
            formData.append( "upl_img", file[0] );
        }

        $.ajax({
            url : '',
            type: 'POST',
            data: formData,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            console.log(response);

            if(response.status == 2){
                $("#alertStatus").html('<div class="alert alert-success">Successfully updated!</div>');
            }else{
                $("#alertStatus").html('<div class="alert alert-danger">Error! Unable to update meme. <ul></ul></div>');
                response.errors.forEach(function(ele,ind,arr){
                    $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                });
            }
        });
    });
})(jQuery, window);