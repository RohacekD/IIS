CREATE TABLE Prestavka (
ID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
cas TIME NOT NULL,
trvani TIME NOT NULL,
ID_Inscenace INTEGER
);

CREATE TABLE Rekvizita (
ID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
nazev VARCHAR(40) NOT NULL,
stav ENUM('nová', 'použitá', 'poškozená','velmi poškozená')
);

CREATE TABLE Divadelni_hra (
ID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
autor VARCHAR(60) NOT NULL,
jmeno VARCHAR(60) NOT NULL,
popis VARCHAR(500) NOT NULL,
casova_narocnost TIME NOT NULL -- zmeneno na time
);

CREATE TABLE Kontakt
(
ID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
mesto VARCHAR(40) NOT NULL,
ulice VARCHAR(40),
cp VARCHAR(10) NOT NULL,
telefon INTEGER NOT NULL,
email VARCHAR(40) NOT NULL 
);

CREATE TABLE  Reziser
(
  login VARCHAR(40) NOT NULL PRIMARY KEY, 
  jmeno VARCHAR(40) NOT NULL,
  prijmeni VARCHAR(40) NOT NULL,
  id_kontakt INTEGER NOT NULL -- fk
);

CREATE TABLE  Herec
(
  login VARCHAR(40) NOT NULL PRIMARY KEY, -- meli bychom vyresit kolize loginu
  jmeno VARCHAR(40) NOT NULL,
  prijmeni VARCHAR(40) NOT NULL,
  pohlavi ENUM('muž','žena') NOT NULL,
  id_kontakt INTEGER NOT NULL -- fk
);

CREATE TABLE Zamestnanec (
login_Herec VARCHAR(40) NOT NULL,
uvazek ENUM('plný','částečný') NOT NULL,
popis VARCHAR(500) NOT NULL
);

CREATE TABLE Externista (
login_Herec VARCHAR(40) NOT NULL,
kvalifikace VARCHAR(30) NOT NULL,
hodiny_za_mesic INTEGER NOT NULL -- nemel by to být float?
);

CREATE TABLE Role (
ID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
nazev VARCHAR(60) NOT NULL,
obtiznost enum('nízká', 'střední', 'vysoká') NOT NULL,
casova_narocnost INTEGER NOT NULL, -- in hours nebo zmenit na time? 
popis VARCHAR(500) NOT NULL,
ID_inscenace INTEGER NOT NULL
);

CREATE TABLE Inscenace (
ID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
nazev VARCHAR(50) NOT NULL,
scena ENUM('Malá','Velká') NOT NULL,
login_Reziser VARCHAR(40) NOT NULL,
ID_Divadelni_hra INTEGER NOT NULL,
pocet_roli INTEGER DEFAULT 0
);

CREATE TABLE Predstaveni (
ID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
Datum DATE NOT NULL,
ID_Inscenace INTEGER
);

CREATE TABLE Role_Rekvizita (
ID_Role INTEGER NOT NULL,
ID_Rekvizita INTEGER NOT NULL
);

CREATE TABLE Predstaveni_Herec (
ID_Predstaveni INTEGER NOT NULL,
login_Herec VARCHAR(40) NOT NULL
);

CREATE TABLE Inscenace_Herec (
ID_Inscenace INTEGER NOT NULL,
login_Herec VARCHAR(40) NOT NULL
);

CREATE TABLE Role_Herec (
ID_Role INTEGER NOT NULL,
login_Herec VARCHAR(40) NOT NULL
);

-- cizi klice spojovaci tabulky Role_Rekvizita
ALTER TABLE Role_Rekvizita ADD CONSTRAINT FK_Role_Rekvizita_ID_Role FOREIGN KEY (ID_Role) 
	REFERENCES Role(Id);

ALTER TABLE Role_Rekvizita ADD CONSTRAINT FK_Role_Rekvizita_ID_Rekvizita FOREIGN KEY (ID_Rekvizita) 
	REFERENCES Rekvizita(Id);

