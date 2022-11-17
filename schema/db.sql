
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

CREATE TABLE paymentCoupons(
                               id_coupon int AUTO_INCREMENT,
                               payment decimal(10,2) NOT NULL,

                               CONSTRAINT pk_paymentCoupon PRIMARY KEY (id_coupon)
);

CREATE TABLE reservations(
                             id_reservation INT AUTO_INCREMENT,
                             id_guardian INT NOT NULL,
                             id_coupon INT,
                             state BOOLEAN NOT NULL,
                             startDate date NOT NULL,
                             endDate date NOT NULL,
                             concluded BOOLEAN NOT NULL,
                             CONSTRAINT pk_reservations PRIMARY KEY (id_reservation),
                             CONSTRAINT fk_reservations_guardians FOREIGN KEY (id_guardian) REFERENCES guardians (id_guardian),
                             CONSTRAINT fk_reservations_coupon FOREIGN KEY (id_coupon) REFERENCES  paymentCoupons (id_coupon)
);

CREATE TABLE reservations_X_animals(
                                       id_reservation int NOT NULL,
                                       id_animal int NOT NULL,
                                       CONSTRAINT pk_reservations_animals PRIMARY KEY (id_reservation, id_animal),
                                       CONSTRAINT fk_reservations_animals FOREIGN KEY (id_reservation) REFERENCES reservations (id_reservation),
                                       CONSTRAINT fk_animals_reservations FOREIGN KEY (id_animal) REFERENCES animals (id_animal)
);

#=======================================================================================================================


INSERT INTO animal_sizes(id_animal_size, size) VALUES (1, 'Small');
INSERT INTO animal_sizes(id_animal_size, size) VALUES (2, 'Medium');
INSERT INTO animal_sizes(id_animal_size, size) VALUES (3, 'Big');

INSERT INTO animal_types(id_animal_type, type) VALUES (1, 'Dog');
INSERT INTO animal_types(id_animal_type, type) VALUES (2, 'Cat');

INSERT INTO animal_breeds(id_animal_breed, breed, id_animal_type) VALUES (1, 'Beagle', 1);
INSERT INTO animal_breeds(id_animal_breed, breed, id_animal_type)VALUES (2, 'Cocker', 1);
INSERT INTO animal_breeds(id_animal_breed, breed, id_animal_type)VALUES (3, 'Egyptian', 2);
INSERT INTO animal_breeds(id_animal_breed, breed, id_animal_type)VALUES (4, 'Siamese', 2);

CREATE PROCEDURE createReservation (
    pid_guardian int,
    pstate boolean,
    pstartDate date,
    pendDate date,
    pconcluded boolean,
    pid_animal int)
begin
    declare last_reservation int default 0;

insert into reservations (id_guardian, id_coupon, state, startDate, endDate, concluded) VALUES (pid_guardian, NULL, pstate, pstartDate, pendDate, pconcluded);
set last_reservation = last_insert_id();
insert into reservations_X_animals (id_reservation, id_animal) VALUES (last_reservation, pid_animal);
end;


CREATE PROCEDURE createCoupon(IN pId_reservation INTEGER, IN pPayment DECIMAL(10, 2))
BEGIN
    DECLARE id_coupon INTEGER DEFAULT 0;
INSERT INTO paymentcoupons(payment) VALUES (pPayment);
SET id_coupon = LAST_INSERT_ID();
UPDATE reservations R SET R.id_coupon = id_coupon WHERE R.id_reservation = pId_reservation;
END;

CREATE PROCEDURE finishedReservationAndDeleteACoupon(IN pId_reservation INTEGER)
BEGIN
    DECLARE vId_coupon INTEGER DEFAULT 0;
    SET vId_coupon = (SELECT R.id_coupon FROM reservations R WHERE R.id_reservation = pId_reservation);
UPDATE reservations R SET R.id_coupon = NULL WHERE R.id_reservation = pId_reservation AND R.concluded = 1;
DELETE FROM paymentcoupons PC WHERE PC.id_coupon = vId_coupon;
END;

