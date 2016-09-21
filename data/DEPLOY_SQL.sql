
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
-- INMUTABLE TABLES
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
DROP TABLE IF EXISTS continents CASCADE;
DROP TABLE IF EXISTS subcontinents CASCADE;
DROP TABLE IF EXISTS countries CASCADE;
DROP TABLE IF EXISTS cities CASCADE;
DROP TABLE IF EXISTS genres CASCADE;
DROP TABLE IF EXISTS project_stages CASCADE;
DROP TABLE IF EXISTS roles CASCADE;

-- TABLE continents
-- - id     : ISO 3166-1 N3 numeric Code for regions
-- - name   : Name in English
-- - name_es: Name in Spanish
-- references:
--  - http://unstats.un.org/unsd/publication/SeriesM/SeriesM_49rev4S.pdf
CREATE TABLE continents (
    id      INT PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    name_es VARCHAR(255) NOT NULL
);
INSERT INTO continents (id, name, name_es) VALUES 
(000, '[null]'          , '[null]'           ),
(002, 'Africa'          , 'África'           ),
(009, 'Australia'       , 'Oceanía'          ),
(003, 'North America'   , 'América del Norte'),
(005, 'South America'   , 'América del Sur'  ),
(142, 'Asia'            , 'Asia'             ),
(150, 'Europe'          , 'Europa'           );
 

-- TABLE subcontinents
-- - id     : ISO 3166-1 N3 numeric Code for regions
-- - name   : Name in English
-- - name_es: Name in Spanish
-- references:
--  - http://unstats.un.org/unsd/publication/SeriesM/SeriesM_49rev4S.pdf
CREATE TABLE subcontinents (
    id      INT PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    name_es VARCHAR(255) NOT NULL,
    continent_id INT NOT NULL REFERENCES continents(id) ON DELETE CASCADE
);
INSERT INTO subcontinents (id, name, name_es, continent_id) VALUES 
(000, '[null]'                   , '[null]'                    , 000),
(014, 'Eastern Africa'           , 'África Oriental'           , 002),
(017, 'Central Africa'           , 'África Central'            , 002),
(015, 'Northern Africa'          , 'África Septentrional'      , 002),
(018, 'Southern Africa'          , 'África Meridional'         , 002),
(011, 'Western Africa'           , 'África occidental'         , 002),
(029, 'The Caribbean'            , 'El Caribe'                 , 003),
(013, 'Central America'          , 'América central'           , 003),
(021, 'Northern America'         , 'América septentrional'     , 003),
(005, 'South America'            , 'América del Sur'           , 005),
(053, 'Australia and New Zealand', 'Australia y Nueva Zelandia', 009),
(054, 'Melanesia'                , 'Melanesia'                 , 009),
(055, 'Micronesia-Polynesia'     , 'Micronesia-Polinesia'      , 009),
(030, 'Eastern Asia'             , 'Asia oriental'             , 142),
(062, 'Central Asia'             , 'Asia central meridional'   , 142),
(035, 'Southeastern Asia'        , 'Asia sudoriental'          , 142),
(145, 'Western Asia'             , 'Asia occidental'           , 142),
(151, 'Eastern Europe'           , 'Europa oriental'           , 150),
(154, 'Northern Europe'          , 'Europa septentrional'      , 150),
(039, 'Southern Europe'          , 'Europa meridional'         , 150),
(155, 'Western Europe'           , 'Europa occidental'         , 150);


-- TABLE countries
-- - id       : ISO 3166-1 N3 numeric Code
-- - cod_A3   : ISO 3166-1 Alpha 3 Code
-- - name     : Name in English
-- - name_es  : Name in Spanish
-- - continent_id   : ISO 3166-1 N3 Code of the corresponding continent
-- - subcontinent_id: ISO 3166-1 N3 Code of the corresponding continent region
-- - latitude : Centroid latitude 
-- - longitude: Centroid longitude
-- references:
--  - OpenGeocode   , http://www.opengeocode.org/
--  - United Nations, http://unstats.un.org/unsd/publication/SeriesM/SeriesM_49rev4S.pdf
CREATE TABLE countries (
    id        INT PRIMARY KEY,
    cod_A3    CHAR(3) NOT NULL,
    name      VARCHAR(255) NOT NULL,
    name_es   VARCHAR(255) NOT NULL,
    subcontinent_id INT NOT NULL REFERENCES subcontinents(id) ON DELETE CASCADE,
    latitude  REAL NOT NULL,
    longitude REAL NOT NULL
);
INSERT INTO countries VALUES (0, '[-]', '[null]', '[null]', 0, 0.0, 0.0);
-- INSERT: run the countries.sql file.


