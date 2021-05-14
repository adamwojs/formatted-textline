(function (global, doc, eZ, $) {
    const SELECTOR_FIELD = `[data-input-mask]`;
    const MASK_PLACEHOLDERS = {
        '0': {pattern: /[0-9]/},
        '9': {pattern: /[0-9]/, optional: true},
        'L': {pattern: /[A-Za-z]/},
        '?': {pattern: /[A-Za-z]/, optional: true},
        'A': {pattern: /[A-Za-z0-9]/},
        'a': {pattern: /[A-Za-z0-9]/, optional: true},
        'C': {pattern: /[A-Za-z0-9_]/},
        'c': {pattern: /[A-Za-z0-9_]/, optional: true},
        'X': {pattern: /[0-9A-Fa-f]/},
        'x': {pattern: /[0-9A-Fa-f]/, optional: true},
    };

    doc.querySelectorAll(SELECTOR_FIELD).forEach((input) => {
        const mask = input.dataset.inputMask;

        if (mask.length > 0) {
            $(input).mask(input.dataset.inputMask, {
                'translation': MASK_PLACEHOLDERS
            });
        }
    });
})(window, window.document, window.eZ, window.jQuery);
