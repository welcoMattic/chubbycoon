import $ from 'jquery';
import Quill from 'quill';
import Clipboard from 'clipboard';

const clipboard = new Clipboard('.clipboard-btn');
clipboard.on('success', function(e) {
    $(e.trigger).removeClass('btn-default').addClass('btn-success').delay(1000).queue(function(next) {
        $(this).removeClass('btn-success').addClass('btn-default');
        next();
    });
});

Quill.prototype.getHtml = function() {
    return this.container.querySelector('.ql-editor').innerHTML;
};

const textareaElement = document.querySelector('.editor-container textarea');

if (textareaElement) {
    textareaElement.classList.add('hidden');
    const quillContainer = document.createElement('div');

    quillContainer.classList.add('js-quill');
    quillContainer.innerHTML = textareaElement.value;

    textareaElement.parentNode.insertBefore(quillContainer, textareaElement);

    const quill = new Quill('.js-quill', {
        modules: {
            toolbar: {
                container: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'video', 'code-block']
                ],
                handlers: {
                    image: function () {
                        var range = this.quill.getSelection();
                        var value = prompt('Coller l\'url de l\'image');
                        this.quill.insertEmbed(range.index, 'image', value, Quill.sources.USER);
                    }
                }
            }
        },
        bounds: document.querySelector('.js-quill'),
        theme: 'snow'
    });

    quill.on('text-change', function(delta, source) {
        textareaElement.value = quill.getHtml();
    });
}