-- cizi klice spojovaci tabulky Role_Herec
ALTER TABLE Role_Herec ADD CONSTRAINT FK_Role_Herec_ID_Role FOREIGN KEY (ID_Role) 
   REFERENCES Role(Id);
ALTER TABLE Role_Herec ADD CONSTRAINT FK_Role_Herec_login_Herec FOREIGN KEY (login_Herec) 
   REFERENCES Herec(Login);
-- cizi klice spojovaci tabulky Inscenace_Herec
ALTER TABLE Inscenace_Herec ADD CONSTRAINT FK_Insc_Herec_ID_Inscenace FOREIGN KEY (ID_Inscenace) 
   REFERENCES Inscenace(Id);
ALTER TABLE Inscenace_Herec ADD CONSTRAINT FK_Insc_Herec_login_Herec FOREIGN KEY (login_Herec) 
   REFERENCES Herec(Login);
   
-- cizi klice spojovaci tabulky Predstaveni_Herec
ALTER TABLE Predstaveni_Herec ADD CONSTRAINT FK_Predst_H_ID_Predstaveni FOREIGN KEY (ID_Predstaveni) 
   REFERENCES Predstaveni(Id);
ALTER TABLE Predstaveni_Herec ADD CONSTRAINT FK_Predst_H_login_Herec FOREIGN KEY (login_Herec) 
   REFERENCES Herec(Login);
   

-- cizi klice tabulky Role
ALTER TABLE Role ADD CONSTRAINT FK_Role_ID_Inscenace FOREIGN KEY (ID_Inscenace) 
   REFERENCES Inscenace(Id);
   
-- cizi klice tabulky Inscenace
ALTER TABLE Inscenace ADD CONSTRAINT FK_Inscenace_ID_Divadelni_hra FOREIGN KEY (ID_Divadelni_hra) 
   REFERENCES Divadelni_hra(Id);
ALTER TABLE Inscenace ADD CONSTRAINT FK_Inscenace_login_Reziser FOREIGN KEY (login_Reziser) 
   REFERENCES Reziser(Login);
   
-- cizi klice tabulky Predstaveni
ALTER TABLE Predstaveni ADD CONSTRAINT FK_Preds_ID_Divadelni_hra FOREIGN KEY (ID_Inscenace) 
   REFERENCES Inscenace(Id);
   
-- cizi klice tabulky Herec
ALTER TABLE Herec ADD CONSTRAINT FK_Herec_id_kontakt FOREIGN KEY (id_kontakt) 
   REFERENCES Kontakt(Id) ON DELETE CASCADE;
   
-- cizi klice tabulky Reziser
ALTER TABLE Reziser ADD CONSTRAINT FK_Reziser_id_kontakt FOREIGN KEY (id_kontakt) 
   REFERENCES Kontakt(Id) ON DELETE CASCADE;
   
-- Generalizace Herec
ALTER TABLE Zamestnanec ADD CONSTRAINT FK_Zamestnanec_login_Herec FOREIGN KEY (login_Herec) 
   REFERENCES Herec(login);
ALTER TABLE Externista ADD CONSTRAINT FK_Externista_login_Herec FOREIGN KEY (login_Herec) 
   REFERENCES Herec(login);


-- cizi klice tabulky Prestavka
ALTER TABLE Prestavka ADD CONSTRAINT FK_Prestavka_ID_Inscenace FOREIGN KEY (ID_Inscenace) 
   REFERENCES Inscenace(Id);
   
