drop database if exists d_chat;
create database d_chat;

use d_chat;

drop table if exists hx_user;
create table hx_user(
	u_id int(11) not null auto_increment,
	`u_type` int(11) DEFAULT NULL,
	 `u_username` varchar(64) DEFAULT NULL,
	 `u_password` varchar(64) DEFAULT NULL,
	`u_agent` int(11) DEFAULT NULL,
	status tinyint(1) unsigned NOT NULL DEFAULT '0', 
	primary key(u_id)
)engine=InnoDB default charset=utf8;
insert into hx_user values(1,1,'boss','202cb962ac59075b964b07152d234b70',0,0);
insert into hx_user values(2,1,'sam','332532dcfaa1cbf61e2a266bd723612c',1,0);
insert into hx_user values(3,1,'luke','202cb962ac59075b964b07152d234b70',2,0);
insert into hx_user values(4,1,'peter','202cb962ac59075b964b07152d234b70',2,0);
insert into hx_user values(5,1,'alex','202cb962ac59075b964b07152d234b70',2,0);
insert into hx_user values(6,1,'tony','202cb962ac59075b964b07152d234b70',2,0);
insert into hx_user values(7,1,'jack','202cb962ac59075b964b07152d234b70',2,0);

drop table if exists hx_message;
create table hx_message(
	m_id int(11) not null auto_increment,
	content text default "",
	from_id int(11),
	to_id int(11),
	from_name varchar(64) default "",
	to_name	varchar(64) default "",
	add_time int(10) unsigned NOT NULL DEFAULT '0',
	status tinyint(1) unsigned NOT NULL DEFAULT '0', 
	primary key(m_id)
);
 