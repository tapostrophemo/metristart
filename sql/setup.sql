create table users(
  id               int unsigned auto_increment,
  username         varchar(255) not null unique,
  password         varchar(40) not null,
  salt             varchar(32) not null,
  email            varchar(255) not null,
  registered_at    datetime not null,
  current_login_at datetime default null,
  last_login_at    datetime default null,
  updated_at       datetime default null,
  is_admin         boolean default 0,
  primary key(id)
) engine = InnoDB;

create table metrics (
  user_id int(10) unsigned not null,
  name varchar(32) not null,
  segment varchar(32) not null,
  data varchar(255) default null,
  primary key(user_id, name, segment),
  index(user_id, name, segment),
  foreign key (user_id) references users(id)
) engine = InnoDB;