-- TABLE cities
-- - id        : City Geoname ID
-- - name      : Name in English
-- - latitude  : Centroid latitude 
-- - longitude : Centroid longitude
-- - country_id: ISO 3166-1 N3 numeric Code of the corresponding country
-- references:
--  - Geonames: http://www.geonames.org/
--  - MaxMind GeoLite Legacy: http://dev.maxmind.com/????
--  - MaxMind GeoLite2 City: http://dev.maxmind.com/geoip/geoip2/geolite2/
CREATE TABLE cities (
    id    INT PRIMARY KEY,
    name  VARCHAR(255) NOT NULL,
    country_id INT NOT NULL REFERENCES countries(id) ON DELETE CASCADE,
    latitude  REAL NOT NULL,
    longitude REAL NOT NULL
);
INSERT INTO cities VALUES (0, '[null]', 0, 0, 0);
-- INSERT: import the cities.csv file. You might need to divide
--  it into several lighter pieces.

-- TABLE genres
CREATE TABLE genres (
    id      INT PRIMARY KEY,
    name    VARCHAR(15) NOT NULL,
    name_es VARCHAR(15) NOT NULL
);
INSERT INTO genres VALUES 
 (0,'[null]', '[null]'),
 (1,'male'  , 'hombre'),
 (2,'female', 'mujer'),
 (3,'other' , 'other');


-- TABLE project_stages
CREATE TABLE project_stages (
    id      INT PRIMARY KEY,
    name    VARCHAR(15) NOT NULL,
    name_es VARCHAR(15) NOT NULL
);
INSERT INTO project_stages VALUES 
 (0,'[null]', '[null]'),
 (1,'starting'     , 'empezando'   ),
 (2,'planification', 'planificando'),
 (3,'in execution' , 'en ejecución'),
 (4,'finished'     , 'terminado'   ),
 (5,'aborted'      , 'abortado'    );


-- TABLE roles
CREATE TABLE roles (
    id      INT PRIMARY KEY,
    name    VARCHAR(100) NOT NULL
);
INSERT INTO roles VALUES 
 (0,'user'), (1,'admin'), (2,'superadmin');


-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
-- TABLES DEPENDENT FROM THE INSTANCE
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
DROP TABLE IF EXISTS instances CASCADE;
DROP TABLE IF EXISTS organization_types CASCADE;
DROP TABLE IF EXISTS categories CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS projects CASCADE;
DROP TABLE IF EXISTS categories_projects CASCADE;

-- TABLE instances
CREATE TABLE instances (
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(100) NOT NULL UNIQUE,
    name_es     VARCHAR(100) NOT NULL UNIQUE,
    namespace   VARCHAR(10)  NOT NULL UNIQUE,
    description    TEXT         NOT NULL,
    description_es TEXT         NOT NULL,
    logo        VARCHAR(255) DEFAULT NULL,
    passphrase  VARCHAR(255) DEFAULT 'token',
    use_org_types         BOOLEAN NOT NULL DEFAULT TRUE,
    use_user_genre        BOOLEAN NOT NULL DEFAULT TRUE,
    use_user_organization BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_cities       BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_stage        BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_categories   BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_description  BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_url          BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_contribution BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_contributing BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_organization BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_location     BOOLEAN NOT NULL DEFAULT TRUE,
    use_proj_dates        BOOLEAN NOT NULL DEFAULT TRUE,
    proj_max_categories   INT NOT NULL DEFAULT 4
);
INSERT INTO instances (name, name_es, namespace, description, description_es) VALUES 
('[null]', '[null]', 'admin', '[null]', '[null]');


-- TABLE organization_types
CREATE TABLE organization_types (
    id          SERIAL UNIQUE,
    name        VARCHAR(100) NOT NULL,
    name_es     VARCHAR(100) NOT NULL,
    instance_id INT NOT NULL REFERENCES instances(id) ON DELETE CASCADE,
    PRIMARY KEY (instance_id, id)
);

-- TABLE categories
CREATE TABLE categories (
    id      SERIAL UNIQUE,
    name    VARCHAR(100) NOT NULL,
    name_es VARCHAR(100) NOT NULL,
    instance_id INT NOT NULL REFERENCES instances(id) ON DELETE CASCADE,
    PRIMARY KEY (instance_id, id)
);


