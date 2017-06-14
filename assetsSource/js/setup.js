// Anything in this file will be run before the rest of your custom files

window.fabDependenciesLoaded = function() {
    'use strict';

    return window.FAB.controller !== undefined &&
        window.$ !== undefined &&
        window.doT !== undefined;
};
