begin;
create schema liste;
alter schema liste owner to lampi;
create table liste.tipo_doc(id serial primary key, tipo character varying unique not null);
alter table liste.tipo_doc owner to lampi;
insert into liste.tipo_doc(tipo) values ('bilancio preventivo'), ('bilancio consuntivo'),('contributi pubblici');
create table amministrazione(
  id serial primary key,
  anno integer not null check(anno >= 1980 and anno <= date_part('year'::text, CURRENT_DATE)),
  categoria integer not null references liste.tipo_doc(id),
  entrate numeric(10,2),
  uscite numeric(10,2),
  file character varying not null,
  constraint amministrazione_unique unique (anno,categoria,file)
);
SELECT audit.audit_table('amministrazione');
create index amm_idx on amministrazione(categoria);
alter table amministrazione owner to lampi;
commit;
