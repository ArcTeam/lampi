-- begin;
--
-- commit;
\x
select rubrica.*,utenti.classe,utenti.attivo from rubrica,utenti where utenti.rubrica = rubrica.id limit 1;
