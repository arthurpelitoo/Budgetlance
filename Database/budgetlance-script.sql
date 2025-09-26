create table usuario(
	id bigint not null auto_increment,
	nm_usuario varchar(50) not null,
	email varchar(64) not null,
	senha varchar(255) not null,
	primary key(id)
);

create table cliente(
	id bigint not null auto_increment,
	id_usuario bigint not null, 
	nm_cliente varchar(50) not null,
	telefone varchar(25) null,
	email varchar(64) null,
	primary key(id),
	foreign key(id_usuario) references usuario(id)
);

create table categoria_servico(
	id bigint not null auto_increment,
	id_usuario bigint not null,
	nm_servico varchar(35) not null,
	desc_servico varchar(240) null,
	primary key(id),
	foreign key(id_usuario) references usuario(id)
);

create table orcamento(
	id bigint not null auto_increment,
	id_cliente bigint not null,
	id_usuario bigint not null,
	id_cs bigint not null,
	nm_orcamento varchar(50) not null,
	desc_orcamento varchar(240) not null,
	valor decimal(8,2) not null,
	prazo datetime not null,
	primary key(id),
	foreign key(id_cliente) references cliente(id),
	foreign key(id_usuario) references usuario(id),
	foreign key(id_cs) references categoria_servico(id)
);

ALTER TABLE orcamento
ADD COLUMN status ENUM('pendente','aprovado', 'concluido', 'cancelado') NOT NULL DEFAULT 'pendente';

ALTER TABLE orcamento
MODIFY COLUMN status ENUM('pendente','enviado','aprovado','recusado','concluido','cancelado','expirado') 
NOT NULL DEFAULT 'pendente';

alter table usuario
add column tipo_usuario ENUM('usuario', 'adm') not null default 'usuario';


