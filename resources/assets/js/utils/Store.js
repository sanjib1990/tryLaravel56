import PStore from "store";

export default class Store {
    /**
     * Set a value in storeage.
     *
     * @param key
     * @param value
     */
    static set(key, value) {
        PStore.set(key, value);
    }

    /**
     * Get a value from storage.
     *
     * @param key
     * @param _default
     * @returns {*}
     */
    static get(key, _default = null) {
        return PStore.get(key, _default);
    }

    /**
     * Remove a key from storage.
     *
     * @param key
     */
    static remove(key) {
        PStore.remove(key);
    }

    /**
     * Flush all items in storage.
     */
    static flush() {
        PStore.clearAll();
    }

    /**
     * Loop over all stored values.
     *
     * @param clouser
     */
    static each(clouser) {
        PStore.each(clouser());
    }
}