-- naplnění daty
  INSERT INTO Kontakt VALUES(NULL, 'Dačice', 'Dlouhá', '458/V', 728947279,'daliborjelinek01@gmail.com');
  SELECT LAST_INSERT_ID() INTO @var;
  INSERT INTO Reziser VALUES('xjelin42', 'Dalibor', 'Jelínek', @var);

   INSERT INTO Kontakt VALUES(NULL, 'Třešť', 'Krátká', '455/V', 728587875,'rohacekd@gmail.com');
  SELECT LAST_INSERT_ID() INTO @var;
  INSERT INTO Reziser VALUES('xrohac01', 'Dominik', 'Roháček', @var);
  
  INSERT INTO Kontakt VALUES(NULL, 'Dolni Cerekev', NULL, '455/X', 258587875,'pavlu@gmail.com');
  SELECT LAST_INSERT_ID() INTO @var;
  INSERT INTO Herec VALUES('xpavlu01', 'Jan', 'Pavlů', 'muž', @var);
  
  INSERT INTO Zamestnanec(login_Herec, uvazek, popis)
  VALUES('xpavlu01', 'plný', 'absolvent DAMU');
  
  INSERT INTO Kontakt VALUES(NULL, 'Dolní Cerekev', '-', '5', 258587875,'homa@gmail.com');
  SELECT LAST_INSERT_ID() INTO @var;
  INSERT INTO Herec VALUES('xhomo01', 'Patrik', 'Homa', 'žena', @var);
  
  INSERT INTO Externista(login_Herec, kvalifikace, hodiny_za_mesic)
  VALUES('xhomo01', 'Národní umělec', 50);
  
  INSERT INTO Kontakt VALUES(NULL, 'Vídeó', '-', '465/X', 258587875,'Haas@gmail.com');
  SELECT LAST_INSERT_ID() INTO @var;
  INSERT INTO Herec VALUES('xHaasH01', 'Hugo', 'Haas', 'muž', @var);
  
  INSERT INTO Zamestnanec(login_Herec, uvazek, popis)
  VALUES('xHaasH01', 'plný', 'světoznámý umělec');
  
  INSERT INTO Kontakt VALUES(NULL, 'Praha', '-', '465/X', 258587875,'Rydl@gmail.com');
  SELECT LAST_INSERT_ID() INTO @var;
  INSERT INTO Herec VALUES('xRydlA01', 'Antonín', 'Rýdl', 'muž', @var);
  
  INSERT INTO Zamestnanec(login_Herec, uvazek, popis)
  VALUES('xRydlA01', 'plný', 'Ve 13 vystudoval konzervatoř.');
  
 -- romeo a julie -------------------------------------------------
 
  INSERT INTO Divadelni_hra(autor, jmeno, popis, casova_narocnost)
VALUES('William Shakespeare', 'Romeo a Jůlie', 'Tragédie', 200);
SELECT LAST_INSERT_ID() INTO @DH_ID;


INSERT INTO Inscenace(nazev, scena, login_Reziser, ID_Divadelni_hra)
VALUES('Romeo a Jůlie - moderní','Malá', 'xrohac01', @DH_ID);
SELECT LAST_INSERT_ID() INTO @I_ID;

INSERT INTO Inscenace_Herec VALUES(@I_ID,'xhomo01');
INSERT INTO Inscenace_Herec VALUES(@I_ID,'xpavlu01');

INSERT INTO Prestavka VALUES(NULL, '0 0:30:00.0', '0 0:10:00.0', @I_ID);
INSERT INTO Prestavka VALUES(NULL, '0 1:00:00.0', '0 0:10:00.0', @I_ID);
INSERT INTO Prestavka VALUES(NULL, '0 1:30:00.0', '0 0:10:00.0', @I_ID);

INSERT INTO Role(nazev, obtiznost, casova_narocnost, popis, ID_inscenace)
VALUES('Romeo', 'vysoká', 100, 'Mladík zamilován.', @I_ID);
SELECT LAST_INSERT_ID() INTO @ROLE_ID;
INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xpavlu01');

INSERT INTO Rekvizita(nazev, stav) VALUES('meč', 'použitá');
SELECT LAST_INSERT_ID() INTO @REK_ID;

INSERT INTO Role_Rekvizita (ID_Role, ID_Rekvizita)
VALUES(@ROLE_ID, @REK_ID);

INSERT INTO Role(nazev, obtiznost, casova_narocnost, popis, ID_inscenace)
VALUES('Jůlie', 'vysoká', 100, 'Mladice zamilována.', @I_ID);
SELECT LAST_INSERT_ID() INTO @ROLE_ID;

INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xhomo01');

INSERT INTO Rekvizita(nazev, stav) VALUES('šaty', 'použitá');
SELECT LAST_INSERT_ID() INTO @REK_ID;

INSERT INTO Role_Rekvizita (ID_Role, ID_Rekvizita)
VALUES(@ROLE_ID, @REK_ID);

INSERT INTO Rekvizita(nazev, stav) VALUES('Jed', 'nová');
SELECT LAST_INSERT_ID() INTO @REK_ID;

INSERT INTO Role_Rekvizita (ID_Role, ID_Rekvizita)
VALUES(@ROLE_ID, @REK_ID);

INSERT INTO Predstaveni VALUES(NULL, '03/21/2016 19:00:00', @I_ID);
  SELECT LAST_INSERT_ID() INTO @P_ID;
  
INSERT INTO Predstaveni_Herec VALUES(@P_ID, 'xhomo01');
INSERT INTO Predstaveni_Herec VALUES(@P_ID, 'xpavlu01');  

INSERT INTO Predstaveni VALUES(NULL, '03/21/2016 20:00:00', @I_ID);
  SELECT LAST_INSERT_ID() INTO @P_ID;
  
INSERT INTO Predstaveni_Herec VALUES(@P_ID, 'xhomo01');
INSERT INTO Predstaveni_Herec VALUES(@P_ID, 'xpavlu01');  

-- othelooo ---------------------------------------------

INSERT INTO Divadelni_hra(autor, jmeno, popis, casova_narocnost)
VALUES('William Shakespeare', 'Othello', 'Tragédie', 200);
SELECT LAST_INSERT_ID() INTO @DH_ID;
INSERT INTO Inscenace(nazev, scena, login_Reziser, ID_Divadelni_hra)
VALUES('Othelliada','Velká', 'xjelin42', @DH_ID);
SELECT LAST_INSERT_ID() INTO @I_ID;

INSERT INTO Role(nazev, obtiznost, casova_narocnost, popis, ID_inscenace)
VALUES('Desdemona', 'vysoká', 200, 'Othellova žena, věrná, čestná', @I_ID);
SELECT LAST_INSERT_ID() INTO @ROLE_ID;
INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xhomo01');

INSERT INTO Role(nazev, obtiznost, casova_narocnost, popis, ID_inscenace)
VALUES('Othello', 'vysoká', 100, 'Maur ve službách Benátek', @I_ID);
SELECT LAST_INSERT_ID() INTO @ROLE_ID;
INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xhomo01'); -- Homa hraje dvojroli


INSERT INTO Inscenace_Herec VALUES(@I_ID,'xhomo01');
INSERT INTO Inscenace_Herec VALUES(@I_ID,'xhomo01');

INSERT INTO Prestavka VALUES(NULL, '0 0:30:00.0', '0 0:10:00.0', @I_ID);
INSERT INTO Prestavka VALUES(NULL, '0 1:00:00.0', '0 0:10:00.0', @I_ID);
INSERT INTO Prestavka VALUES(NULL, '0 1:30:00.0', '0 0:10:00.0', @I_ID);

-- hamlet -------------------------------------------------------

INSERT INTO Divadelni_hra(autor, jmeno, popis, casova_narocnost)
VALUES('William Shakespeare', 'Hamlet', 'Tragédie', 200);
SELECT LAST_INSERT_ID() INTO @DH_ID;

INSERT INTO Inscenace(nazev, scena, login_Reziser, ID_Divadelni_hra)
VALUES('Hamlet pro velkou scénu','Velká', 'xrohac01', @DH_ID);
SELECT LAST_INSERT_ID() INTO @I_ID;

INSERT INTO Inscenace_Herec VALUES(@I_ID,'xRydlA01');
INSERT INTO Inscenace_Herec VALUES(@I_ID,'xHaasH01');


INSERT INTO Prestavka VALUES(NULL, '0 0:30:00.0', '0 0:15:00.0', @I_ID);



