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

```