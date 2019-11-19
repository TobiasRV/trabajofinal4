create database MoviePass;
use MoviePass;



-------------------------------------------------------------------------------
--                               TABLES
-------------------------------------------------------------------------------

create table MovieTheaters(
id_movietheater int auto_increment,
name varchar(20),
address varchar(20),
status boolean,
CONSTRAINT pk_id_movietheater primary key (id_movietheater),
CONSTRAINT unq_name UNIQUE (name)
);

create table Cinemas(
id_cinema int auto_increment,
status boolean,
name varchar(50),
ticketPrice int not null,
seats int not null,
id_movietheater int,
CONSTRAINT pk_id_cinema primary key (id_cinema),
constraint fk_id_movietheater foreign key(id_movietheater) references MovieTheaters (id_movietheater)
);

create table Movies(
id_movie int UNIQUE,
title varchar(50),
originalTitle varchar(50),
adult boolean,
posterPath varchar(100),
releaseDate date,
backdropPath varchar(100),
overview varchar(2000),
CONSTRAINT pk_id_movie primary key (id_movie)
);

create table movietheater_x_movie(
id_movietheater int,
id_movie int,
CONSTRAINT pk_genre_x_moviemovietheater_x_movie PRIMARY KEY (id_movietheater,id_movie),
CONSTRAINT fk_movietheater_x_movie_id_movietheater FOREIGN KEY (id_movietheater) references movietheaters(id_movietheater),
CONSTRAINT fk_movietheater_x_movie_id_movie FOREIGN KEY (id_movie) references Movies(id_movie)
);

create table shows(
id_show int auto_increment,
show_date date,
show_time time,
seats int,
status boolean,
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
id_user int auto_increment not null,
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
number bigint,
id_user int,
constraint pk_id_creditcard primary key (id_creditcard),
CONSTRAINT fk_id_user FOREIGN KEY (id_user) references Users(id_user)
);


create table purchases(
id_purchase int auto_increment not null,
purchase_day date,
quantity_tickets int,
total float,
discount float,
id_show int,
id_creditcard int,
CONSTRAINT pk_id_purchase PRIMARY KEY (id_purchase),
CONSTRAINT fk_id_creditcard_purchases FOREIGN KEY (id_creditcard) references creditcards(id_creditcard),
CONSTRAINT fk_id_show_purchases FOREIGN KEY (id_show) references Shows(id_show)

);

create table Tickets (
id_ticket int auto_increment,
id_purchase int,
constraint id_ticket primary key (id_ticket),
CONSTRAINT fk_id_purchases foreign key (id_purchase) references purchases (id_purchase)
);






-------------------------------------------------------------------------------
--                         STORE PROCEDURES
-------------------------------------------------------------------------------

DELIMITER //
CREATE PROCEDURE cargarU (IN userNameU varchar(20), IN firstnameU varchar(50), IN lastnameU varchar(50), IN emailU varchar(50), IN dniU int, IN permissionsU int, IN passwordU varchar(50))
BEGIN
insert into Users(userName, firstname, lastname, email, dni, permissions, password)
values(userNameU, firstnameU, lastnameU, emailU, dniU, permissionsU, passwordU);
END//

DELIMITER //
CREATE PROCEDURE listarMovieTheaters ()
BEGIN
select * from MovieTheaters;
END//

DELIMITER //
CREATE PROCEDURE listarCinemas (IN id_movietheater int)
BEGIN
select c.name
from MovieTheaters mt
left join Cinemas c 
on mt.id_movietheater=c.id_movietheater;
END//

DELIMITER //
CREATE PROCEDURE listarShows (IN id_cinema int)
BEGIN
select s.show_date, s.show_time, s.id_movie
from Shows s 
join Cinemas c
on s.id_cinema=c.id_cinema;
END//


-------------------------------------------------------------------------------
--                             INSERTS
-------------------------------------------------------------------------------


call cargarU ('juanludu', 'Juan', 'Luduenia', 'juan@gmail.com', 41306521, 1, '1234');
call cargarU ('bpilegi98', 'Bianca', 'Pilegi', 'bianca@gmail.com', 41307541, 2, '4321');
call cargarU('asd', 'asd', 'asd', 'asd@gmail.com', 41306988, 2, 'asd123');
 
insert into creditcards (company, number, id_user) values ("Visa", 456879215 , 2);
insert into creditcards (company, number, id_user) values ("Master", 456879218 , 2);
insert into creditcards (company, number, id_user) values ("Visa", 456879888 , 2);




-------------------------------------------------------------------------------
--                            FUNCIONES RANDOMS
-------------------------------------------------------------------------------



#print bonito de shows
select mt.name, c.name,c.ticketprice,c.id_cinema, s.id_show, s.seats, m.title
from shows s
join cinemas c
on c.id_cinema = s.id_cinema
join movietheaters mt
on c.id_movietheater = mt.id_movietheater
join movies m
on m.id_movie=s.id_movie

#devuelve el ultimo id de MT
select mt.id_movietheater 
from movietheaters mt
order by mt.id_movietheater desc
limit 1;

#devuelve una lista de ids de peliculas de "x" cine
select y.id_movie
from movietheater_x_movie y
join movietheaters mt
on y.id_movietheater = mt.id_movietheater
where y.id_movietheater = "x"
;

select c.id_cinema
from cinemas c
join movietheaters mt
on c.id_movietheater = mt.id_movietheater
where c.id_movietheater = "x"
;



delete
from cinemas
where id_movietheater < 500;


delete
from movietheater_x_movie 
where id_movietheater < 500;

delete
from movietheaters 
where id_movietheater < 500;

SELECT y.id_movie
FROM movietheater_x_movie y
JOIN movietheaters mt
ON y.id_movietheater = mt.id_movietheater
WHERE y.id_movietheater = 1;

UPDATE movietheaters 
SET 
        name = IFNULL(null, name),
        address = IFNULL("valor", address),
        status = IFNULL(status, status)
WHERE 
     id_movietheater = 1;
     