--- TABLE CLASSES
SELECT set_ref('class,oauth_client',            '{Lang:OAuth Client}');
SELECT set_ref('class,oauth_scope',             '{Lang:OAuth Scope}');

-- OAUTH_CLIENT types
SELECT set_ref( 0,'type,oauth_client',          '{Lang:OAuth client types}');
SELECT set_ref( 1,'type,oauth_client,default',  '{Lang:Default}');

-- OAUTH_CLIENT states
SELECT set_ref( 0,'state,oauth_client',         '{Lang:OAuth client states}');
SELECT set_ref( 1,'state,oauth_client,ok',      '{Lang:Ok}');
SELECT set_ref( 2,'state,oauth_client,deleted', '{Lang:Deleted}');

-- OAUTH_SCOPE types
SELECT set_ref( 0,'type,oauth_scope',           '{Lang:OAuth scope types}');
SELECT set_ref( 1,'type,oauth_scope,default',   '{Lang:Default}');

-- OAUTH_SCOPE states
SELECT set_ref( 0,'state,oauth_scope',          '{Lang:OAuth scope states}');
SELECT set_ref( 1,'state,oauth_scope,ok',       '{Lang:Ok}');
SELECT set_ref( 2,'state,oauth_scope,deleted',  '{Lang:Deleted}');