INSERT INTO Role(nazev, obtiznost, casova_narocnost, popis, ID_inscenace)
VALUES('Hamlet', 'nízká', 100, 'dánský princ', @I_ID);
SELECT LAST_INSERT_ID() INTO @ROLE_ID;
INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xHaasH01');

INSERT INTO Rekvizita(nazev, stav) VALUES('meč', 'použitá');
SELECT LAST_INSERT_ID() INTO @REK_ID;

INSERT INTO Role_Rekvizita (ID_Role, ID_Rekvizita)
VALUES(@ROLE_ID, @REK_ID);

INSERT INTO Role(nazev, obtiznost, casova_narocnost, popis, ID_inscenace)
VALUES('Claudius', 'nízká', 100, 'dánský král', @I_ID);
SELECT LAST_INSERT_ID() INTO @ROLE_ID;
INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xRydlA01');
INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xpavlu01'); -- tuto roli umí i honzík

INSERT INTO Predstaveni VALUES(NULL, '04/21/2016 19:00:00', @I_ID);
  SELECT LAST_INSERT_ID() INTO @P_ID;
  
INSERT INTO Predstaveni_Herec VALUES(@P_ID, 'xHaasH01'); 
INSERT INTO Predstaveni_Herec VALUES(@P_ID, 'xRydlA01'); 

INSERT INTO Predstaveni VALUES(NULL, '04/22/2016 20:00:00', @I_ID);
 SELECT LAST_INSERT_ID() INTO @P_ID;
  
INSERT INTO Predstaveni_Herec VALUES(@P_ID, 'xHaasH01');
INSERT INTO Predstaveni_Herec VALUES(@P_ID, 'xRydlA01'); 
-- Hamlet KONEC

-- Macbeth
INSERT INTO Divadelni_hra(autor, jmeno, popis, casova_narocnost)
VALUES('William Shakespeare', 'Macbeth', 'Tragédie', 200);
SELECT LAST_INSERT_ID() INTO @DH_ID;
INSERT INTO Inscenace(nazev, scena, login_Reziser, ID_Divadelni_hra)
VALUES('Macbeth - klasicky', 'Malá', 'xjelin42', @DH_ID);
SELECT LAST_INSERT_ID() INTO @I_ID;
INSERT INTO Inscenace_Herec VALUES(@I_ID,'xRydlA01');
INSERT INTO Inscenace_Herec VALUES(@I_ID,'xpavlu01');


INSERT INTO Role(nazev, obtiznost, casova_narocnost, popis, ID_inscenace)
VALUES('Ducan', 'střední', 150, 'skotský král', @I_ID);
SELECT LAST_INSERT_ID() INTO @ROLE_ID;
INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xHaasH01');

INSERT INTO Role(nazev, obtiznost, casova_narocnost, popis, ID_inscenace)
VALUES('Macbeth', 'střední', 150, ' generál v armádě krále Duncana', @I_ID);
SELECT LAST_INSERT_ID() INTO @ROLE_ID;
INSERT INTO Role_Herec VALUES(@ROLE_ID, 'xpavlu01');

INSERT INTO Prestavka VALUES(NULL, '0 1:00:00.0', '0 0:10:00.0', @I_ID);

-- Macbeth KONEC

-- Divadelni hry bez inscenací
INSERT INTO Divadelni_hra(autor, jmeno, popis, casova_narocnost)
VALUES('Victor Hugo', 'Marie Tudorovna', 'Drama o královně Anglie', 150);

INSERT INTO Divadelni_hra(autor, jmeno, popis, casova_narocnost)
VALUES('Victor Hugo', 'Cromwell', 'Předmluva k tomuto dílu se stala manifestem romantického dramatu', 100);

INSERT INTO Divadelni_hra(autor, jmeno, popis, casova_narocnost)
VALUES('Václav Havel', 'Prase', 'V??CLAV HAVEL''S HUNT FOR A PIG', 90);

  
  
  
  
  
  
