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
  password text not null,
  classe integer not null check(classe in(1,2)),
  attivo boolean not null default 't'
);
comment on column utenti.classe is '1:utente semplice; 2:amministratore.';
create index usr_idx on utenti(email);
SELECT audit.audit_table('utenti');
alter table utenti owner to lampi;
insert into utenti(email,password,classe) values ('associazione.lampi@gmail.com',crypt('admin', gen_salt('bf', 8)),2);
insert into utenti(email,password,classe) values ('beppenapo@gmail.com',crypt('test', gen_salt('bf', 8)),1);

create table rubrica(
  id serial primary key,
  cognome character varying not null,
  nome character varying,
  email character varying not null unique,
  indirizzo character varying,
  cellulare character varying,
  fisso character varying,
  note text
);
create index rubrica_idx on utenti(email);
SELECT audit.audit_table('utenti');
alter table rubrica owner to lampi;

create table soci( rubrica integer primary key references rubrica(id) on delete cascade );
SELECT audit.audit_table('soci');
alter table soci owner to lampi;

create table quote(
  id serial primary key,
  socio integer not null references soci(rubrica),
  data date not null,
  tipo integer not null check (tipo in(1,2)),
  constraint quote_unique unique(socio,data)
);
SELECT audit.audit_table('quote');
alter table quote owner to lampi;
comment on column quote.tipo is '1=iscrizione; 2=rinnovo';

create table iscrizioni(
  id serial primary key,
  cognome character varying not null,
  nome character varying not null,
  email character varying unique not null,
  indirizzo character varying not null,
  versamento character varying,
  note text
);
SELECT audit.audit_table('iscrizioni');
comment on table iscrizioni is 'la tabella tiene traccia delle nuove richieste di iscrizione. Una volta convalidata da un responsabile, il record verrà cancellato e ne verrà creato uno nuovo con i dati presenti in questa tabella';
alter table iscrizioni owner to lampi;

create table organigramma(
  anno integer primary key,
  presidente integer not null references soci(rubrica),
  vicepresidente integer not null references soci(rubrica),
  segretario integer not null references soci(rubrica),
  tesoriere integer not null references soci(rubrica),
  consiglieri integer[] not null
);
SELECT audit.audit_table('organigramma');
alter table organigramma owner to lampi;

create table autori(
  id serial primary key,
  cognome character varying not null,
  nome character varying not null,
  anno integer,
  bio text
);
SELECT audit.audit_table('organigramma');
alter table autori owner to lampi;

create table biblio(
  id serial primary key,
  autore_principale integer not null references autori(id),
  autori_secondari integer[],
  titolo character varying not null unique,
  anno integer not null,
  luogo character varying not null,
  descrizione text not null
);
SELECT audit.audit_table('biblio');
alter table biblio owner to lampi;

create table tag(id serial primary key, tag character varying unique not null);
create index tag_idx on tag(tag);
SELECT audit.audit_table('tag');
alter table tag owner to lampi;

create table post(
  id serial primary key,
  data date not null,
  titolo character varying not null unique,
  testo text not null,
  tag integer[],
  usr integer not null references utenti(id)
);
SELECT audit.audit_table('post');
alter table post owner to lampi;

create table eventi(
  id serial primary key,
  data date not null,
  titolo character varying not null unique,
  testo text not null,
  tag integer[],
  usr integer not null references utenti(id)
);
SELECT audit.audit_table('eventi');
alter table eventi owner to lampi;

create table viaggi(
  id serial primary key,
  partenza timestamp with time zone not null,
  rientro timestamp with time zone not null check(rientro >= partenza),
  titolo character varying not null unique,
  testo text not null,
  tag integer[],
  usr integer not null references utenti(id)
);
SELECT audit.audit_table('viaggi');
alter table viaggi owner to lampi;