-- TABLE users
-- - id     : user id
-- - name   : User Name (not username !)
-- - email  : User Email. Required for Login. Needs to be unique.
-- - contact: Contact email. Can be shared or NULL (defaults to the email field)
-- - password: Hashed password for authentication.
-- - role_id     : user role. Cant be NULL
-- - instance_id : user role. Cant be NULL. When an instance is deleted, all user too!
-- - genre_id    : user genre. Can be set to usused
-- - main_organization: Name of user's main organization. Can be NULL.
-- - organization_type_id: Type of users's main organization. If deleted or unused, sets [null].
-- - created : User creation time record
-- - modified: User modification time record
CREATE TABLE users (
    id          SERIAL UNIQUE,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    contact     VARCHAR(100),
    password    VARCHAR(255) NOT NULL,
    role_id     INT NOT NULL DEFAULT 0 REFERENCES roles(id),
    genre_id    INT NOT NULL DEFAULT 0 REFERENCES genres(id) ON DELETE SET DEFAULT,
    main_organization VARCHAR(255),
    created   TIMESTAMP,
    modified  TIMESTAMP,
    PRIMARY KEY (id)
);


-- TABLE belongsToMany Join
CREATE TABLE instances_users (
    instance_id INT NOT NULL REFERENCES instances(id) ON DELETE CASCADE,
    user_id     INT NOT NULL REFERENCES users(id)     ON DELETE CASCADE,
    PRIMARY KEY (instance_id, user_id)
);


-- TABLE projects
CREATE TABLE projects (
    id           SERIAL UNIQUE,
    name         VARCHAR(255) NOT NULL,
    user_id      INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    instance_id  INT NOT NULL REFERENCES instances(id) ON DELETE CASCADE,
    description  TEXT NOT NULL,
    url          VARCHAR(255) NOT NULL,
    contribution TEXT NOT NULL,
    contributing TEXT NOT NULL,
    organization VARCHAR(255),
    organization_type_id INT NOT NULL DEFAULT 0 REFERENCES organization_types(id) ON DELETE SET DEFAULT,
    project_stage_id     INT NOT NULL DEFAULT 0 REFERENCES project_stages(id) ON DELETE SET DEFAULT,
    country_id           INT NOT NULL REFERENCES countries(id),
    city_id              INT DEFAULT 0 REFERENCES cities(id) ON DELETE SET DEFAULT,
    latitude  REAL,
    longitude REAL,
    created  TIMESTAMP,
    modified TIMESTAMP,
    start_date   DATE,
    finish_date  DATE,
    PRIMARY KEY (instance_id, id)
);

-- TABLE belongsToMany Join
CREATE TABLE categories_projects (
    project_id  INT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
    category_id INT NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    PRIMARY KEY (project_id, category_id)
);



