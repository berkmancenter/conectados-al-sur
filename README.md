# cas-app


## Deployment

composer install


## Database

```sql

-- DROP tables if exist
DROP TABLE genres CASCADE;
DROP TABLE organization_types CASCADE;
DROP TABLE categories CASCADE;
DROP TABLE project_stages CASCADE;
DROP TABLE countries CASCADE;
DROP TABLE cities CASCADE;
DROP TABLE cities_countries CASCADE;
DROP TABLE users CASCADE;
DROP TABLE projects CASCADE;
DROP TABLE categories_projects CASCADE;

-- genres
CREATE TABLE genres (
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(15) NOT NULL
);

-- organization_types
CREATE TABLE organization_types (
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(100) NOT NULL
);

-- categories
CREATE TABLE categories (
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(100) NOT NULL
);

-- project_stages
CREATE TABLE project_stages (
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(15) NOT NULL
);

-- countries
CREATE TABLE countries (
    id      INT PRIMARY KEY,
    cod_n3  CHAR(3) NOT NULL,
    latitude  DOUBLE PRECISION NOT NULL,
    longitude DOUBLE PRECISION NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    name_es VARCHAR(255) NOT NULL
);
-- cities
CREATE TABLE cities (
    id    SERIAL PRIMARY KEY,
    name_en  VARCHAR(255) NOT NULL,
    name_es  VARCHAR(255) NOT NULL,
    country_id INT NOT NULL REFERENCES countries(id),
    latitude  DOUBLE PRECISION NOT NULL,
    longitude DOUBLE PRECISION NOT NULL,
);

-- users
CREATE TABLE users (
    id        SERIAL PRIMARY KEY,
    name      VARCHAR(100) NOT NULL,
    email     VARCHAR(100) NOT NULL,
    password  VARCHAR(100) NOT NULL,
    genre_id  INT NOT NULL REFERENCES genres(id),
    main_organization VARCHAR(255) NOT NULL,
    organization_type_id INT NOT NULL REFERENCES organization_types(id),
    created   TIMESTAMP,
    modified  TIMESTAMP
);

-- projects
CREATE TABLE projects (
    id           SERIAL PRIMARY KEY,
    name         VARCHAR(255) NOT NULL,
    user_id      INT NOT NULL REFERENCES users(id),
    description  TEXT,
    url          VARCHAR(255) NOT NULL,
    contribution TEXT,
    contributing TEXT,
    organization VARCHAR(255) NOT NULL,
    organization_type_id INT NOT NULL REFERENCES organization_types(id),
    project_stage_id     INT NOT NULL REFERENCES project_stages(id),
    city_id              INT NOT NULL REFERENCES countries(id),
    created  TIMESTAMP,
    modified TIMESTAMP,
    start_date   DATE,
    finish_date  DATE

);

-- belongsToMany Join
CREATE TABLE categories_projects (
	project_id  INT NOT NULL REFERENCES projects(id),
    category_id INT NOT NULL REFERENCES categories(id),
    PRIMARY KEY (project_id, category_id)
);


-- populate database
INSERT INTO genres (name) VALUES 
 ('male'),
 ('female'),
 ('other');

INSERT INTO organization_types (name) VALUES 
 ('Academic'),
 ('Practitioner'),
 ('Activists'),
 ('Philanthropists'),
 ('Government official'),
 ('Representative of technology company'),
 ('NGO'),
 ('IGO');

INSERT INTO categories (name) VALUES 
 ('Creativity and Innovation'),
 ('Health and Wealth'),
 ('Privacy, Identity and Online Reputation'),
 ('Technology in education'),
 ('Methodologies'),
 ('Security'),
 ('Heritage and Culture'),
 ('Technology and Environment'),
 ('Skills, Digital Literacy and Learning Cultures'),
 ('Participation and Civic Engagement'),
 ('Violence and Discrimination'),
 ('Technology and Environment'),
 ('Technology-based Entrepreneurship'),
 ('Development of content on digital platforms'),
 ('Ownership , access and use of technology'),
 ('Opinion formation'),
 ('Management of multidisciplinary teams to develop digital content'),
 ('Intellectual Property and Access to Culture');

INSERT INTO project_stages (name) VALUES 
 ('starting'),
 ('planification'),
 ('in execution'),
 ('finished'),
 ('aborted');


```


```bash
$ bin/cake migrations seed --seed DatabaseSeed
$ bin/cake migrations seed --seed ProjectsSeed # version 1
$ bin/cake migrations seed --seed ProjectsSeed # version 2

```
