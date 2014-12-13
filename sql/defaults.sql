
--- TYPES
ALTER TABLE ONLY oauth_client       ALTER type_id       SET DEFAULT type_id('oauth_client,default');

--- STATES
ALTER TABLE ONLY oauth_client       ALTER state_id      SET DEFAULT state_id('oauth_client,ok');

