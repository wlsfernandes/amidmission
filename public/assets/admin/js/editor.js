window.AppEditor = (function () {

    const defaultConfig = {
        toolbar: {
            items: [
                'heading', '|',

                'fontFamily', 'fontSize',
                'fontColor', 'fontBackgroundColor', '|',

                'bold', 'italic', 'underline', 'strikethrough',
                'subscript', 'superscript', '|',

                'alignment', '|',

                'bulletedList', 'numberedList', 'todoList',
                'outdent', 'indent', '|',

                'link', 'blockQuote', 'codeBlock',
                'insertTable', 'horizontalLine',
                'specialCharacters', 'mediaEmbed', '|',

                'uploadImage', '|',

                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },

        image: {
            toolbar: [
                'imageTextAlternative',
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side',
                'resizeImage'
            ]
        },

        table: {
            contentToolbar: [
                'tableColumn',
                'tableRow',
                'mergeTableCells',
                'tableProperties',
                'tableCellProperties'
            ]
        }
    };

    function create(selector, customConfig = {}) {
        const config = Object.assign({}, defaultConfig, customConfig);

        document.querySelectorAll(selector).forEach((element) => {
            ClassicEditor
                .create(element, config)
                .catch(error => console.error(error));
        });
    }

    return {
        create
    };

})();