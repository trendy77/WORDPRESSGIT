/**
 * Created by jaskokoyn on 11/13/2015.
 */
(function($, w){
    if(typeof Dropzone != "undefined"){
        Dropzone.autoDiscover = false;
    }

    if(typeof moment != "undefined"){
        moment.locale(user_locale);
    }

    $(".openCreateModal").click(function(e){
        e.preventDefault();
        $("#createModal").modal('show');
    });

    $(document).on( 'click', '.btn-step', function(e){
        e.preventDefault();

        if($(this).data('dir') == "forward"){
            $(this).closest(".single-step-ctr").slideUp('fast', function(){
                $(this).next().slideDown();
            });

            $(this).closest(".form-steps-ctr").find(".form-step-active").animate({
                backgroundColor: '#82B440'
            }, function(){
                $(this).removeClass('form-step-active').addClass('form-step-complete');
            }).next().animate({
                backgroundColor: '#DB3D3D'
            }, function(){
                $(this).addClass('form-step-active');
            });
        }else if($(this).data('dir') == "backward"){
            $(this).closest(".single-step-ctr").slideUp('fast', function(){
                $(this).prev().slideDown();
            });

            $(this).closest(".form-steps-ctr").find(".form-step-active").animate({
                backgroundColor: '#73c1e7'
            }, function(){
                $(this).removeClass('form-step-active');
            }).prev().animate({
                backgroundColor: '#DB3D3D'
            }, function(){
                $(this).addClass('form-step-active').removeClass('form-step-complete');
            });
        }
    });

    $(document).on( 'focus', '.top-header .form-control', function(e){
        e.preventDefault();
        $('.top-header .input-group').animate({ width: '200px' });
    });

    $(document).on( 'blur', '.top-header .form-control', function(e){
        e.preventDefault();
        $('.top-header .input-group').animate({ width: '125px' });
    });

    $(document).on( 'click', '.btn-like-media', function(e){
        e.preventDefault();

        var btn                     =   this;

        $.post( ajaxurl + "/process/toggle-media-like", { mid: $(this).data('mid'), _token: $(this).data('token') } ).always(function(response){
            if(response.status == 2){
                $(btn).html( '<i class="fa fa-heart"></i> ' + response.likes );
                $(btn).toggleClass( 'text-' + $(btn).data('class') );
            }else{
                alert('Unable to like post. Try again later.');
            }
        });
    });

    $(document).on( 'click', '.share-fb', function(e){
        e.preventDefault();

        FB.ui({
            method: 'share',
            href: $(this).data('url')
        }, function(response){});
    });

    $(document).on( 'click', '.share-twitter', function(e){
        e.preventDefault();

        window.open(
            "https://twitter.com/share?url=" + $(this).data('url') + '&text=' + encodeURI($(this).data('txt')),
            "_blank",
            "width=500, height=300"
        );
    });

    $(document).on( 'click', '.share-google-plus', function(e){
        e.preventDefault();

        window.open(
            "https://plus.google.com/share?url=" + $(this).data('url'),
            "_blank",
            "width=600, height=600"
        );
    });

    $(document).on( 'click', '.share-pinterest', function(e){
        e.preventDefault();

        window.open(
            "https://pinterest.com/pin/create%2Fbutton/?url=" + $(this).data('url') + "&media=" + $(this).data('img') + "&description=" + encodeURI( $(this).data('txt') ),
            "_blank",
            "width=600, height=600"
        );
    });

    $(document).on( 'submit', '#universalSubscribeForm', function(e){
        e.preventDefault();
        var widget                      =   $(this).closest('.newsletter-widget');

        widget.find(":input").prop("disabled", true);
        widget.find("h2").text(uni_sub_pending);

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            email:                      $("#inputSubscriberEmail").val()
        };

        $.post( ajaxurl + "/universal-newsletter-subscribe", formObj).always(function(response){
            if(response.status == 2){
                widget.find("h2").text(uni_sub_success);
            }else{
                widget.find(":input").prop("disabled", false);
                widget.find("h2").text(uni_sub_error);
            }
        });
    });

    if( $("#newBadgeModal").length ){
        $("#newBadgeModal").modal( 'show' );
    }

    $(document).on( 'click', '#btn-mobile-collapse', function(e){
        e.preventDefault();

        $("body").addClass("mobile-menu-appeared");
        $("body").append('<div class="mobile-menu-content-overlay"></div>');
        $(".rocketeer-mobile-nav-ctr, .mobile-menu-content-overlay").fadeIn('fast');
    });
    
    $(document).click(function(event) {
        if($(event.target).closest("a[data-toggle=modal]").length || $(event.target).is('.mobile-menu-content-overlay')){
            $("body").removeClass("mobile-menu-appeared");

            $(".rocketeer-mobile-nav-ctr, .mobile-menu-content-overlay").fadeOut(function(){
                $(".mobile-menu-content-overlay").remove();
            });
        }
    });
})(jQuery, window);