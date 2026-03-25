-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 14, 2023 alle 15:26
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `tabassenze`
--

CREATE TABLE `tabassenze` (
  `idAssenza` int(10) UNSIGNED NOT NULL,
  `idStudente` int(10) UNSIGNED NOT NULL,
  `idRegistro` int(10) UNSIGNED NOT NULL,
  `numOreAssenza` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tabattivitaprogrammate`
--

CREATE TABLE `tabattivitaprogrammate` (
  `IdAtt` int(10) UNSIGNED NOT NULL,
  `attivitaPrevista` varchar(255) DEFAULT NULL,
  `ore` int(11) DEFAULT NULL,
  `stato` varchar(255) DEFAULT NULL,
  `idClasse` int(10) UNSIGNED NOT NULL,
  `idDisciplina` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tabclassi`
--

CREATE TABLE `tabclassi` (
  `idClasse` int(10) UNSIGNED NOT NULL,
  `anno` smallint(6) DEFAULT NULL,
  `sezione` varchar(255) DEFAULT NULL,
  `idIndirizzo` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tabdiscipline`
--

CREATE TABLE `tabdiscipline` (
  `idDisciplina` int(10) UNSIGNED NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `idUtente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tabindirizzi`
--

CREATE TABLE `tabindirizzi` (
  `idIndirizzo` int(10) UNSIGNED NOT NULL,
  `nomeIndirizzo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tabinsegnamenti`
--

CREATE TABLE `tabinsegnamenti` (
  `idInsegnamento` int(10) UNSIGNED NOT NULL,
  `idClasse` int(10) UNSIGNED NOT NULL,
  `idUtente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tabregistroattivita`
--

CREATE TABLE `tabregistroattivita` (
  `idRegistro` int(10) UNSIGNED NOT NULL,
  `dataAttivita` date DEFAULT NULL,
  `numOre` int(11) DEFAULT NULL,
  `materialiDistribuiti` varchar(255) DEFAULT NULL,
  `idDisciplina` int(10) UNSIGNED NOT NULL,
  `idUtente` int(10) UNSIGNED NOT NULL,
  `idAtt` int(10) UNSIGNED NOT NULL,
  `idClasse` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tabstudenti`
--

CREATE TABLE `tabstudenti` (
  `idStudente` int(10) UNSIGNED NOT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `dataNascita` date DEFAULT NULL,
  `luogoNascita` varchar(255) DEFAULT NULL,
  `idClasse` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tabutenti`
--

CREATE TABLE `tabutenti` (
  `idUtente` int(10) UNSIGNED NOT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ruolo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tabutenti`
--

INSERT INTO `tabutenti` (`idUtente`, `cognome`, `nome`, `email`, `password`, `ruolo`) VALUES
(1, 'docente', 'docente', 'docente@gmail.com', 'docente', 'docente'),
(2, 'tutor', 'tutor', 'tutor@gmail.com', 'tutor', 'tutor'),
(3, 'esperto', 'esperto', 'esperto@gmail.com', 'esperto', 'esperto');

-- --------------------------------------------------------

--
-- Struttura della tabella `tabvalutazioni`
--

CREATE TABLE `tabvalutazioni` (
  `idVoto` int(10) UNSIGNED NOT NULL,
  `voto` smallint(6) DEFAULT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `idStudente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `tabassenze`
--
ALTER TABLE `tabassenze`
  ADD PRIMARY KEY (`idAssenza`),
  ADD KEY `idStudente` (`idStudente`),
  ADD KEY `idRegistro` (`idRegistro`);

--
-- Indici per le tabelle `tabattivitaprogrammate`
--
ALTER TABLE `tabattivitaprogrammate`
  ADD PRIMARY KEY (`IdAtt`),
  ADD KEY `idClasse` (`idClasse`),
  ADD KEY `idDisciplina` (`idDisciplina`);

--
-- Indici per le tabelle `tabclassi`
--
ALTER TABLE `tabclassi`
  ADD PRIMARY KEY (`idClasse`),
  ADD KEY `idIndirizzo` (`idIndirizzo`);

--
-- Indici per le tabelle `tabdiscipline`
--
ALTER TABLE `tabdiscipline`
  ADD PRIMARY KEY (`idDisciplina`),
  ADD KEY `idUtente` (`idUtente`);

--
-- Indici per le tabelle `tabindirizzi`
--
ALTER TABLE `tabindirizzi`
  ADD PRIMARY KEY (`idIndirizzo`);

--
-- Indici per le tabelle `tabinsegnamenti`
--
ALTER TABLE `tabinsegnamenti`
  ADD PRIMARY KEY (`idInsegnamento`),
  ADD KEY `idClasse` (`idClasse`),
  ADD KEY `idUtente` (`idUtente`);

--
-- Indici per le tabelle `tabregistroattivita`
--
ALTER TABLE `tabregistroattivita`
  ADD PRIMARY KEY (`idRegistro`),
  ADD KEY `idClasse` (`idClasse`),
  ADD KEY `idUtente` (`idUtente`),
  ADD KEY `idDisciplina` (`idDisciplina`),
  ADD KEY `idAtt` (`idAtt`);

--
-- Indici per le tabelle `tabstudenti`
--
ALTER TABLE `tabstudenti`
  ADD PRIMARY KEY (`idStudente`),
  ADD KEY `idClasse` (`idClasse`);

--
-- Indici per le tabelle `tabutenti`
--
ALTER TABLE `tabutenti`
  ADD PRIMARY KEY (`idUtente`);

--
-- Indici per le tabelle `tabvalutazioni`
--
ALTER TABLE `tabvalutazioni`
  ADD PRIMARY KEY (`idVoto`),
  ADD KEY `idStudente` (`idStudente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `tabassenze`
--
ALTER TABLE `tabassenze`
  MODIFY `idAssenza` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tabattivitaprogrammate`
--
ALTER TABLE `tabattivitaprogrammate`
  MODIFY `IdAtt` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tabclassi`
--
ALTER TABLE `tabclassi`
  MODIFY `idClasse` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tabdiscipline`
--
ALTER TABLE `tabdiscipline`
  MODIFY `idDisciplina` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tabindirizzi`
--
ALTER TABLE `tabindirizzi`
  MODIFY `idIndirizzo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tabinsegnamenti`
--
ALTER TABLE `tabinsegnamenti`
  MODIFY `idInsegnamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tabregistroattivita`
--
ALTER TABLE `tabregistroattivita`
  MODIFY `idRegistro` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tabstudenti`
--
ALTER TABLE `tabstudenti`
  MODIFY `idStudente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tabutenti`
--
ALTER TABLE `tabutenti`
  MODIFY `idUtente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `tabvalutazioni`
--
ALTER TABLE `tabvalutazioni`
  MODIFY `idVoto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `tabassenze`
--
ALTER TABLE `tabassenze`
  ADD CONSTRAINT `tabassenze_ibfk_1` FOREIGN KEY (`idStudente`) REFERENCES `tabstudenti` (`idStudente`),
  ADD CONSTRAINT `tabassenze_ibfk_2` FOREIGN KEY (`idRegistro`) REFERENCES `tabregistroattivita` (`idRegistro`);

--
-- Limiti per la tabella `tabattivitaprogrammate`
--
ALTER TABLE `tabattivitaprogrammate`
  ADD CONSTRAINT `tabattivitaprogrammate_ibfk_1` FOREIGN KEY (`idClasse`) REFERENCES `tabclassi` (`idClasse`),
  ADD CONSTRAINT `tabattivitaprogrammate_ibfk_2` FOREIGN KEY (`idDisciplina`) REFERENCES `tabdiscipline` (`idDisciplina`);

--
-- Limiti per la tabella `tabclassi`
--
ALTER TABLE `tabclassi`
  ADD CONSTRAINT `tabclassi_ibfk_1` FOREIGN KEY (`idIndirizzo`) REFERENCES `tabindirizzi` (`idIndirizzo`);

--
-- Limiti per la tabella `tabdiscipline`
--
ALTER TABLE `tabdiscipline`
  ADD CONSTRAINT `tabdiscipline_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `tabutenti` (`idUtente`);

--
-- Limiti per la tabella `tabinsegnamenti`
--
ALTER TABLE `tabinsegnamenti`
  ADD CONSTRAINT `tabinsegnamenti_ibfk_1` FOREIGN KEY (`idClasse`) REFERENCES `tabclassi` (`idClasse`),
  ADD CONSTRAINT `tabinsegnamenti_ibfk_2` FOREIGN KEY (`idUtente`) REFERENCES `tabutenti` (`idUtente`);

--
-- Limiti per la tabella `tabregistroattivita`
--
ALTER TABLE `tabregistroattivita`
  ADD CONSTRAINT `tabregistroattivita_ibfk_1` FOREIGN KEY (`idClasse`) REFERENCES `tabclassi` (`idClasse`),
  ADD CONSTRAINT `tabregistroattivita_ibfk_2` FOREIGN KEY (`idUtente`) REFERENCES `tabutenti` (`idUtente`),
  ADD CONSTRAINT `tabregistroattivita_ibfk_3` FOREIGN KEY (`idDisciplina`) REFERENCES `tabdiscipline` (`idDisciplina`),
  ADD CONSTRAINT `tabregistroattivita_ibfk_4` FOREIGN KEY (`idAtt`) REFERENCES `tabattivitaprogrammate` (`IdAtt`);

--
-- Limiti per la tabella `tabstudenti`
--
ALTER TABLE `tabstudenti`
  ADD CONSTRAINT `tabstudenti_ibfk_1` FOREIGN KEY (`idClasse`) REFERENCES `tabclassi` (`idClasse`);

--
-- Limiti per la tabella `tabvalutazioni`
--
ALTER TABLE `tabvalutazioni`
  ADD CONSTRAINT `tabvalutazioni_ibfk_1` FOREIGN KEY (`idStudente`) REFERENCES `tabstudenti` (`idStudente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
