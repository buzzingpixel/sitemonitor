function runFilterTable(F, W) {
    'use strict';

    // Make sure Fabricator has been fully loaded
    if (! W.fabDependenciesLoaded()) {
        setTimeout(function() {
            runFilterTable(F, W);
        }, 10);
        return;
    }

    // Create the controller
    F.controller.make('FilterTable', {
        filterRespondTimer: 0,
        filterValue: '',

        events: {
            'change .js-filter-table__input': function(e) {
                // Run filter respond method
                this.filterRespond(e);
            },

            'keyup .js-filter-table__input': function(e) {
                // Run filter respond method
                this.filterRespond(e);
            }
        },

        filterRespond: function(e) {
            // Save a reference to the controller
            var self = this;

            // Set the filter value
            self.filterValue = e.currentTarget.value.toUpperCase();

            // Clear previous timer
            clearTimeout(self.filterRespondTimer);

            // Set new timer
            self.filterRespondTimer = setTimeout(function() {
                // Run the filter
                self.runFilter();
            }, 300);
        },

        runFilter: function() {
            // Save a reference to the controller
            var self = this;

            // Get rows
            var $rows = $('.js-filter-table__row');

            // Get parent hiders
            var $parentHiders = $('.js-filter-table__parent-hide-on-no-results');

            // If there is no filter value, show all rows
            if (! self.filterValue) {
                $rows.show();
                $parentHiders.show();
                return;
            }

            // Iterate through rows
            $rows.each(function() {
                // Cast the row element
                var $row = $(this);

                // If we have an index of content, show the row, otherwise hide
                if ($row.html().toUpperCase().indexOf(self.filterValue) > -1) {
                    $row.show();
                } else {
                    $row.hide();
                }
            });

            // Iterate through parent hide elements
            $parentHiders.each(function() {
                // Cast this parent
                var $thisParent = $(this);

                // Get the rows for this parent
                var $thisRows = $thisParent.find('.js-filter-table__row');

                // Set variable for is visible
                var isVisible = false;

                $thisRows.each(function() {
                    if ($(this).is(':visible')) {
                        isVisible = true;
                    }
                });

                // If visible, show the parent, otherwise hide it
                if (isVisible) {
                    $thisParent.show();
                } else {
                    $thisParent.hide();
                }
            });
        }
    });
}

runFilterTable(window.FAB, window);