-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
-- populate database for ADMINS
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
INSERT INTO users (name, email, contact, password, role_id, genre_id, main_organization, created, modified) VALUES
('Matías Pavez' , 'matias.pavez@ing.uchile.cl', 'matias.pavez@ing.uchile.cl', '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 2, 1, 'dvine', '2016-08-01 12:00:00', '2016-08-01 12:00:00'),
('Lionel Brossi', 'lionelbrossi@gmail.com'    , 'lionelbrossi@gmail.com'    , '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 2, 1, 'dvine', '2016-08-01 12:00:00', '2016-08-01 12:00:00');
INSERT INTO instances_users VALUES (1, 1), (1, 2);
-- password: tester, salt: 0000000000000000000000000000000000000000000000000000000000000000
-- tester@tester.tester, tester


-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
-- populate database for CAS example
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
INSERT INTO instances (name, name_es, namespace, description, description_es) VALUES 
('Conectados Al Sur', 'Conectados Al Sur', 'cas',
 'Global mapping of research and projects on digital citizenchip of children and youth. ',
 'Mapeo global de investigaciones y proyectos sobre ciudadanía digital de niños, niñas y adolescentes.');

INSERT INTO organization_types (name, name_es, instance_id) VALUES
 ('[null]'                              , '[null]'              , 2),
 ('Academic'                            , 'Academia'            , 2),
 ('Practitioner'                        , 'Profesional'         , 2),
 ('Activists'                           , 'Activista'           , 2),
 ('Philanthropists'                     , 'Filantropo'          , 2),
 ('Government official'                 , 'Gobierno'            , 2),
 ('Representative of technology company', 'Compañia Tecnológica', 2),
 ('NGO'                                 , 'ONG'                 , 2),
 ('IGO'                                 , 'OIG'                 , 2),
 ('Other'                               , 'Otro'                , 2);

INSERT INTO categories (name, name_es, instance_id) VALUES
 ('[null]'                                         , '[null]'                                                    , 2),
 ('Creativity and Innovation'                      , 'Creatividad e Innovación'                                  , 2),
 ('Health and Wealth'                              , 'Salud y Bienestar'                                         , 2),
 ('Privacy, Identity and Online Reputation'        , 'Privacidad, Identidad y Reputación Online'                 , 2),
 ('Technology in education'                        , 'Tecnología en la educación'                                , 2),
 ('Methodologies'                                  , 'Metodologías'                                              , 2),
 ('Security'                                       , 'Seguridad'                                                 , 2),
 ('Heritage and Culture'                           , 'Patrimonio y Cultura'                                      , 2),
 ('Technology and Environment'                     , 'Tecnología y Medioambiente'                                , 2),
 ('Skills, Digital Literacy and Learning Cultures' , 'Habilidades, Alfabetismo Digital y Culturas de Aprendizaje', 2),
 ('Participation and Civic Engagement'             , 'Participación y Compromiso Cívico'                         , 2),
 ('Violence and Discrimination'                    , 'Violencia y Discriminación'                                , 2),
 ('Intellectual Property and Access to Culture'    , 'Propiedad Intelectual y Acceso a la Cultura'               , 2),
 ('Technology-based Entrepreneurship'              , 'Emprendimientos basados en Tecnología'                     , 2),
 ('Development of Content on Digital Platforms'    , 'Desarrollo de Contenido en Plataformas Digitales'          , 2),
 ('Ownership, Access and Use of Technology'        , 'Propiedad, Acceso y Uso de Tecnología'                     , 2),
 ('Opinion Formation'                              , 'Formación de Opinión'                                      , 2),
 ('Management of multidisciplinary teams to develop digital content', 'Manejo de equipos multidiciplinarios para el desarrollo de contenido digital', 2),
 ('Other'                                          , 'Otro'                                                      , 2);

INSERT INTO users (name, email, contact, password, role_id, genre_id, main_organization, created, modified) VALUES
('tester_cas admin', 'tester_cas_admin@gmail.com', 'tester_cas_admin@gmail.com', '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 1, 1, 'ICEI, Universidad de Chile', '2016-08-01 12:00:00', '2016-08-01 12:00:00'),
('tester_cas user' , 'tester_cas@gmail.com'      , 'tester_cas@gmail.com'      , '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 0, 1, 'ICEI, Universidad de Chile', '2016-08-01 12:00:00', '2016-08-01 12:00:00');
INSERT INTO instances_users VALUES (2, 3), (2, 4);

-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
-- populate database for CAS example
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
INSERT INTO instances (name, name_es, namespace, description, description_es) VALUES 
('Example instance', 'Instancia de ejemplo', 'example',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.');

INSERT INTO organization_types (name, name_es, instance_id) VALUES
 ('[null]'  , '[null]'  , 3),
 ('NGO'     , 'ONG'     , 3),
 ('IGO'     , 'OIG'     , 3),
 ('Academic', 'Academia', 3),
 ('Other'   , 'Otro'    , 3);

INSERT INTO categories (name, name_es, instance_id) VALUES
 ('[null]'     , '[null]'      , 3),
 ('Health'     , 'Salud'       , 3),
 ('Privacy'    , 'Privacidad'  , 3),
 ('Video Games', 'Video Juegos', 3),
 ('Other'      , 'Otro'        , 3);

INSERT INTO users (name, email, contact, password, role_id, genre_id, main_organization, created, modified) VALUES
('tester_example admin', 'tester_example_admin@gmail.com', 'tester_example_admin@gmail.com', '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 1, 1, 'ICEI, Universidad de Chile', '2016-08-01 12:00:00', '2016-08-01 12:00:00'),
('tester_example user' , 'tester_example@gmail.com'      , 'tester_example@gmail.com'      , '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 0, 1, 'ICEI, Universidad de Chile', '2016-08-01 12:00:00', '2016-08-01 12:00:00');
INSERT INTO instances_users VALUES (3, 5), (3, 6);

INSERT INTO users (name, email, contact, password, role_id, genre_id, main_organization, created, modified) VALUES
('tester_both'      , 'tester_both_admin@gmail.com', 'tester_both_admin@gmail.com', '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 1, 1, 'ICEI, Universidad de Chile', '2016-08-01 12:00:00', '2016-08-01 12:00:00'),
('tester_both user' , 'tester_both@gmail.com'      , 'tester_both@gmail.com'      , '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 0, 1, 'ICEI, Universidad de Chile', '2016-08-01 12:00:00', '2016-08-01 12:00:00');
INSERT INTO instances_users VALUES (2, 7), (3, 7), (2, 8), (3, 8);

-- populate dummy users
-- $ bin/cake migrations seed --seed UsersSeed

-- populate dummy instances_users
-- $ bin/cake migrations seed --seed InstancesUsersSeed

-- populate dummy projects
-- $ bin/cake migrations seed --seed ProjectsSeed

-- populate dummy categories_projects
-- $ bin/cake migrations seed --seed CategoriesProjectsSeed
