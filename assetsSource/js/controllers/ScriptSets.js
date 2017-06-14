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
        model: {
            scriptsCollapsed: 'bool'
        },

        events: {
            'click .js-add-script': function() {
                // Save a reference to the controller
                var self = this;

                $.ajax({
                    url: '/servers/scripts/script-template',
                    success: function(html) {
                        var $html = $(html);
                        self.$el.find('.js-scripts-container').append($html);
                        F.controller.construct('CodeEditor', {
                            el: $html.find('.js-code-editor').get(0)
                        });
                    }
                });
            },
            'click .js-remove-script': function(e) {
                var $el = $(e.currentTarget);
                var $script = $el.closest('.js-script');
                $script.find('.js-script-delete').val('true');
                $script.hide();
            },
            'click .js-scripts-collapse-expand': function() {
                // Save a reference to the controller
                var self = this;

                // Set model
                self.model.set(
                    'scriptsCollapsed',
                    ! self.model.get('scriptsCollapsed')
                );
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

            // Watch for scripts collapsed model changes
            self.model.onChange('scriptsCollapsed', function(val) {
                if (val) {
                    self.collapseScripts();
                    return;
                }
                self.expandScripts();
            });
        },

        collapseScripts: function() {
            // Save a reference to the controller
            var self = this;

            // Get the script bodies
            var $scriptBodies = self.$el.find('.js-script-body');

            // Collapse scripts
            $scriptBodies.slideUp(100);

            // Iterate through script bodies and set title
            $scriptBodies.each(function() {
                var $el = $(this);
                var $script = $el.closest('.js-script');
                $script.find('.js-script-name-holder').text(
                    ': ' + $script.find('.js-script-name').val()
                );
            });

            // Hide the collapse option
            self.$el.find('.js-collapse-scripts').hide();

            // Show the expand scripts option
            self.$el.find('.js-expand-scripts').show();
        },

        expandScripts: function() {
            // Save a reference to the controller
            var self = this;

            // Get the script bodies
            var $scriptBodies = self.$el.find('.js-script-body');

            // Expand scripts
            $scriptBodies.slideDown(100);

            // Iterate through script bodies and unset title
            $scriptBodies.each(function() {
                var $el = $(this);
                var $script = $el.closest('.js-script');
                $script.find('.js-script-name-holder').text('');
            });

            // Show the collapse option
            self.$el.find('.js-collapse-scripts').show();

            // Hide the expand scripts option
            self.$el.find('.js-expand-scripts').hide();
        }
    });
}

runEditScriptSet(window.FAB, window);
