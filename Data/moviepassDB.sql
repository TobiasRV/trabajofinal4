create database MoviePass;
use MoviePass;


-------------------------------------------------------------------------------
--                               TABLES
-------------------------------------------------------------------------------

create table MovieTheaters(
id_movietheater int auto_increment,
name varchar(20),
address varchar(20),
ticketPrice int not null,
status boolean,
CONSTRAINT pk_id_movietheater primary key (id_movietheater),
CONSTRAINT unq_name UNIQUE (name)
);

create table Cinemas(
id_cinema int auto_increment,
status boolean,
name varchar(50),
id_movietheater int,
CONSTRAINT pk_id_cinema primary key (id_cinema),
constraint fk_id_movietheater foreign key(id_movietheater) references MovieTheaters (id_movietheater)
);

create table Movies(
id_movie int,
title varchar(50),
originalTitle varchar(50),
adult boolean,
posterPath varchar(100),
releaseDate date,
backdropPath varchar(100),
overview varchar(2000),
CONSTRAINT pk_id_movie primary key (id_movie)
);

create table shows(
id_show int auto_increment,
show_date date,
show_time time,
seats int,
id_cinema int,
id_movie int,
CONSTRAINT pks_shows primary key (id_show),
CONSTRAINT fk_shows_id_cinema foreign key (id_cinema) references Cinemas(id_cinema),
CONSTRAINT fk_shows_id_movie foreign key (id_movie) references Movies(id_movie)
);



create table Genres(
id_genre int,
genre varchar(50),
CONSTRAINT pk_id_genre PRIMARY KEY (id_genre)
);

create table Genre_x_Movie(
id_genre int,
id_movie int,
CONSTRAINT pk_genre_x_movie PRIMARY KEY (id_genre,id_movie),
CONSTRAINT fk_genre_x_movie_id_genre FOREIGN KEY (id_genre) references Genres(id_genre),
CONSTRAINT fk_genre_x_movie_id_movie FOREIGN KEY (id_movie) references Movies(id_movie)
);



CREATE TABLE Users(
id_user int auto_increment,
userName varchar(50) not null,
firstname varchar(50),
lastname varchar(50),
email varchar(50),
dni int,
permissions int,
password varchar(50) not null,
CONSTRAINT pk_id_user PRIMARY KEY (id_user),
CONSTRAINT unq_email UNIQUE (email)
);


create table creditcards (
id_creditcard int auto_increment,
company varchar(50),
id_user int,
constraint pk_id_creditcard primary key (id_creditcard),
CONSTRAINT fk_id_user FOREIGN KEY (id_user) references Users(id_user)
);


create table purchase(
id_purchase int auto_increment not null,
purchase_day date,
quantity_tickets int,
total float,
discount float,
id_user int,
CONSTRAINT pk_id_purchase PRIMARY KEY (id_purchase),
CONSTRAINT fk_id_user_purchase FOREIGN KEY (id_user) references Users(id_user)
);

create table Tickets (
id_ticket int auto_increment,
id_show int,
id_purchase int,
constraint id_ticket primary key (id_ticket),
CONSTRAINT fk_id_show FOREIGN KEY (id_show) references shows(id_show),
CONSTRAINT fk_id_purchase foreign key (id_purchase) references purchase (id_purchase)
);


-------------------------------------------------------------------------------
--                         STORE PROCEDURES
-------------------------------------------------------------------------------

DELIMITER //
CREATE PROCEDURE cargarMT (IN nameMT varchar(20), IN addressMT varchar(20), IN ticketPriceMT int, IN statusMT boolean)
BEGIN
insert into MovieTheaters(name, address, ticketPrice, status)
values(nameMT, addressMT, ticketPriceMT, statusMT);
END//

call cargarMT ('Cine Paseo', 'Cordoba 2555', 200, true);
call cargarMT ('Cinemacenter', 'Salta 456', 500, false);
call cargarMT ('Cine Gallegos', 'Mendoza 6589', 800, true);


DELIMITER //
CREATE PROCEDURE cargarU (IN userNameU varchar(20), IN firstnameU varchar(50), IN lastnameU varchar(50), IN emailU varchar(50), IN dniU int, IN permissionsU int, IN passwordU varchar(50))
BEGIN
insert into Users(userName, firstname, lastname, email, dni, permissions, password)
values(userNameU, firstnameU, lastnameU, emailU, dniU, permissionsU, passwordU);
END//

call cargarU ('juanludu', 'Juan', 'Luduenia', 'juan@gmail.com', 41306521, 1, '1234');
call cargarU ('bpilegi98', 'Bianca', 'Pilegi', 'bianca@gmail.com', 41307541, 2, '4321');
call cargarU('asd', 'asd', 'asd', 'asd@gmail.com', 41306988, 2, 'asd123');


