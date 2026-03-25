document.addEventListener("DOMContentLoaded", function () {
    if (typeof CKEDITOR === "undefined") {
        console.warn("CKEditor not loaded.");
        return;
    }

    document.querySelectorAll(".ckeditor").forEach((element) => {
        CKEDITOR.ClassicEditor.create(element, {
            toolbar: {
                items: [
                    "heading",
                    "|",
                    "fontFamily",
                    "fontSize",
                    "fontColor",
                    "|",
                    "bold",
                    "italic",
                    "underline",
                    "|",
                    "bulletedList",
                    "numberedList",
                    "|",
                    "alignment",
                    "|",
                    "link",
                    "blockQuote",
                    "insertTable",
                    "|",
                    "undo",
                    "redo",
                ],
            },

            fontFamily: {
                options: [
                    "default",
                    "Arial, Helvetica, sans-serif",
                    "Georgia, serif",
                    "Times New Roman, Times, serif",
                    "Poppins, sans-serif",
                    "Roboto, sans-serif",
                ],
            },

            fontSize: {
                options: [
                    10,
                    12,
                    14,
                    "default",
                    18,
                    20,
                    24,
                    28,
                    32,
                    36,
                    48,
                    72,
                ],
            },

            removePlugins: [
                "CKBox",
                "CKFinder",
                "EasyImage",
                "RealTimeCollaborativeComments",
                "RealTimeCollaborativeTrackChanges",
                "RealTimeCollaborativeRevisionHistory",
                "PresenceList",
                "Comments",
                "TrackChanges",
                "TrackChangesData",
                "RevisionHistory",
                "Pagination",
                "WProofreader",
                "DocumentOutline",
                "TableOfContents",
                "FormatPainter",
                "SlashCommand",
                "PasteFromOfficeEnhanced",
                "Template",
            ],
        }).catch((error) => {
            console.error("CKEditor error:", error);
        });
    });

    document.querySelectorAll(".ckeditor-title").forEach((element) => {
        CKEDITOR.ClassicEditor.create(element, {
            toolbar: {
                items: [
                    "fontFamily",
                    "fontSize",
                    "fontColor",
                    "|",
                    "bold",
                    "italic",
                    "underline",
                    "|",
                    "alignment",
                    "|",
                    "undo",
                    "redo",
                ],
            },

            fontFamily: {
                options: [
                    "default",
                    "Arial, Helvetica, sans-serif",
                    "Georgia, serif",
                    "Times New Roman, Times, serif",
                    "Poppins, sans-serif",
                    "Roboto, sans-serif",
                ],
            },

            fontSize: {
                options: [
                    10,
                    12,
                    14,
                    "default",
                    18,
                    20,
                    24,
                    28,
                    32,
                    36,
                    48,
                    72,
                ],
            },

            removePlugins: [
                "CKBox",
                "CKFinder",
                "EasyImage",
                "RealTimeCollaborativeComments",
                "RealTimeCollaborativeTrackChanges",
                "RealTimeCollaborativeRevisionHistory",
                "PresenceList",
                "Comments",
                "TrackChanges",
                "TrackChangesData",
                "RevisionHistory",
                "Pagination",
                "WProofreader",
                "DocumentOutline",
                "TableOfContents",
                "FormatPainter",
                "SlashCommand",
                "PasteFromOfficeEnhanced",
                "Template",
            ],
        });
    });
});
