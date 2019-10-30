create database MoviePass;
use MoviePass;

CREATE TABLE users(
id_user int auto_increment,
fisrtname varchar(50),
lastname varchar(50),
email varchar(50),
pass varchar(50) not null,
userName varchar(50) not null,
CONSTRAINT pk_id_user PRIMARY KEY (id_user),
CONSTRAINT unq_email UNIQUE (email)
);

create table cinemas(
id_cinema int auto_increment,
name varchar(20),
address varchar(20),
seats int not null,
ticketPrice int not null,
constraint pk_id_cinema primary key (id_cinema),
constraint unq_name UNIQUE (name)
);

create table movies(
id_movie int,
title varchar(20),
constraint pk_id_movie primary key (id_movie)
);

create table genre(
id_genre int,
genre varchar(50),
CONSTRAINT pk_id_genre PRIMARY KEY (id_genre)
);

create table genre_x_movie(
id_genre int,
id_movie int,
CONSTRAINT pk_genre_x_movie PRIMARY KEY (id_genre,id_movie),
CONSTRAINT fk_genre_x_movie_id_genre FOREIGN KEY (id_genre) references Genre(id_genre),
CONSTRAINT fk_genre_x_movie_id_movie FOREIGN KEY (id_movie) references Movies(id_movie)
);

create table shows(
id_show int auto_increment,
show_date date,
id_cinema int,
id_movie int,
constraint pks_shows primary key (id_show),
constraint fk_shows_id_cinema foreign key (id_cinema) references Cinemas(id_cinema),
constraint fk_shows_id_movie foreign key (id_movie) references Movies(id_movie)
);

create table purchase(
id_purchase int auto_increment not null,
purchase_day date,
q_tickets int,
total float,
discount float,
dni int,
CONSTRAINT pk_id_purchase PRIMARY KEY (id_purchase),
CONSTRAINT fk_dni FOREIGN KEY (dni) references users(dni)
);

create table tickets(
id_ticket int auto_increment,
ticket_number varchar(3),
qr_code blob,
id_show int,
id_purchase int,
constraint fk_id_purchase foreign key (id_purchase) references purchase (id_purchase),
constraint pk_id_ticket primary key (id_ticket),
constraint fk_id_show foreign key (id_show) references Shows(id_show)
);

