CREATE TABLE IF NOT EXISTS `funcao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `funcao` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `locado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `locado` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `locado` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `funcionario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `rg` VARCHAR(20) NOT NULL,
  `cpf` VARCHAR(20) NOT NULL,
  `salariobruto` DECIMAL(10,2) NOT NULL,
  `pagamento` DECIMAL(10,2) NOT NULL,
  `vtransporte` DECIMAL(10,2) NULL DEFAULT '0.00',
  `vrefeicao` DECIMAL(10,2) NULL DEFAULT '0.00',
  `sabado` DECIMAL(10,2) NULL DEFAULT '0.00',
  `producao` DECIMAL(10,2) NULL DEFAULT '0.00',
  `descontos` DECIMAL(10,2) NULL DEFAULT '0.00',
  `adiantamento` DECIMAL(10,2) NULL DEFAULT '0.00',
  `vrefeicao2` DECIMAL(10,2) NULL DEFAULT '0.00',
  `vtransporte2` DECIMAL(10,2) NULL DEFAULT '0.00',
  `vjanta` DECIMAL(10,2) NULL DEFAULT '0.00',
  `sabado2` DECIMAL(10,2) NULL DEFAULT '0.00',
  `gratificacao` DECIMAL(10,2) NULL DEFAULT '0.00',
  `descontos2` DECIMAL(10,2) NULL DEFAULT '0.00',
  `funcao_id` INT NULL,
  `locado_id` INT NULL,
  `quinzena` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_funcionario_locado`
    FOREIGN KEY (`locado_id`)
    REFERENCES `locado` (`id`)
    ON DELETE SET NULL
    ON UPDATE SET NULL,
  CONSTRAINT `fk_funcionario_funcao`
    FOREIGN KEY (`funcao_id`)
    REFERENCES `funcao` (`id`)
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(50) NULL DEFAULT NULL,
  `senha` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO usuario (login,senha) VALUES ('anildo','12345');
INSERT INTO funcao ('locado') VALUES ('HTC'),('SEMP TCL'),('ARCON'),('SEMP TV'),('HINES'),('SOLE'),('LGE'),('CAL-COMP'),('CASA'),('TECA');
INSERT INTO funcao ('funcao') VALUES ('MOTORISTA CARRETEIRO'),
('AGENTE DE PORTARIA'),
('COORD. ADMINISTRATIVO'),
('ASSIST. OPERACIONAL'),
('ACONTÁBIL'),
('OPER.  DE EMPILHADEIRA'),
('AJUDANTE DE CARGA'),
('CONFERENTE'),
('MANUTENÇÃO'),
('ADMINISTRATIVO'),
('LAVADOR'),
('AJUDANTE DE MECANICO'),
('MOTORISTA DE CAMINHÃO '),
('BORRACHEIRO'),
('FUNILEIRO'),
('MECANICO'),
('ELETRICISTA'),
('CASEIRO'),
('AUX. DE IDOSO'),
('FRILANCE');