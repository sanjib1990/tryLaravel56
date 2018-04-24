import Tokenizer from "./Tokenizer";

class JWTHandler {
    /**
     * Login.
     *
     * @returns {Tokenizer}
     */
    login() {
        return new Tokenizer({
            token: "asd",
            expires_in: "aasas",
            refresh_token: "asdad",
            token_type: "asdsad"
        });
    }

    /**
     * Refresh Token.
     *
     * @returns {Tokenizer}
     */
    refresh() {
        return new Tokenizer({
            token: "",
            expires_in: "",
            refresh_token: "",
            token_type: ""
        });
    }
}

export default new JWTHandler()