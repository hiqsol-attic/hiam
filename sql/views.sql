--- OAUTH views

--- FOR user
CREATE OR REPLACE VIEW users AS
    SELECT      c.obj_id AS id,c.login AS username,c.password,
                z.name AS status
    FROM        client      c
    JOIN        ref         z ON z.obj_id=c.state_id
;

--- FOR oauth
CREATE OR REPLACE VIEW oauth_users AS
    SELECT      c.obj_id AS id,c.login AS username,c.password,
                k.first_name,k.last_name
    FROM        client      c
    JOIN        contact     k ON k.obj_id=c.obj_id
;

CREATE OR REPLACE VIEW oauth_access_tokens AS
    SELECT      t.id,t.access_token,
                t.oauth_client_id   AS client_id,
                t.oauth_user_id     AS user_id,
                t.expires,t.scope
    FROM        oauth_access_token  t
;

CREATE OR REPLACE VIEW oauth_scopes AS
    SELECT      c.obj_id AS id,c.scope,c.is_default
    FROM        oauth_scope         c
;
