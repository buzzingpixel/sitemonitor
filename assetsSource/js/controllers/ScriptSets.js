function runEditScriptSet(F, W) {
    'use strict';

    // Make sure Fabricator has been fully loaded
    if (! W.fabDependenciesLoaded()) {
        setTimeout(function() {
            runEditScriptSet(F, W);
        }, 10);
        return;
    }

    // Create the controller
    F.controller.make('EditScriptSet', {
        events: {
            'click .js-add-script': function() {
                // Save a reference to the controller
                var self = this;

                $.ajax({
                    url: '/servers/scripts/script-template',
                    success: function(html) {
                        self.$el.find('.js-scripts-container').append(html);
                    }
                });
            },
            'click .js-remove-script': function(e) {
                var $el = $(e.currentTarget);
                var $script = $el.closest('.js-script');
                $script.find('.js-script-delete').val('true');
                $script.hide();
            }
        },

        init: function() {
            // Save a reference to the controller
            var self = this;

            // Get the scripts container element
            var el = self.$el.find('.js-scripts-container').get(0);

            // Instantiate sorting
            window.Sortable.create(el, {
                disableXAxis: true,
                draggable: '.js-script',
                handle: '.js-script-sort-handle',
                animation: 150
            });
        }
    });
}

runEditScriptSet(window.FAB, window);
