import Auth from "../models/Auth";

export default class AccessMiddleware {
    static auth(to, from, next) {
        if (to.matched.some(record => record.meta.auth) && ! Auth.isloggedIn()) {
            next(Auth.unAuthenticatedRedirect());
            return;
        }

        if (to.matched.some(record => record.meta.checkAlreadyLoggedIn) && Auth.isloggedIn()) {
            next(Auth.afterAuthenticationRedirect());
            return;
        }

        next();
    }
}