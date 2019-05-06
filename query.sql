begin;
alter table utenti add column rubrica integer references rubrica(id) on delete cascade;
update utenti set rubrica = rubrica.id from rubrica where utenti.email = rubrica.email;
commit;
