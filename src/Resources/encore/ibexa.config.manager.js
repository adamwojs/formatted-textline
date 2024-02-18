const path = require('path');

module.exports = (ibexaConfig, ibexaConfigManager) => {
    ibexaConfigManager.add({
        ibexaConfig,
        entryName: 'ibexa-admin-ui-content-edit-parts-js',
        newItems: [
            path.resolve(__dirname, '../public/js/imask.min.js'),
            path.resolve(__dirname, '../public/js/admin.input.mask.js'),
        ]
    });
};
