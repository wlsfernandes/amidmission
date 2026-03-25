(function ($) {
    "use strict";

    function initSummernote() {
        $(".summernote").summernote({
            height: 280,
            placeholder: "Write your content here...",

            toolbar: [
                ["style", ["style"]],

                [
                    "font",
                    [
                        "fontname",
                        "fontsize",
                        "bold",
                        "italic",
                        "underline",
                        "strikethrough",
                        "clear",
                    ],
                ],

                ["color", ["color"]],

                ["para", ["ul", "ol", "paragraph", "height"]],

                ["insert", ["link", "picture", "table", "hr"]],

                ["misc", ["undo", "redo"]],

                ["view", ["fullscreen", "codeview", "help"]],
            ],
            addDefaultFonts: false,
            fontNames: [
                "Arial",
                "Arial Black",
                "Comic Sans MS",
                "Courier New",
                "Helvetica",
                "Impact",
                "Tahoma",
                "Times New Roman",
                "Trebuchet MS",
                "Verdana",
                "Georgia",
                "Palatino",
                "Lucida Sans",
                "Lucida Console",
            ],

            fontSizes: [
                "8",
                "9",
                "10",
                "11",
                "12",
                "14",
                "16",
                "18",
                "20",
                "24",
                "28",
                "32",
                "36",
            ],

            dialogsInBody: true,
            disableResizeEditor: true,
        });
    }

    $(document).ready(function () {
        initSummernote();
    });
})(jQuery);
