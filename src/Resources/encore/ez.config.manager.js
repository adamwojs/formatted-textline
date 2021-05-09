const path = require('path');

module.exports = (eZConfig, eZConfigManager) => {
    eZConfigManager.add({
        eZConfig,
        entryName: 'ezplatform-admin-ui-content-edit-parts-js',
        newItems: [
            path.resolve(__dirname, '../public/js/jquery.mask.js'),
            path.resolve(__dirname, '../public/js/masked-textline.js'),
        ]
    });
};
