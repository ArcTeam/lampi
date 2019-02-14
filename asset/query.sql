-- insert into rubrica(nome,cognome, email) values
--   ('Walter','Iori','iori@walter.com'),
--   ('Giuseppe', 'Wegher','g@w.com'),
--   ('Costantino', 'Pellegrini','g@p.com'),
--   ('Orlando', 'Gabardi','o@g.com'),
--   ('Aldo', 'Angeli', 'a@a.com'),
--   ('Denis', 'Francisci', 'd@f.com'),
--   ('Alberto', 'Mosca', 'a@m.com'),
--   ('Marina', 'Patil','m@patil.com'),
--   ('Maurizio', 'Visintin','m@vis.com');
--
-- insert into soci(rubrica) select id from rubrica;

drop view if exists rubrica_view;
create view rubrica_view as
select r.id, r.cognome, r.nome, r.email, r.indirizzo, r.cellulare, r.fisso, r.note, s.rubrica as socio, u.id as utente from rubrica r
left join soci s on s.rubrica = r.id
left join utenti u on u.email = r.email;
alter view rubrica_view owner to lampi;
