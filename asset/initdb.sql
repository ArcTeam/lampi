--SELECT audit.audit_table('target_table_name');
drop database if exists lampi;
drop user if exists lampi;
create user lampi with encrypted password 'laMP1d8adMIn';
create database lampi WITH TEMPLATE = template0;
alter database lampi owner to lampi;

\connect lampi
\i audit.sql

create extension pgcrypto;
alter schema audit owner to lampi ;
alter schema public owner to lampi ;
alter table audit.logged_actions owner to lampi;

create table utenti(
  id serial primary key,
  email character varying unique not null,
  utente character varying not null,
  password text not null
);
create index usr_idx on utenti(email);
SELECT audit.audit_table('utenti');
insert into utenti(email,utente,password) values ('admin@lampi.com','admin',crypt('admin', gen_salt('bf', 8)));

create table rubrica(
  id serial primary key,
  socio boolean not null default 'f',
  cognome character varying not null,
  nome character varying,
  email character varying unique,
  indirizzo character varying,
  cellulare character varying,
  fisso character varying,
  note text
);
create index usr_idx on utenti(email);
SELECT audit.audit_table('utenti');

create table iscrizioni(
  id serial primary key,
  cognome character varying not null,
  nome character varying not null,
  email character varying unique not null,
  indirizzo character varying not null,
  note text
);
