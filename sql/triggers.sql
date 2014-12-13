
--- OAUTH_CLIENT
CREATE TRIGGER reodb_before_insert_trigger          BEFORE  INSERT  ON oauth_client FOR EACH ROW EXECUTE PROCEDURE reodb_before_insert_trigger();
CREATE TRIGGER reodb_after_update_trigger           AFTER   UPDATE  ON oauth_client FOR EACH ROW EXECUTE PROCEDURE reodb_after_update_trigger();
CREATE TRIGGER reodb_simple_delete_trigger          BEFORE  DELETE  ON oauth_client FOR EACH ROW EXECUTE PROCEDURE reodb_simple_delete_trigger();
CREATE TRIGGER reodb_after_delete_trigger           AFTER   DELETE  ON oauth_client FOR EACH ROW EXECUTE PROCEDURE reodb_after_delete_trigger();

