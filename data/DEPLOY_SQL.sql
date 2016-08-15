
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
(000, '[null continent]', '[null continent]' ),
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
(000, '[null subcontinent]'      , '[null subcontinent]'       , 000),
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
INSERT INTO countries VALUES (0, '[-]', '[null country]', '[null country]', 0, 0.0, 0.0);
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
INSERT INTO cities VALUES (0, '[null city]', 0, 0, 0);

-- TABLE genres
CREATE TABLE genres (
    id      INT PRIMARY KEY,
    name    VARCHAR(15) NOT NULL,
    name_es VARCHAR(15) NOT NULL
);
INSERT INTO genres VALUES 
 (0,'[unused]', '[unused]'),
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
 (0,'[unused]', '[unused]'),
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
    id          INT NOT NULL PRIMARY KEY,
    name        VARCHAR(100) NOT NULL UNIQUE,
    name_es     VARCHAR(100) NOT NULL UNIQUE,
    namespace   VARCHAR(10)  NOT NULL UNIQUE,
    description    TEXT         NOT NULL,
    description_es TEXT         NOT NULL,
    logo        VARCHAR(255) DEFAULT NULL,
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

-- TABLE organization_types
CREATE TABLE organization_types (
    id          INT NOT NULL UNIQUE,
    name        VARCHAR(100) NOT NULL UNIQUE,
    name_es     VARCHAR(100) NOT NULL UNIQUE,
    instance_id INT NOT NULL REFERENCES instances(id) ON DELETE CASCADE,
    PRIMARY KEY (instance_id, id)
);

-- TABLE categories
CREATE TABLE categories (
    id      INT NOT NULL UNIQUE,
    name    VARCHAR(100) NOT NULL UNIQUE,
    name_es VARCHAR(100) NOT NULL UNIQUE,
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
-- - organization_type_id: Type of users's main organization. If deleted or unused, sets [unused].
-- - created : User creation time record
-- - modified: User modification time record
CREATE TABLE users (
    id          INT          NOT NULL UNIQUE,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    contact     VARCHAR(100),
    password    VARCHAR(255) NOT NULL,
    role_id     INT NOT NULL DEFAULT 0 REFERENCES roles(id),
    instance_id INT NOT NULL REFERENCES instances(id) ON DELETE CASCADE,
    genre_id    INT NOT NULL DEFAULT 0 REFERENCES genres(id) ON DELETE SET DEFAULT,
    main_organization VARCHAR(255),
    organization_type_id INT NOT NULL DEFAULT 0 REFERENCES organization_types(id) ON DELETE SET DEFAULT,
    created   TIMESTAMP,
    modified  TIMESTAMP,
    PRIMARY KEY (instance_id, id)
);


-- TABLE projects
CREATE TABLE projects (
    id           INT NOT NULL UNIQUE,
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
    project_id  INT NOT NULL REFERENCES projects(id),
    category_id INT NOT NULL REFERENCES categories(id),
    PRIMARY KEY (project_id, category_id)
);


-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
-- populate database for CAS example
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
INSERT INTO instances (id, name, name_es, namespace, description, description_es) VALUES 
(0, 'Conectados Al Sur', 'Conectados Al Sur', 'cas' , 'Congreso Conectados al Sur Project is a ... blah','Proyectos del Congreso Conectados al Sur ... blabla.');

INSERT INTO organization_types VALUES 
 (0,'[unused]'                            , '[unused]'            , 0),
 (1,'Academic'                            , 'Academia'            , 0),
 (2,'Practitioner'                        , 'Profesional'         , 0),
 (3,'Activists'                           , 'Activista'           , 0),
 (4,'Philanthropists'                     , 'Filantropo'          , 0),
 (5,'Government official'                 , 'Gobierno'            , 0),
 (6,'Representative of technology company', 'Compañia Tecnológica', 0),
 (7,'NGO'                                 , 'ONG'                 , 0),
 (8,'IGO'                                 , 'OIG'                 , 0),
 (9,'Other'                               , 'Otro'                , 0);

INSERT INTO categories VALUES 
 (0, '[unused]'                                      , '[unused]'                                                  , 0),
 (1, 'Creativity and Innovation'                     , 'Creatividad e Innovación'                                  , 0),
 (2, 'Health and Wealth'                             , 'Salud y Bienestar'                                         , 0),
 (3, 'Privacy, Identity and Online Reputation'       , 'Privacidad, Identidad y Reputación Online'                 , 0),
 (4, 'Technology in education'                       , 'Tecnología en la educación'                                , 0),
 (5, 'Methodologies'                                 , 'Metodologías'                                              , 0),
 (6, 'Security'                                      , 'Seguridad'                                                 , 0),
 (7, 'Heritage and Culture'                          , 'Patrimonio y Cultura'                                      , 0),
 (8, 'Technology and Environment'                    , 'Tecnología y Medioambiente'                                , 0),
 (9, 'Skills, Digital Literacy and Learning Cultures', 'Habilidades, Alfabetismo Digital y Culturas de Aprendizaje', 0),
 (10, 'Participation and Civic Engagement'           , 'Participación y Compromiso Cívico'                         , 0),
 (11, 'Violence and Discrimination'                  , 'Violencia y Discriminación'                                , 0),
 (12, 'Intellectual Property and Access to Culture'  , 'Propiedad Intelectual y Acceso a la Cultura'               , 0),
 (13, 'Technology-based Entrepreneurship'            , 'Emprendimientos basados en Tecnología'                     , 0),
 (14, 'Development of Content on Digital Platforms'  , 'Desarrollo de Contenido en Plataformas Digitales'          , 0),
 (15, 'Ownership, Access and Use of Technology'      , 'Propiedad, Acceso y Uso de Tecnología'                     , 0),
 (16, 'Opinion Formation'                            , 'Formación de Opinión'                                      , 0),
 (17, 'Management of multidisciplinary teams to develop digital content', 'Manejo de equipos multidiciplinarios para el desarrollo de contenido digital', 0),
 (18, 'Other'                                        , 'Otro'                                                      , 0);

INSERT INTO users VALUES
(0, 'Lionel Brossi', 'lionelbrossi@gmail.com'    , 'lionelbrossi@gmail.com'    , 'superadmin', 2, 0, 1, 'ICEI, Universidad de Chile', 1, '2016-08-01 12:00:00', '2016-08-01 12:00:00'),
(1, 'Matías Pavez' , 'matias.pavez.b@gmail.com'  , 'matias.pavez.b@gmail.com'  , 'adminadmin', 1, 0, 1, 'FCFM, Universidad de Chile', 1, '2016-08-01 12:00:00', '2016-08-01 12:00:00'),
(2, 'TEST USER'    , 'matias.pavez@ing.uchile.cl', 'matias.pavez@ing.uchile.cl', 'useruser'  , 0, 0, 1, 'FCFM, Universidad de Chile', 1, '2016-08-01 12:00:00', '2016-08-01 12:00:00');

-- populate dummy users for CAS
-- $ bin/cake migrations seed --seed UsersSeed

-- populate dummy projects for CAS
-- $ bin/cake migrations seed --seed ProjectsSeed

-- populate dummy categories_projects for CAS
-- $ bin/cake migrations seed --seed CategoriesProjectsSeed
