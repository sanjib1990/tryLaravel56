import Helper from "./Helper";

export default class Config{
    /**
     * Get a value from config.
     *
     * @param key
     * @param _default
     * @returns {any}
     */
    static get(key, _default = null) {
        return Helper.dataGet(appConfig, key, _default);
    }
}