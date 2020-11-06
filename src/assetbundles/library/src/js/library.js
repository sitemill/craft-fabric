// Import the plugins
const Uppy = require('@uppy/core')
const XHRUpload = require('@uppy/xhr-upload')
const Dashboard = require('@uppy/dashboard')
const Tus = require('@uppy/tus')

// And their styles (for UI plugins)
// With webpack and `style-loader`, you can require them like this:
require('@uppy/core/dist/style.css')
require('@uppy/dashboard/dist/style.css')

window.Uppy = Uppy;
window.XHRUpload = XHRUpload;
window.Dashboard = Dashboard;

// Register the 'Upload assets' button
(function($) {

    if (typeof Craft.Library === 'undefined') {
        Craft.Library = {};
    }

    var elementTypeClass = 'sitemill\\library\\elements\\LibraryAsset';

    Craft.Library.LibraryAssetIndex = Craft.BaseElementIndex.extend({
        afterInit: function() {
            // Hide the approval button
            var label = Craft.t('library', 'Upload Assets');

            this.$newEventBtnGroup = $('<div class="btngroup submit"/>');
            this.$newEventBtn = $('<a id="upload-library-assets" class="btn submit icon" data-icon="upload">' + label + '</a>').appendTo(this.$newEventBtnGroup);

            this.addButton(this.$newEventBtnGroup);

            this.base();
        },
        showActionTriggers: function() {
            this.base();
            if (this.$source.data('key') != 'staged')
            {
                $('#sitemill-library-elements-actions-Approve-actiontrigger').hide();
                console.log($('#sitemill-library-elements-actions-Approve-actiontrigger'))
            }
        }
    });

    // Register it!
    try {
        Craft.registerElementIndexClass(elementTypeClass, Craft.Library.LibraryAssetIndex);
    } catch (e) {
        // Already registered
    }

})(jQuery);



