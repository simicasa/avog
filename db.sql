create table progetto(codice varchar(20), nome varchar(20), primary key(codice));

create table sede_progetto(codiceSede varchar(20), codiceProgetto varchar(20), posti int(4), foreign key(codiceSede) references sede(codice) on update cascade on delete cascade, foreign key(codiceProgetto) references progetto(codice) on update cascade on delete cascade, primary key(codiceSede, codiceProgetto));

create table login(utente varchar(20), password varchar(20), primary key(utente));

insert into login(utente, password) values('simone', 'napoli');

create table persona(nome varchar(20), cognome varchar(30), cf varchar(20), primary key(cf));

create table esame(codice int(6) auto_increment, codiceProgetto varchar(20), dataInizio date, limitePartecipanti int(5), foreign key(codiceProgetto) references progetto(codice) on update cascade on delete cascade, primary key(codice));

create table persona_esame(cf varchar(20), codiceEsame int(6), dataEsame date, foreign key(cf) references persona(cf) on update cascade on delete cascade, foreign key(codiceEsame) references esame(codice) on update cascade on delete cascade, primary key (cf, codiceEsame));

create table opzioni(esaminandiGiornalieri int(4));