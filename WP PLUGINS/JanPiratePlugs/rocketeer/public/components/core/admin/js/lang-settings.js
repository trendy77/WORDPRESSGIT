/**
 * Created by jaskokoyn on 1/28/2016.
 */
(function($, w){
    var app                             =   new Vue({
        el:                                 '#settingsApp',
        data:                               {
            langs:                          languages
        },
        methods:                            {
            addLang:                        function(){
                this.langs.push({
                    locale:                 '',
                    readable_name:          ''
                });
            },
            removeLang:                     function($index){
                if(!confirm("Are you sure you want to do this?")){
                    return null;
                }

                this.langs.splice($index, 1);
            }
        }
    });


    $("#settingsForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            default_lang:                   $("#inputLang").val(),
            lang_switcher:                  $("#inputLangSwitcher").val(),
            lang_switcher_loc:              $("#inputLangSwitcherLoc").val(),
            langs:                          app.$get("langs")
        };

        $.post( '', formObj).always(function(response){
            $("#settingsForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });
})(jQuery, window);