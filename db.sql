create table sede(codice varchar(100), nome varchar(100), unique(codice));
#alter table sede modify nome varchar(100);

create table progetto(codice varchar(100), nome varchar(100), primary key(codice));
#alter table progetto modify nome varchar(100);

create table sede_progetto(codiceSede varchar(20), codiceProgetto varchar(20), posti int(4), foreign key(codiceSede) references sede(codice) on update cascade on delete cascade, foreign key(codiceProgetto) references progetto(codice) on update cascade on delete cascade, primary key(codiceSede, codiceProgetto));

create table login(utente varchar(20), password varchar(20), primary key(utente));

insert into login(utente, password) values('simone', 'napoli');

create table persona(id int(7) auto_increment, nome varchar(20), cognome varchar(30), dataNascita date, cf varchar(20), primary key(id), unique(cf));

create table esame(codice int(6) auto_increment, codiceSede varchar(20), codiceProgetto varchar(20), dataInizio date, limitePartecipanti int(5), foreign key(codiceProgetto) references progetto(codice) on update cascade on delete cascade, foreign key(codiceSede) references sede(codice) on update cascade on delete cascade, primary key(codice), unique(codiceSede, codiceProgetto));

create table persona_esame(protocollo int(10) auto_increment, cf varchar(20), personaID int(7), codiceEsame int(6), dataConsegna date, dataEsame date, seMattina int(1), foreign key(codiceEsame) references esame(codice) on update cascade on delete cascade, foreign key(personaID) references persona(id) on update cascade on delete cascade, primary key(protocollo), unique(cf, codiceEsame));
/*
create table persona_esame(cf varchar(20), codiceEsame int(6), dataConsegna date, dataEsame date, seMattina int(1), foreign key(cf) references persona(cf) on update cascade on delete cascade, foreign key(codiceEsame) references esame(codice) on update cascade on delete cascade, primary key (cf, codiceEsame));
*/

create table opzioni(esaminandiGiornalieri int(4), postiMattina int(3), postiPomeriggio int(3), orarioMattina varchar(10), orarioPomeriggio varchar(10));