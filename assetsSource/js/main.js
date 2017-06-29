// This file is run after everything else

function runMain(F, W) {
    'use strict';

    // Make sure Fabricator has been fully loaded
    if (! W.fabDependenciesLoaded()) {
        setTimeout(function() {
            runMain(F, W);
        }, 10);
        return;
    }

    // Run script sets on page
    $('.js-edit-script-set').each(function() {
        F.controller.construct('EditScriptSet', {
            el: this
        });
    });

    // Run edit areas on page
    $('.js-code-editor').each(function() {
        F.controller.construct('CodeEditor', {
            el: this
        });
    });

    // Run table filters
    $('.js-filter-table').each(function() {
        F.controller.construct('FilterTable', {
            el: this
        });
    });
}

runMain(window.FAB, window);
