CREATE DATABASE petHero;
USE petHero;

CREATE TABLE users(
                      id_user int AUTO_INCREMENT,
                      firstName varchar(50) NOT NULL,
                      lastName varchar(50) NOT NULL,
                      username varchar(50) NOT NULL,
                      password varchar(50) NOT NULL,
                      email varchar(50) NOT NULL,
                      CONSTRAINT pk_users PRIMARY KEY (id_user),
                      CONSTRAINT unq_username_email UNIQUE (username, email)
);

CREATE TABLE owners(
                       id_owner int AUTO_INCREMENT,
                       id_user int NOT NULL,
                       CONSTRAINT pk_owners PRIMARY KEY (id_owner),
                       CONSTRAINT fk_owners_users FOREIGN KEY (id_user) REFERENCES users (id_user)
);

CREATE TABLE animal_sizes(
                             id_animal_size int,
                             size varchar(30),
                             CONSTRAINT pk_animal_size PRIMARY KEY (id_animal_size)
);

CREATE TABLE guardians(
                          id_guardian int AUTO_INCREMENT,
                          salaryExpected decimal(10,2) NOT NULL,
                          reputation decimal(10,2),
                          startDate date,
                          endDate date,
                          id_animal_size_expected int NOT NULL,
                          id_user int NOT NULL,
                          CONSTRAINT pk_guardians PRIMARY KEY (id_guardian),
                          CONSTRAINT fk_guardians_users FOREIGN KEY (id_user) REFERENCES users (id_user),
                          CONSTRAINT fk_guardians_animal_sizes FOREIGN KEY (id_animal_size_expected) REFERENCES animal_sizes (id_animal_size)
);

CREATE TABLE reviewServices(
                               comment varchar(100),
                               stars int NOT NULL,
                               id_owner int NOT NULL,
                               id_guardian int NOT NULL,
                               CONSTRAINT pk_review_owner_guardian PRIMARY KEY (id_owner,id_guardian),
                               CONSTRAINT fk_review_owner FOREIGN KEY (id_owner) REFERENCES owners (id_owner),
                               CONSTRAINT fk_review_guardian FOREIGN KEY (id_guardian) REFERENCES guardians (id_guardian)
);

CREATE TABLE animal_types(
                             id_animal_type int,
                             type varchar(30) NOT NULL,
                             CONSTRAINT pk_animal_type PRIMARY KEY (id_animal_type)
);

CREATE TABLE animal_breeds(
                              id_animal_breed int,
                              breed varchar(50) NOT NULL,
                              id_animal_type int NOT NULL,
                              CONSTRAINT pk_animal_breed PRIMARY KEY (id_animal_breed),
                              CONSTRAINT fk_breed_type FOREIGN KEY (id_animal_type) REFERENCES animal_types (id_animal_type)
);

CREATE TABLE animals(
                        id_animal int AUTO_INCREMENT,
                        name varchar(50) NOT NULL,
                        age int NOT NULL,
                        photo longtext NOT NULL,
                        vaccinationPlan longtext NOT NULL,
                        video longtext NOT NULL,
                        observations varchar(150) NOT NULL,
                        id_animal_size int NOT NULL,
                        id_animal_breed int  NOT NULL,
                        id_owner int NOT NULL,
                        CONSTRAINT pk_animals PRIMARY KEY (id_animal),
                        CONSTRAINT fk_animals_animal_breeds FOREIGN KEY (id_animal_breed) REFERENCES animal_breeds (id_animal_breed),
                        CONSTRAINT fk_animals_owner FOREIGN KEY (id_owner) REFERENCES owners(id_owner),
                        CONSTRAINT fk_animals_animal_sizes FOREIGN KEY (id_animal_size) REFERENCES animal_sizes (id_animal_size)
);

CREATE TABLE reservations(
                             id_reservation INT AUTO_INCREMENT,
                             id_guardian INT NOT NULL,
                             state BOOLEAN NOT NULL,
                             startDate date NOT NULL,
                             endDate date NOT NULL,
                             concluded BOOLEAN NOT NULL,
                             CONSTRAINT pk_reservations PRIMARY KEY (id_reservation),
                             CONSTRAINT fk_reservations_guardians FOREIGN KEY (id_guardian) REFERENCES guardians (id_guardian)
);

CREATE TABLE paymentCoupons(
                               id_coupon int AUTO_INCREMENT,
                               id_reservation int,
                               payment decimal(10,2) NOT NULL,
                               CONSTRAINT pk_paymentCoupon PRIMARY KEY (id_coupon),
                               CONSTRAINT fk_paymentCoupon_reservations FOREIGN KEY (id_reservation) REFERENCES reservations(id_reservation)
);

CREATE TABLE reservations_X_animals(
                                       id_reservation int NOT NULL,
                                       id_animal int NOT NULL,
                                       CONSTRAINT pk_reservations_animals PRIMARY KEY (id_reservation, id_animal),
                                       CONSTRAINT fk_reservations_animals FOREIGN KEY (id_reservation) REFERENCES reservations (id_reservation),
                                       CONSTRAINT fk_animals_reservations FOREIGN KEY (id_animal) REFERENCES animals (id_animal)
);

#=======================================================================================================================
INSERT INTO users(firstName, lastName, username, password, email) VALUES('Ezequiel', 'Morales', 'eze', '123', 'ezemorales@gmail.com');
INSERT INTO users(firstName, lastName, username, password, email) VALUES('Lucas', 'Gaitan', 'lucas', '321', 'lucasgatian@gmail.com');
INSERT INTO users(firstName, lastName, username, password, email) VALUES('Santiago', 'Dadan', 'santi', '1234', 'santiagodadan@gmail.com');

INSERT INTO animal_sizes(id_animal_size, size) VALUES (1, 'Small');
INSERT INTO animal_sizes(id_animal_size, size) VALUES (2, 'Medium');
INSERT INTO animal_sizes(id_animal_size, size) VALUES (3, 'Big');