--- hi3a create.sql

-----------------------------------------------------------------
--- OAUTH2
-----------------------------------------------------------------

CREATE TABLE oauth_client (
    id                  serial              NOT NULL,
    client_id           text                NOT NULL,
    client_secret       text                NOT NULL,
    redirect_uri        text                NULL,
    grant_types         text                NOT NULL,
    scope               text                NULL
);
SELECT * INTO del_oauth_client FROM oauth_client LIMIT 0;

CREATE TABLE oauth_access_token (
    id                  serial              NOT NULL,
    access_token        text                NOT NULL,
    client_id           text                NOT NULL,
    user_id             integer             NOT NULL,
    expires             timestamp           NOT NULL DEFAULT now(),
    scope               text                NULL
);
SELECT * INTO del_oauth_access_token FROM oauth_access_token LIMIT 0;

CREATE TABLE oauth_refresh_token (
    id                  serial              NOT NULL,
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

-----------------------------------------------------------------
--- RBAC
-----------------------------------------------------------------

CREATE TABLE "rbac_rule" (
    "name"              varchar(64)         NOT NULL,
    "data"              text                NULL,
    "created_at"        integer             NULL,
    "updated_at"        integer             NULL,
    PRIMARY KEY ("name")
);

CREATE TABLE "rbac_item" (
   "name"                 varchar(64)       NOT NULL,
   "type"                 integer           NOT NULL,
   "description"          text              NULL,
   "rule_name"            varchar(64)       NULL,
   "data"                 text              NULL,
   "created_at"           integer           NULL,
   "updated_at"           integer           NULL,
   PRIMARY KEY ("name"),
   FOREIGN KEY ("rule_name") REFERENCES "rbac_rule" ("name") ON DELETE SET NULL ON UPDATE CASCADE
);
CREATE INDEX rbac_item_type_idx on "rbac_item" ("type");

CREATE TABLE "rbac_item_child" (
   "parent"               varchar(64)       NOT NULL,
   "child"                varchar(64)       NOT NULL,
   PRIMARY KEY ("parent","child"),
   FOREIGN KEY ("parent") REFERENCES "rbac_item" ("name") ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY ("child") REFERENCES "rbac_item" ("name") ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE "rbac_assignment" (
   "item_name"            varchar(64)       NOT NULL,
   "user_id"              varchar(64)       NOT NULL,
   "created_at"           integer,
   PRIMARY KEY ("item_name","user_id"),
   FOREIGN KEY ("item_name") REFERENCES "rbac_item" ("name") ON DELETE CASCADE ON UPDATE CASCADE
);

