-- begin;
--
-- commit;
select
  p.id,
  p.copertina,
  p.titolo,
  p.data,
  p.testo,
  p.bozza,
  p.tag,
  r.email
from
  post p,
  utenti u,
  rubrica r
where
  p.usr = u.id and
  u.rubrica = r.id
order by data desc;
