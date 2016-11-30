drop table IF EXISTS joinPostalCodeNotifications;
drop table IF EXISTS postalCode;
drop table IF EXISTS notifications;


CREATE table notifications(
notificationId INTEGER PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(50),
sentdate DATETIME
);

CREATE table postalCode(
postalCodeId INTEGER PRIMARY KEY
);

CREATE table joinPostalCodeNotifications(
notificationRef INTEGER,
postalCodeRef INTEGER,
FOREIGN KEY (notificationRef) REFERENCES notifications(notificationId) ,
FOREIGN KEY (postalCodeRef) REFERENCES postalCode(postalCodeId) ,
PRIMARY KEY (notificationRef,postalCodeRef)
);