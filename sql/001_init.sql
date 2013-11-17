-- site_id of 0 is YT
-- external_id is an outside facing reference.  For YT, this would be their video id
create table video (
	`id`                bigint unsigned auto_increment,
	`site_id`           int unsigned default 0,
	`title`             varchar(2048),
	`description`       mediumtext,
	`duration`          int unsigned,
	`external_id`       varchar(255) not null,
	`created_at`        timestamp not null default current_timestamp,
	`updated_at`        timestamp null,
	`published_at`      timestamp null,
	primary key (`id`)	
) engine=InnoDB;
create unique index `external_id` on video (`site_id`, `external_id`);

create table comment (
	`id`                bigint unsigned auto_increment,
	`video_id`          bigint unsigned not null,
	`person_id`         bigint unsigned not null,
	`external_id`       varchar(255) not null,
	`message`           mediumtext not null,
	`created_at`        timestamp not null default current_timestamp,
	`updated_at`        timestamp,
	primary key (`id`)
) engine=InnoDB;
create index `video_id` on comment (`video_id`);
create index `external_id` on comment (`external_id`);

create table person (
	`id`                bigint unsigned auto_increment,
	`identity_id`       int unsigned,
	`external_id`       varchar(255) not null,
	`handle`            varchar(256),
	`created_at`        timestamp not null default current_timestamp,
	primary key (`id`)
) engine=InnoDB;
create unique index `external_id` on person (`identity_id`, `external_id`);

-- the access and refresh tokens are apart of the OAuth2 implementation
-- I'm assuming that all identity providers use OAuth2
create table identity (
	`id`                bigint unsigned auto_increment,
	`provider_id`       int unsigned,
	`external_id`       varchar(255) not null,
	`access_token`      varchar(255),
	`refresh_token`     varchar(255),
	`token_expires_at`  timestamp,
	primary key (`id`)
);
create index `provider_id` on identity (`provider_id`, `external_id`);

create table provider (
	`id`                bigint unsigned auto_increment,
	`name` 	            varchar(64),
	primary key (`id`)
);