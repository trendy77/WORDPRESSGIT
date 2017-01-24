/**
 * Created by jaskokoyn on 11/17/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    var canvas                          =   document.getElementById("memeCanvas");
    var imgSrc                          =   '';
    var vm                              =   new Vue({
        el: '#createMemeForm',
        data: {
            img_loaded: false,
            top_caption: '',
            bottom_caption: '',
            img_type: 1,
            meme_id: 0
        },
        methods: {
            updateMemeTxt: function(event){
                event.preventDefault();
                Meme( imgSrc, canvas, this.top_caption, this.bottom_caption);
            }
        }
    });

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

    $(document).on( "submit", "#createMemeForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">' + processing_message + '</div>');

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

        if( vm.img_type == 2 ){
            console.log('swag');
            formData.append( "upl_img", $("#inputImgSrc").prop("files")[0] );
        }

        $(this).slideUp('fast', function(){
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
                    if(response.is_approved == 2){
                        $("#alertStatus").html('<div class="alert alert-success">' + success_message + '</div>');
                        location.href           =   response.url;
                    }else{
                        $("#alertStatus").html('<div class="alert alert-success">' + pending_success_message + '</div>');
                    }
                }else{
                    $("#createMemeForm").slideDown('fast');
                    $("#alertStatus").html('<div class="alert alert-danger">' + unable_submission + ' <ul></ul></div>');
                    response.errors.forEach(function(ele,ind,arr){
                        $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                    });
                }
            });
        });
    });
})(jQuery, window);