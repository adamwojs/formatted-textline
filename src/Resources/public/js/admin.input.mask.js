(function (global, doc) {
    const SELECTOR_FIELD = `[data-input-mask]`;
    const MASK_PLACEHOLDERS = {
        '0': /[0-9]/,
        '9': /[0-9]?/,
        'L': /[A-Za-z]/,
        '?': /[A-Za-z]?/,
        'A': /[A-Za-z0-9]/,
        'a': /[A-Za-z0-9]?/,
        'C': /[A-Za-z0-9_]/,
        'c': /[A-Za-z0-9_]?/,
        'X': /[0-9A-Fa-f]/,
        'x': /[0-9A-Fa-f]?/,
    };

    doc.querySelectorAll(SELECTOR_FIELD).forEach((input) => {
        const mask = input.dataset.inputMask;
        if (mask.length > 0) {
            IMask(input, {
                mask: mask,
                definitions: MASK_PLACEHOLDERS
            })
        }
    });
})(window, window.document);
