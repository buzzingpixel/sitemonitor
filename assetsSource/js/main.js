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
}

runMain(window.FAB, window);
