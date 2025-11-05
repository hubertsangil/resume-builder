-- init.sql
-- Run as the postgres superuser (psql -U postgres -f init.sql)
-- Replace the password below before running

-- create database
CREATE DATABASE resume_site;

-- create a dedicated role (user) for the web app
CREATE ROLE resume_user WITH LOGIN PASSWORD 'REPLACE_WITH_STRONG_PASSWORD';

-- connect to the new database and create schema objects
\connect resume_site

-- create users table
CREATE TABLE public.users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  password_hash TEXT NOT NULL,
  created_at TIMESTAMPTZ DEFAULT now()
);

-- make sure the resume_user can use the public schema
GRANT USAGE ON SCHEMA public TO resume_user;

-- grant minimal table rights needed by the app
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE public.users TO resume_user;

-- give sequence usage so SERIAL works for resume_user
GRANT USAGE, SELECT, UPDATE ON SEQUENCE public.users_id_seq TO resume_user;

-- optionally transfer ownership of the table and sequence to resume_user
-- uncomment the two lines below if you prefer the web user to own the objects
-- ALTER TABLE public.users OWNER TO resume_user;
-- ALTER SEQUENCE public.users_id_seq OWNER TO resume_user;

-- Laravel migration tracking table
CREATE TABLE IF NOT EXISTS public.migrations (
  id SERIAL PRIMARY KEY,
  migration VARCHAR(255) NOT NULL,
  batch INTEGER NOT NULL
);
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE public.migrations TO resume_user;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE public.migrations_id_seq TO resume_user;

-- Laravel sessions table (for SESSION_DRIVER=database)
CREATE TABLE IF NOT EXISTS public.sessions (
  id VARCHAR(255) PRIMARY KEY,
  user_id BIGINT NULL,
  ip_address VARCHAR(45) NULL,
  user_agent TEXT NULL,
  payload TEXT NOT NULL,
  last_activity INTEGER NOT NULL
);
CREATE INDEX IF NOT EXISTS sessions_last_activity_index ON public.sessions (last_activity);
CREATE INDEX IF NOT EXISTS sessions_user_id_index ON public.sessions (user_id);
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE public.sessions TO resume_user;

-- Laravel password reset tokens (optional but safe to include)
CREATE TABLE IF NOT EXISTS public.password_reset_tokens (
  email VARCHAR(255) PRIMARY KEY,
  token VARCHAR(255) NOT NULL,
  created_at TIMESTAMPTZ NULL
);
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE public.password_reset_tokens TO resume_user;
