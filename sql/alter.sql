
--- PKEYS
ALTER TABLE ONLY oauth_client       ADD CONSTRAINT oauth_client_obj_id_pkey             PRIMARY KEY (obj_id);
ALTER TABLE ONLY oauth_scope        ADD CONSTRAINT oauth_scope_obj_id_pkey              PRIMARY KEY (obj_id);
ALTER TABLE ONLY oauth_access_token ADD CONSTRAINT oauth_access_token_id_pkey           PRIMARY KEY (id);
ALTER TABLE ONLY oauth_refresh_token ADD CONSTRAINT oauth_refresh_token_id_pkey         PRIMARY KEY (id);
ALTER TABLE ONLY oauth_authorization_code ADD CONSTRAINT oauth_authorization_code_id_pkey PRIMARY KEY (id);

--- OAUTH_CLIENT
ALTER TABLE ONLY oauth_client       ADD CONSTRAINT oauth_client_obj_id_fkey             FOREIGN KEY (obj_id)        REFERENCES obj (obj_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE ONLY oauth_client       ADD CONSTRAINT oauth_client_client_id_uniq          UNIQUE (client_id);
ALTER TABLE ONLY oauth_client       ADD CONSTRAINT oauth_client_type_id_fkey            FOREIGN KEY (type_id)       REFERENCES ref (obj_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE ONLY oauth_client       ADD CONSTRAINT oauth_client_state_id_fkey           FOREIGN KEY (state_id)      REFERENCES ref (obj_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;
CREATE INDEX                        oauth_client_type_id_idx                            ON oauth_client (type_id);
CREATE INDEX                        oauth_client_state_id_idx                           ON oauth_client (state_id);

--- OAUTH_SCOPE
ALTER TABLE ONLY oauth_scope        ADD CONSTRAINT oauth_scope_obj_id_fkey              FOREIGN KEY (obj_id)        REFERENCES obj (obj_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE ONLY oauth_scope        ADD CONSTRAINT oauth_scope_scope_uniq               UNIQUE (scope);
ALTER TABLE ONLY oauth_scope        ADD CONSTRAINT oauth_scope_type_id_fkey             FOREIGN KEY (type_id)       REFERENCES ref (obj_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE ONLY oauth_scope        ADD CONSTRAINT oauth_scope_state_id_fkey            FOREIGN KEY (state_id)      REFERENCES ref (obj_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;
CREATE INDEX                        oauth_scope_type_id_idx                             ON oauth_scope (type_id);
CREATE INDEX                        oauth_scope_state_id_idx                            ON oauth_scope (state_id);

--- OAUTH_ACCESS_TOKEN
ALTER TABLE ONLY oauth_access_token ADD CONSTRAINT oauth_access_token_access_token_uniq UNIQUE (access_token);
ALTER TABLE ONLY oauth_access_token ADD CONSTRAINT oauth_access_token_client_id_fkey    FOREIGN KEY (client_id)     REFERENCES oauth_client (client_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;

--- OAUTH_REFRESH_TOKEN
ALTER TABLE ONLY oauth_refresh_token ADD CONSTRAINT oauth_refresh_token_refresh_token_uniq UNIQUE (refresh_token);
ALTER TABLE ONLY oauth_refresh_token ADD CONSTRAINT oauth_refresh_token_client_id_fkey  FOREIGN KEY (client_id)     REFERENCES oauth_client (client_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;

--- OAUTH_AUTHORIZATION_CODE
ALTER TABLE ONLY oauth_authorization_code ADD CONSTRAINT oauth_authorization_code_authorization_code_uniq UNIQUE (authorization_code);
ALTER TABLE ONLY oauth_authorization_code ADD CONSTRAINT oauth_authorization_code_client_id_fkey FOREIGN KEY (client_id) REFERENCES oauth_client (client_id)
                                                                                        ON UPDATE CASCADE ON DELETE RESTRICT;

