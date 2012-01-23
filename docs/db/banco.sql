DROP DATABASE IF EXISTS `monografia_biblioteca`;
CREATE DATABASE `monografia_biblioteca` CHARSET=UTF8;
USE `monografia_biblioteca`;
-- Editoras
CREATE TABLE `editora`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`nome` VARCHAR(100) NOT NULL,
	`localizacao` VARCHAR(200) NOT NULL,
	`website` VARCHAR(150) DEFAULT NULL
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT INTO `editora`(`nome`, `localizacao`, `website`)
		VALUES
			('Novatec', 'São Paulo', 'http://novatec.com.br'),
			('The Pragmatic Bookshelf', 'USA', 'http://pragprog.com');
-- Autores
CREATE TABLE `autor`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`nome` VARCHAR(100) NOT NULL,
	`biografia` TEXT NOT NULL
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT INTO `autor`(`nome`, `biografia`)
		VALUES
			('João', 'João é bacharel em Ciência da Computação pelo CENTRO DE ENSINO SUPERIOR DE FOZ DO IGUAÇU, sua principal área de atuação é em sistemas web utilizando Java.'),
			('Mike Clark', 'Mike Clark is an independent consultant, author, trainer, and programmer. He’s the co-author of Agile Web Development with Rails, author of Pragmatic Project Automation, and runs The Pragmatic Studio. He helped build one of the first commercial Rails applications and continues working on other Rails projects (including this very bookstore!) through his company, Clarkware Consulting.');
-- Livros
CREATE TABLE `livro`(
	`isbn` VARCHAR(100) NOT NULL UNIQUE PRIMARY KEY,
	`editora_id` INT UNSIGNED NOT NULL,
	`autor_id` INT UNSIGNED NOT NULL,
	`titulo` VARCHAR(150) NOT NULL,
	`paginas` INT UNSIGNED NOT NULL,
	`ano` INT UNSIGNED NOT NULL,
	`resenha` TEXT NOT NULL,
	FOREIGN KEY(`editora_id`) REFERENCES `editora`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(`autor_id`) REFERENCES `autor`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT INTO `livro`(`isbn`, `editora_id`, `autor_id`, `titulo`, `paginas`, `ano`, `resenha`)
		VALUES
			('978-85-7522-189-1', 1, 1, 'Zend Framework Componentes Poderosos para PHP', 352, 2009, 'Zend Framework é um framework para o desenvolvimento de aplicações web em PHP, de código aberto e livre, orientado a objetos, desenvolvido com o objetivo de simplificar o desenvolvimento web enquanto promove as melhores práticas na comunidade de desenvolvedores PHP. Possibilita construir aplicações Web 2.0 e web services modernos, confiáveis e mais seguros, utilizando APIs amplamente disponíveis de líderes na disponibilização de serviços como Google, Amazon, Yahoo! e Flickr. '),
			('978-0-9787-3922-5', 2, 2, 'Advanced Rails Recipes', 464, 2008, 'Ruby on Rails continues to build up a tremendous head of steam. Fueled by significant benefits and an impressive portfolio of real-world applications already in production, Rails is destined to continue making significant inroads in coming years.\r\nEach new Rails application showing up on the web adds yet more to the collective wisdom of the Rails development community. Yesterday’s best practices yield to today’s latest and greatest techniques, as the state of the art is continually refined in kitchens all across the Internet. Indeed, these are times of great progress.\r\nAt the same time, it’s easy to get left behind in the wake of progress. Advanced Rails Recipes keeps you on the cutting edge of Rails development and, more importantly, continues to turn this fast-paced framework to your advantage.\r\nAdvanced Rails Recipes is filled with pragmatic recipes you’ll use on every Rails project. And by taking the code in these recipes and slipping it into your application you’ll not only deliver your application quicker, you’ll do so with the confidence that it’s done right.');
-- Usuários
CREATE TABLE `usuario`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`login` VARCHAR(10) NOT NULL,
	`senha` VARCHAR(100) NOT NULL,
	`nome_real` VARCHAR(100) NOT NULL
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT INTO `usuario`(`login`, `senha`, `nome_real`)
		VALUES
			('admin', SHA1('admin'), 'Administrador');
-- Membros
CREATE TABLE `membro`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`nome` VARCHAR(100) NOT NULL,
	`endereco` TINYTEXT NOT NULL,
	`telefone` VARCHAR(8)
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT INTO `membro`(`nome`, `endereco`, `telefone`)
		VALUES
			('Fernando Geraldo Mantoan', 'Rua Osvaldo Goch, 1190, Ap 422 Bl 04', '35255643');
-- Empréstimos
CREATE TABLE `emprestimo`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`membro_id` INT UNSIGNED NOT NULL,
	`data_emprestimo` DATE NOT NULL,
	`valor_juros` FLOAT NOT NULL,
	FOREIGN KEY(`membro_id`) REFERENCES `membro`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Itens de Empréstimos
CREATE TABLE `item_emprestimo`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`emprestimo_id` INT UNSIGNED NOT NULL,
	`livro_isbn` VARCHAR(100) NOT NULL,
	`data_prevista` DATE NOT NULL,
	`data_devolvida` DATE DEFAULT NULL,
	`valor_pago` FLOAT NOT NULL,
	FOREIGN KEY(`emprestimo_id`) REFERENCES `emprestimo`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(`livro_isbn`) REFERENCES `livro`(`isbn`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Histórico
CREATE TABLE `historico`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`prioridade` INT NOT NULL,
	`mensagem` VARCHAR(200) NOT NULL
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
