import Quill from 'quill';

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
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'video', 'code-block']
            ]
        },
        bounds: document.querySelector('.js-quill'),
        theme: 'snow'
    });

    quill.on('text-change', function(delta, source) {
        textareaElement.value = quill.getHtml();
    });
}
