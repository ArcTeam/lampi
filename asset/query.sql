﻿-- insert into rubrica(nome,cognome, email) values
--   ('Walter','Iori','iori@walter.com'),
--   ('Giuseppe', 'Wegher','g@w.com'),
--   ('Costantino', 'Pellegrini','g@p.com'),
--   ('Orlando', 'Gabardi','o@g.com'),
--   ('Aldo', 'Angeli', 'a@a.com'),
--   ('Denis', 'Francisci', 'd@f.com'),
--   ('Alberto', 'Mosca', 'a@m.com'),
--   ('Marina', 'Patil','m@patil.com'),
--   ('Maurizio', 'Visintin','m@vis.com');
-- insert into soci(rubrica) select id from rubrica;
--
-- drop view if exists rubrica_view;
-- create view rubrica_view as
-- select r.id, r.cognome, r.nome, r.email, r.indirizzo, r.cellulare, r.fisso, r.note, s.rubrica as socio, u.id as utente from rubrica r
-- left join soci s on s.rubrica = r.id
-- left join utenti u on u.email = r.email;
-- alter view rubrica_view owner to lampi;

drop view if exists organigramma_view;
create view organigramma_view as(
with consiglieri as (
  select o.anno, json_object_agg(r.id,r.cognome||' '||r.nome) as cons
  from rubrica r
  inner join (select o.anno, unnest(o.consiglieri) c from organigramma o) o on o.c = r.id
  group by o.anno
)
SELECT
  org.*,
  pr.cognome||' '||pr.nome pres,
  vp.cognome||' '||vp.nome vicepres,
  seg.cognome||' '||seg.nome segr,
  tes.cognome||' '||tes.nome tes,
  consiglieri.cons
FROM organigramma org
INNER JOIN rubrica pr ON org.presidente = pr.id
INNER JOIN rubrica vp ON org.vicepresidente = vp.id
INNER JOIN rubrica seg ON org.segretario = seg.id
INNER JOIN rubrica tes ON org.tesoriere = tes.id
INNER JOIN consiglieri on consiglieri.anno = org.anno
ORDER BY anno DESC);
ALTER VIEW organigramma_view OWNER TO lampi;

