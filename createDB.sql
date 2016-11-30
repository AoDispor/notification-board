drop table IF EXISTS notifications;
CREATE table notifications(
notificationId INTEGER PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(50),
sentdate DATETIME
);


drop table IF EXISTS codigoPostal;
CREATE table codigoPostal(
codigoPostalId INTEGER PRIMARY KEY
);

drop table IF EXISTS joinCodigoPostalNotifications;
CREATE table joinCodigoPostalNotifications(
notifID INTEGER,
codPostalId INTEGER,
FOREIGN KEY (notifID) REFERENCES notifications(notificationId) ON DELETE CASCADE,
FOREIGN KEY (codPostalId) REFERENCES codigoPostal(codigoPostalId) ON DELETE CASCADE,
PRIMARY KEY (notifID,codPostalId)
);