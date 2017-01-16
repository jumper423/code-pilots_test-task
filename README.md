# code-pilots_test-task
Реализовать простой протокол JSON-API для мобильного приложения.

```
CREATE TABLE `AccessTable` (
`Name`  varchar(64) NOT NULL ,
PRIMARY KEY (`Name`)
);

INSERT INTO `AccessTable` (`Name`) VALUES ('News');
INSERT INTO `AccessTable` (`Name`) VALUES ('Session');

CREATE TABLE `SessionSpeaker` (
`SessionID`  integer NOT NULL ,
`SpeakerID`  integer NOT NULL ,
PRIMARY KEY (`SessionID`, `SpeakerID`)
);

INSERT INTO `test_task`.`SessionSpeaker` (`SessionID`, `SpeakerID`) VALUES ('1', '1');
INSERT INTO `test_task`.`Session` (`ID`, `Name`, `TimeOfEvent`, `Description`) VALUES ('1', 'Annual report', '2017-01-05 02:55:13', 'Anuual report by CEO');

ALTER TABLE `Session`
ADD COLUMN `NumberOfSeats`  integer NOT NULL DEFAULT 0 AFTER `Description`;

CREATE TABLE `Users` (
`ID`  int NOT NULL AUTO_INCREMENT ,
`Email`  varchar(255) NOT NULL ,
PRIMARY KEY (`ID`)
);

INSERT INTO `Users` (`ID`, `Email`) VALUES ('1', 'test@test.ru');

UPDATE `Session`
SET `NumberOfSeats`='5'
WHERE (`ID`='1');

CREATE TABLE `SessionSubscribe` (
`SessionID`  integer NOT NULL ,
`UserID`  integer NOT NULL ,
PRIMARY KEY (`SessionID`, `UserID`)
);

INSERT INTO `SessionSubscribe` (`SessionID`, `UserID`) VALUES ('1', '1');

ALTER TABLE News
ADD UNIQUE INDEX NewsUnique (ParticipantId, NewsTitle, NewsMessage) USING BTREE ;
```