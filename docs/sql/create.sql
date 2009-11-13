create table questions (

	id serial,
	title varchar(255) not null,
	description text,
	created datetime not null,
	status enum('active','done') default 'active',
	author_id bigint unsigned not null,
	primary key (id),
	foreign key (author_id) references users (id)

) type = InnoDb;

create table answers (
	
	id serial,
	answer text not null,
	created datetime not null,
	author_id bigint unsigned not null,
	question_id bigint unsigned not null,
	primary key (id),
	foreign key (author_id) references users(id),
	foreign key (question_id) references questions(id)
	
) type = InnoDb;