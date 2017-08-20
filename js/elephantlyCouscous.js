App = {};
App.main = function(){
    emojify.setConfig({mode : 'data-uri'});
    emojify.run();

    if( 1 === $('nav').children().length )
    {
        $('nav').remove();
        $('.menu-link').remove();
        $('.push').css({
            "width": "100%",
            "margin-left":"0"
        });
        $('.push header').css({
            "width": "100%",
        });
    }

    var current = window.location.href;
    $('nav a[href="'+current+'"]').closest('li').addClass('current');


    // Syntax highlighting
    hljs.initHighlightingOnLoad();
}

App.main();
