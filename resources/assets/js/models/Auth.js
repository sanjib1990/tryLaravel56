import Store from "../utils/Store";
import Helper from "../utils/Helper";

export default class Auth {
    /**
     * Check if the session is loggedin.
     *
     * @returns {boolean}
     */
    static isloggedIn() {
        return ! _.isEmpty(Store.get(Helper.getSessionKey()).auth)
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
        return { name: 'example' }
    }

    /**
     * Login the session.
     *
     * @param instance
     * @param value
     */
    static login (instance, value) {
        instance.$session.set('auth', value);
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