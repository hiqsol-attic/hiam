--- OAUTH create.sql

-----------------------------------------------------------------
--- CLIENT: client, subclient
-----------------------------------------------------------------

CREATE TABLE oauth_client (
    obj_id              integer             NOT NULL,
    type_id             integer             NOT NULL,
    state_id            integer             NOT NULL,
    client_id           text                NOT NULL,
    client_secret       text                NOT NULL,
    redirect_uri        text                NULL,
    grant_types         text                NOT NULL,
    scope               text                NULL
);
SELECT * INTO del_oauth_client FROM oauth_client LIMIT 0;

CREATE SEQUENCE "oauth_access_token_id_seq" START 1000000;
CREATE TABLE oauth_access_token (
    id                  integer             NOT NULL DEFAULT nextval('oauth_access_token_id_seq'),
    access_token        text                NOT NULL,
    client_id           text                NOT NULL,
    user_id             integer             NOT NULL,
    expires             timestamp           NOT NULL DEFAULT now(),
    scope               text                NULL
);
SELECT * INTO del_oauth_access_token FROM oauth_access_token LIMIT 0;

CREATE SEQUENCE "oauth_refresh_token_id_seq" START 1000000;
CREATE TABLE oauth_refresh_token (
    id                  integer             NOT NULL DEFAULT nextval('oauth_refresh_token_id_seq'),
    refresh_token       text                NOT NULL,
    client_id           text                NOT NULL,
    user_id             integer             NOT NULL,
    expires             timestamp           NOT NULL DEFAULT now(),
    scope               text                NULL
);
SELECT * INTO del_oauth_refresh_token FROM oauth_refresh_token LIMIT 0;

CREATE TABLE oauth_scope (
    obj_id              integer             NOT NULL,
    type_id             integer             NOT NULL,
    state_id            integer             NOT NULL,
    scope               text                NOT NULL,
    is_default          boolean             NOT NULL DEFAULT FALSE
);
SELECT * INTO del_oauth_scope FROM oauth_scope LIMIT 0;

CREATE SEQUENCE "oauth_authorization_code_id_seq" START 1000000;
CREATE TABLE oauth_authorization_code (
    id                  integer             NOT NULL DEFAULT nextval('oauth_authorization_code_id_seq'),
    authorization_code  text                NULL,
    client_id           text                NOT NULL,
    user_id             integer             NOT NULL,
    redirect_uri        text                NOT NULL,
    expires             timestamp           NOT NULL DEFAULT now(),
    scope               text                NULL
);
SELECT * INTO del_oauth_authorization_code FROM oauth_authorization_code LIMIT 0;

