/*CREATE DATABASE kolcsonzo;
USE kolcsonzo;


CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(255) NOT NULL,
    dateofbirth DATE NOT NULL,
    phone VARCHAR(255) NOT NULL UNIQUE,
    hasActiveBooking BOOLEAN NOT NULL,
    registerDate DATETIME NOT NULL,
    deleteDate DATETIME,
    isDeleted BOOLEAN NOT NULL
);

CREATE TABLE onlineUser (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    userID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES user(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    oUserID INT NOT NULL,
    oUserName VARCHAR(255) NOT NULL,
    FOREIGN KEY (oUserID) REFERENCES onlineUser(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (oUserName) REFERENCES onlineUser(username)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE dealership (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    isActive BOOLEAN NOT NULL,
    city VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL
);

CREATE TABLE dealer (
    id INT PRIMARY KEY AUTO_INCREMENT,
    oUserID INT NOT NULL,
    oUserName VARCHAR(255) NOT NULL,
    dshipID INT NOT NULL,
    FOREIGN KEY (oUserID) REFERENCES onlineUser(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (oUserName) REFERENCES onlineUser(username)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (dshipID) REFERENCES dealership(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE car (
    id INT PRIMARY KEY AUTO_INCREMENT,
    isAvailable BOOLEAN NOT NULL,
    brand VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    capacity INT NOT NULL,
    fuelType VARCHAR(255) NOT NULL,
    fuelConsumption INT NOT NULL,
    description TEXT NOT NULL,
    depositAmount INT NOT NULL,
    tierIduration INT NOT NULL,
    tierIprice INT NOT NULL,
    tierIIduration INT NOT NULL,
    tierIIprice INT NOT NULL,
    tierCustomNotes TEXT NOT NULL,
    picture VARCHAR(255),
    dealerID INT NOT NULL,
    FOREIGN KEY (dealerID) REFERENCES dealer(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE booking_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(255) NOT NULL,
    datePickup DATETIME NOT NULL,
    dateReturn DATETIME NOT NULL,
    returnedOnTime BOOLEAN,
    priceEstimate INT NOT NULL,
    pricePaid INT,
    wantsCallBack BOOLEAN,
    dshipID INT NOT NULL,
    carID INT,
    oUserID INT,
    userID INT,
    FOREIGN KEY (dshipID) REFERENCES dealership(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (carID) REFERENCES car(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (oUserID) REFERENCES onlineUser(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (userID) REFERENCES user(id)
        ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE conversation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255) NOT NULL,
    isClosed BOOLEAN NOT NULL,
    isDeleted BOOLEAN NOT NULL,
    oUserID INT,
    dshipID INT,
    carID INT,
    FOREIGN KEY (oUserID) REFERENCES onlineUser(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (dshipID) REFERENCES dealership(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (carID) REFERENCES car(id)
        ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE message (
    id INT PRIMARY KEY AUTO_INCREMENT,
    text TEXT NOT NULL,
    date DATETIME NOT NULL,
    isDeleted BOOLEAN NOT NULL,
    senderID INT,
    convID INT,
    FOREIGN KEY (senderID) REFERENCES onlineUser(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (convID) REFERENCES conversation(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE review (
    id INT PRIMARY KEY AUTO_INCREMENT,
    rating INT NOT NULL,
    messageID INT NOT NULL,
    bookingID INT,
    FOREIGN KEY (messageID) REFERENCES message(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (bookingID) REFERENCES booking_data(id)
        ON DELETE SET NULL ON UPDATE CASCADE
);*/

USE kolcsonzo;
UPDATE car SET picture = 'kepek/autok/opel.jpg' WHERE picture = 'kepek/autok/opel.jfif';
UPDATE car SET picture = 'kepek/autok/volkswagen.jpg' WHERE picture = 'kepek/autok/volkswagen.jfif';