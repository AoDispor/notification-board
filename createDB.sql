drop table IF EXISTS joinPostalCodeNotifications;
/*drop table IF EXISTS postalCode;*/
drop table IF EXISTS notifications;
drop table IF EXISTS clientTokens;

CREATE table notifications(
notificationId INTEGER PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(50),
sentdate DATETIME
);

/*no need to reference with the same size as stored data
its better to just duplicate data
CREATE table postalCode(
postalCodeId INTEGER PRIMARY KEY
);*/

CREATE table joinPostalCodeNotifications(
notificationRef INTEGER,
postalCode INTEGER,
FOREIGN KEY (notificationRef) REFERENCES notifications(notificationId) ,
/*FOREIGN KEY (postalCodeRef) REFERENCES postalCode(postalCodeId) ,*/
PRIMARY KEY (notificationRef,postalCode)
);

CREATE table clientTokens(
gcmToken VARCHAR(160) PRIMARY KEY,
postalCode INTEGER
/*FOREIGN KEY (postalCodeRef) REFERENCES postalCode(postalCodeId)*/
)