import Store from "../utils/Store";
import Helper from "../utils/Helper";
import AuthProvider from "../ServiceProviders/AuthServiceProvider";

export default class Auth {
    /**
     * Check if the session is loggedin.
     *
     * @returns {boolean}
     */
    static isloggedIn() {
        return !_.isEmpty(Store.get(Helper.getSessionKey()).auth)
    }

    /**
     * If session is not logged in redirect to
     *
     * @returns {{name: string}}
     */
    static unAuthenticatedRedirect() {
        return {name: 'login'};
    }

    /**
     * After a user logges in, rediret to.
     *
     * @returns {{name: string}}
     */
    static afterAuthenticationRedirect() {
        return {name: 'example'}
    }

    /**
     * Login the session.
     *
     * @param instance
     * @param params
     * @param options
     */
    static login(instance, params, options = {}) {
        /**
         * Options may have the following keys
         * {
         *  mode: JWT, ...
         *  usePackage: true/false whether to use package or own implementation.
         * }
         */
        const defaultObj = {mode: 'JWT', usePackage: false};
        if (_.isEmpty(options)) options = defaultObj;

        let tokenizer = AuthProvider.init(options).setMode(options.mode || defaultObj.mode).factory().login();

        let obj = {
            mode: options.mode || defaultObj.mode,
            tokenizer: tokenizer.toObject()
        };

        instance.$session.set('auth', obj);
        instance.$router.push(Auth.afterAuthenticationRedirect());
    }

    /**
     * Logout.
     *
     * @param instance
     */
    static logout(instance) {
        instance.$session.remove('auth');
        instance.$router.push(Auth.unAuthenticatedRedirect());
    }
}