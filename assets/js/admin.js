import $ from 'jquery';
import Clipboard from 'clipboard';

const clipboard = new Clipboard('.clipboard-btn');
clipboard.on('success', function(e) {
    $(e.trigger).removeClass('btn-default').addClass('btn-success').delay(1000).queue(function(next) {
        $(this).removeClass('btn-success').addClass('btn-default');
        next();
    });
});
