
var handlePluginColorbox = function(){
    if($.colorbox){
        log('Colorbox Loaded');
    }

    $.extend($.colorbox.settings , {
        opacity : .4,
        maxWidth : '100%',
        trapFocus: false,
        escKey: false,
        overlayClose: false,
        scrolling: false,
    });

    $('.j-modal').colorbox();
};

function log(text){
    console.log(text);
}

handlePluginColorbox();

