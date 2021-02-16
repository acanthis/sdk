#!/bin/bash
set -e
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
CREATE SCHEMA IF NOT EXISTS $POSTGRES_SCHEMA;
CREATE OR REPLACE FUNCTION $POSTGRES_SCHEMA.update_timestamp() RETURNS TRIGGER AS '
    BEGIN
       IF row(NEW.*) IS DISTINCT FROM row(OLD.*) THEN
          NEW.updated_at = now();
          RETURN NEW;
       ELSE
          RETURN OLD;
       END IF;
    END;
' language 'plpgsql';
EOSQL