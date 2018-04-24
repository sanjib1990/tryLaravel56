import Config from "../utils/Config";
import Helper from "../utils/Helper";
import JWTHandler from "../models/JWTHandler";

class AuthServiceProvider {
    // authentication can be of any type, jwt, OAuth2 - password, authorization, implicit,
    // Client Credentials Grant

    /**
     * Initiate the Service provider.
     *
     * @returns {AuthServiceProvider}
     */
    init(options) {
        this._authMode = Helper.dataGet(options, 'authMode');
        this._usePackage = Helper.dataGet(options, 'usePackage', Config.get('auth_use_package', false));
        this._supportedAutenticationModes = Helper.dataGet(options, 'supportedModes', Config.get('auth_modes', 'JWT'));

        return this;
    }

    /**
     * Set the mode of authentication.
     *
     * @param authMode
     * @returns {AuthServiceProvider}
     */
    setMode(authMode) {
        if (_.findIndex(this._supportedAutenticationModes, item => item === authMode) < 0) {
            this.noMode();
        }

        this._authMode = authMode;

        return this
    }

    /**
     * Get the mode of authentication.
     *
     * @returns {*}
     */
    getMode() {
        return this._authMode;
    }

    /**
     * Get the instance for the auth provider.
     *
     * @returns {JWTHandler}
     */
    factory() {
        let instance = null;

        switch (this._authMode) {
            case 'JWT':
                instance = JWTHandler;
                break;
            default:
                this.noMode();
        }

        return instance;
    }

    noMode() {
        throw new Error('Auth mode not supported');
    }
}

export default new AuthServiceProvider();