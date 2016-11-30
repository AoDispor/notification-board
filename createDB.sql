CREATE table notifications(
notificationId INTEGER PRIMARY KEY AUTOINCREMENT,
username VARCHAR,
senddate DATETIME
);

CREATE table codigoPostal{
codigoPostalId INTEGER PRIMARY KEY
}

CREATE table joinCodigoPostalNotifications{
notifID INTEGER,
codPostalId INTEGER,
PRIMARY KEY (notifID,codPostalId),
FOREIGN KEY (notifID) REFERENCES notifications(notificationId) ON DELETE CASCADE,
FOREIGN KEY (codPostalId) REFERENCES codigoPostal(codigoPostalId) ON DELETE CASCADE
}