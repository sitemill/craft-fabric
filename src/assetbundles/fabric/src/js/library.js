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

    if (typeof Craft.Fabric === 'undefined') {
        Craft.Fabric = {};
    }

    var elementTypeClass = 'sitemill\\fabric\\elements\\LibraryAsset';

    Craft.Fabric.LibraryAssetIndex = Craft.BaseElementIndex.extend({
        afterInit: function() {
            // Hide the approval button
            var label = Craft.t('fabric', 'Upload Assets');

            this.$newEventBtnGroup = $('<div class="btngroup submit"/>');
            this.$newEventBtn = $('<a id="upload-fabric-assets" class="btn submit icon" data-icon="upload">' + label + '</a>').appendTo(this.$newEventBtnGroup);

            this.addButton(this.$newEventBtnGroup);

            this.base();
        },
        showActionTriggers: function() {
            this.base();
            if (this.$source.data('key') != 'staged')
            {
                $('#sitemill-fabric-elements-actions-Approve-actiontrigger').hide();
                console.log($('#sitemill-fabric-elements-actions-Approve-actiontrigger'))
            }
        }
    });

    // Register it!
    try {
        Craft.registerElementIndexClass(elementTypeClass, Craft.Fabric.FabricAssetIndex);
    } catch (e) {
        // Already registered
    }

})(jQuery);



