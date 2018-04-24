import Helper from "../utils/Helper";

export default class Tokenizer {
    constructor(options) {
        this._options = options;
        this._setAndValidateOptions();
    }

    /**
     * Set and validate member variables.
     *
     * @returns {Tokenizer}
     * @private
     */
    _setAndValidateOptions() {
        if (! this._options) throw new Error('Options not provided for Tokenizer');

        return this
            ._setAndValidateToken()
            ._setAndValidateTokenType()
            ._setAndValidateExpiresIn()
            ._setAndValidateRefreshToken();
    }

    /**
     * Set and validate expires in.
     *
     * @returns {Tokenizer}
     * @private
     */
    _setAndValidateExpiresIn() {
        const expiresIn = Helper.dataGet(this._options, 'expires_in');
        if (! expiresIn) throw new Error('Missing expires_in in Options ');

        this.expiresIn = expiresIn;

        return this;
    }

    /**
     * Set and validate token type.
     *
     * @returns {Tokenizer}
     * @private
     */
    _setAndValidateTokenType() {
        const tokenType = Helper.dataGet(this._options, 'token_type');
        if (! tokenType) throw new Error('Missing token_type in Options ');

        this.tokenType = tokenType;

        return this;
    }

    /**
     * Set and validate refresh token.
     *
     * @returns {Tokenizer}
     * @private
     */
    _setAndValidateRefreshToken() {
        const token = Helper.dataGet(this._options, 'refresh_token');
        if (! token) throw new Error('Missing refresh_token in Options ');

        this.refreshToken = token;

        return this;
    }

    /**
     * Set and validate token.
     *
     * @returns {Tokenizer}
     * @private
     */
    _setAndValidateToken() {
        const token = Helper.dataGet(this._options, 'token');
        if (! token) throw new Error('Missing token in Options ');

        this.token = token;

        return this;
    }

    /**
     * Set Token.
     *
     * @param token
     */
    set token(token) {
        this._token = token;
    }

    /**
     * Get Token.
     *
     * @returns {*}
     */
    get token() {
        return this._token;
    }

    /**
     * Set Refresh Token.
     *
     * @param token
     */
    set refreshToken(token) {
        this._refreshToken = token;
    }

    /**
     * Get Refresh token.
     *
     * @returns {*}
     */
    get refreshToken() {
        return this._refreshToken;
    }

    /**
     * Set Token type.
     *
     * @param tokenType
     */
    set tokenType(tokenType) {
        this._tokenType = tokenType;
    }

    /**
     * Get Token type.
     *
     * @returns {*}
     */
    get tokenType() {
        return this._tokenType;
    }

    /**
     * Set Expires In.
     *
     * @param expiresIn
     */
    set expiresIn(expiresIn) {
        this._expiresIn = expiresIn;
    }

    /**
     * Get expires in.
     *
     * @returns {*}
     */
    get expiresIn() {
        return this._expiresIn;
    }

    /**
     * To Object Implementation.
     *
     * @returns {{token: *, token_type: *, expires_in: *, refresh_token: *}}
     */
    toObject() {
        return {
            token: this.token,
            token_type: this.tokenType,
            expires_in: this.expiresIn,
            refresh_token: this.refreshToken
        };
    }

    /**
     * To String implementation.
     *
     * @returns {string}
     */
    toString() {
        return JSON.stringify(this.toObject());
    }
}
