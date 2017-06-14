function runCodeEditor(F, W) {
    'use strict';

    // Make sure Fabricator has been fully loaded
    if (! W.fabDependenciesLoaded()) {
        setTimeout(function() {
            runCodeEditor(F, W);
        }, 10);
        return;
    }

    // Create the controller
    F.controller.make('CodeEditor', {
        init: function() {
            // Save a reference to the controller
            var self = this;

            // Load code mirror if needed
            if (W.CodeMirror === undefined) {
                F.assets.load({
                    root: '/',
                    js: [
                        'codemirror/lib/codemirror.js',
                        'codemirror/mode/shell/shell.js'
                    ],
                    css: [
                        'codemirror/lib/codemirror.css'
                    ],
                    success: function() {
                        self.runCodeMirror();
                    }
                });

                return;
            }

            // If code mirror is already loaded, run it
            self.runCodeMirror();
        },

        runCodeMirror: function() {
            W.CodeMirror.fromTextArea(this.$el.get(0), {
                dragDrop: false,
                indentUnit: 4,
                indentWithTabs: false,
                lineNumbers: true,
                lineWrapping: true,
                mode: 'text/x-sh',
                tabSize: 4,
                viewportMargin: Infinity
            });
        }
    });
}

runCodeEditor(window.FAB, window);
