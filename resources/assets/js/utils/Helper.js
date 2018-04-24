export default class Helper {
    static empty(item) {
        return item === null || item === undefined || item.length === 0;
    }

    /**
     * Get an element in an object.
     *
     * @param {object} item       the actual object.
     * @param {string} keystring  dot separated key string to access an item in an object.
     * @param defaultValue        The default value if the given key is not found.
     * @returns {any | null}
     */
    static dataGet(item, keystring, defaultValue) {
        if (!item) {
            return defaultValue || null;
        }

        const currentKey = keystring.substring(0, keystring.indexOf('.')) || keystring;
        if (keystring.length !== 0 && keystring.indexOf('.') !== -1) {
            keystring = keystring.replace(currentKey + '.', '');

            return this.dataGet(item[currentKey], keystring, defaultValue);
        }

        return item[currentKey] || defaultValue || null;
    }

    /**
     * Get the session key in which all the session data are stored.
     *
     * @returns {*}
     */
    static getSessionKey() {
        return appConfig.sessionkey;
    }
}