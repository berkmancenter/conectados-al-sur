
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
INSERT INTO countries (id, cod_A3, name, name_es, subcontinent_id, latitude, longitude) VALUES 
(004, 'AFG', 'Afghanistan'                             , 'Afganistán'                              , 062,  33.00 ,  065.00 ),
(008, 'ALB', 'Albania'                                 , 'Albania'                                 , 039,  41.00 ,  020.00 ),
(010, 'ATA', 'Antarctica'                              , 'Antártida'                               , 005, -78.44 , -106.59 ),
(012, 'DZA', 'Algeria'                                 , 'Argelia'                                 , 015,  28.00 ,  003.00 ),
(016, 'ASM', 'American Samoa'                          , 'Samoa Americana'                         , 055, -14.33 , -170.00 ),
(020, 'AND', 'Andorra'                                 , 'Andorra'                                 , 039,  42.50 ,  001.50 ),
(024, 'AGO', 'Angola'                                  , 'Angola'                                  , 017, -12.50 ,  018.50 ),
(028, 'ATG', 'Antigua and Barbuda'                     , 'Antigua y Barbuda'                       , 029,  17.05 , -061.79 ),
(031, 'AZE', 'Azerbaijan'                              , 'Azerbaiyán'                              , 145,  40.50 ,  047.50 ),
(032, 'ARG', 'Argentina'                               , 'Argentina'                               , 005, -34.00 , -064.00 ),
(036, 'AUS', 'Australia'                               , 'Australia'                               , 053, -27.00 ,  133.00 ),
(040, 'AUT', 'Austria'                                 , 'Austria'                                 , 155,  47.33 ,  013.33 ),
(044, 'BHS', 'The Bahamas'                             , 'Bahamas'                                 , 029,  24.25 , -076.00 ),
(048, 'BHR', 'Bahrain'                                 , 'Bahrein'                                 , 145,  26.00 ,  050.54 ),
(050, 'BGD', 'Bangladesh'                              , 'Bangladesh'                              , 062,  24.00 ,  090.00 ),
(051, 'ARM', 'Armenia'                                 , 'Armenia'                                 , 145,  40.00 ,  045.00 ),
(052, 'BRB', 'Barbados'                                , 'Barbados'                                , 029,  13.16 , -059.53 ),
(056, 'BEL', 'Belgium'                                 , 'Bélgica'                                 , 155,  50.83 ,  004.00 ),
(060, 'BMU', 'Bermuda'                                 , 'Bermuda'                                 , 021,  32.33 , -064.75 ),
(064, 'BTN', 'Bhutan'                                  , 'Bhután'                                  , 062,  27.50 ,  090.50 ),
(068, 'BOL', 'Bolivia'                                 , 'Bolivia'                                 , 005, -17.00 , -065.00 ),
(070, 'BIH', 'Bosnia and Herzegovina'                  , 'Bosnia y Herzegovina'                    , 039,  44.00 ,  018.00 ),
(072, 'BWA', 'Botswana'                                , 'Botswana'                                , 018, -22.00 ,  024.00 ),
(076, 'BRA', 'Brazil'                                  , 'Brasil'                                  , 005, -10.00 , -055.00 ),
(084, 'BLZ', 'Belize'                                  , 'Belice'                                  , 013,  17.25 , -088.75 ),
(090, 'SLB', 'Solomon Islands'                         , 'Islas Salomón'                           , 054, -08.00 ,  159.00 ),
(092, 'VGB', 'British Virgin Islands'                  , 'Islas Vírgenes Británicas'               , 029,  18.50 ,  064.50 ),
(096, 'BRN', 'Brunei'                                  , 'Brunei Darussalam'                       , 035,  04.50 ,  114.66 ),
(100, 'BGR', 'Bulgaria'                                , 'Bulgaria'                                , 151,  43.00 ,  025.00 ),
(104, 'MMR', 'Burma'                                   , 'Myanmar'                                 , 035,  22.00 ,  098.00 ),
(108, 'BDI', 'Burundi'                                 , 'Burundi'                                 , 014, -03.50 ,  030.00 ),
(112, 'BLR', 'Belarus'                                 , 'Belarús'                                 , 151,  53.00 ,  028.00 ),
(116, 'KHM', 'Cambodia'                                , 'Camboya'                                 , 035,  13.00 ,  105.00 ),
(120, 'CMR', 'Cameroon'                                , 'Camerún'                                 , 017,  06.00 ,  012.00 ),
(124, 'CAN', 'Canada'                                  , 'Canadá'                                  , 021,  60.00 , -095.00 ),
(132, 'CPV', 'Cape Verde'                              , 'Cabo Verde'                              , 011,  16.00 , -024.00 ),
(136, 'CYM', 'Cayman Islands'                          , 'Islas Caimán'                            , 029,  19.50 , -080.50 ),
(140, 'CAF', 'Central African Republic'                , 'República Centroafricana'                , 017,  07.00 ,  021.00 ),
(144, 'LKA', 'Sri Lanka'                               , 'Sri Lanka'                               , 062,  07.00 ,  081.00 ),
(148, 'TCD', 'Chad'                                    , 'Chad'                                    , 017,  15.00 ,  019.00 ),
(152, 'CHL', 'Chile'                                   , 'Chile'                                   , 005, -30.00 , -071.00 ),
(156, 'CHN', 'China'                                   , 'China'                                   , 030,  35.00 ,  105.00 ),
(158, 'TWN', 'Taiwan, Province of China'               , 'Taiwán'                                  , 030,  23.59 ,  119.89 ),
(170, 'COL', 'Colombia'                                , 'Colombia'                                , 005,  04.00 , -072.00 ),
(174, 'COM', 'Comoros'                                 , 'Comoras'                                 , 014, -12.16 ,  044.25 ),
(178, 'COG', 'Congo (Brazzaville)'                     , 'Congo'                                   , 017, -01.00 ,  015.00 ),
(180, 'COD', 'Democratic Republic of the Congo'        , 'República Democrática del Congo'         , 017,  00.00 ,  025.00 ),
(184, 'COK', 'Cook Islands'                            , 'Islas Cook'                              , 055, -21.23 , -159.76 ),
(188, 'CRI', 'Costa Rica'                              , 'Costa Rica'                              , 013,  10.00 , -084.00 ),
(191, 'HRV', 'Croatia'                                 , 'Croacia'                                 , 039,  45.16 ,  015.50 ),
(192, 'CUB', 'Cuba'                                    , 'Cuba'                                    , 029,  21.50 , -080.00 ),
(196, 'CYP', 'Cyprus'                                  , 'Chipre'                                  , 145,  35.00 ,  033.00 ),
(203, 'CZE', 'Czech Republic'                          , 'República Checa'                         , 151,  49.75 ,  015.50 ),
(204, 'BEN', 'Benin'                                   , 'Benin'                                   , 011,  09.50 ,  002.25 ),
(208, 'DNK', 'Denmark'                                 , 'Dinamarca'                               , 154,  56.00 ,  010.00 ),
(212, 'DMA', 'Dominica'                                , 'Dominica'                                , 029,  15.41 , -061.33 ),
(214, 'DOM', 'Dominican Republic'                      , 'República Dominicana'                    , 029,  19.00 , -070.66 ),
(218, 'ECU', 'Ecuador'                                 , 'Ecuador'                                 , 005, -02.00 , -077.50 ),
(222, 'SLV', 'El Salvador'                             , 'El Salvador'                             , 013,  13.83 , -088.91 ),
(226, 'GNQ', 'Equatorial Guinea'                       , 'Guinea Ecuatorial'                       , 017,  02.00 ,  010.00 ),
(231, 'ETH', 'Ethiopia'                                , 'Etiopía'                                 , 014,  08.00 ,  038.00 ),
(232, 'ERI', 'Eritrea'                                 , 'Eritrea'                                 , 014,  15.00 ,  039.00 ),
(233, 'EST', 'Estonia'                                 , 'Estonia'                                 , 154,  59.00 ,  026.00 ),
(234, 'FRO', 'Faroe Islands'                           , 'Islas Feroe'                             , 154,  62.00 , -007.00 ),
(238, 'FLK', 'Falkland Islands (Islas Malvinas)'       , 'Islas Malvinas (Falkland),'              , 005, -51.75 , -059.00 ),
(242, 'FJI', 'Fiji'                                    , 'Fiji'                                    , 054, -18.00 ,  175.00 ),
(246, 'FIN', 'Finland'                                 , 'Finlandia'                               , 154,  64.00 ,  026.00 ),
(250, 'FRA', 'France'                                  , 'Francia'                                 , 155,  46.00 ,  002.00 ),
(254, 'GUF', 'French Guiana'                           , 'Guayana Francesa'                        , 005,  04.00 , -053.00 ),
(258, 'PYF', 'French Polynesia'                        , 'Polinesia Francesa'                      , 055, -15.00 , -140.00 ),
(260, 'ATF', 'French Southern Territories'             , 'Territorios Australes Franceses'         , 014, -49.12 ,  051.64 ),
(262, 'DJI', 'Djibouti'                                , 'Djibouti'                                , 014,  11.50 ,  043.00 ),
(266, 'GAB', 'Gabon'                                   , 'Gabón'                                   , 017, -01.00 ,  011.75 ),
(268, 'GEO', 'Georgia'                                 , 'Georgia'                                 , 145,  42.00 ,  043.50 ),
(270, 'GMB', 'The Gambia'                              , 'Gambia'                                  , 011,  13.46 ,  016.56 ),
(275, 'PSE', 'State of Palestine'                      , 'Palestina'                               , 145,  31.77 ,  035.23 ),
(276, 'DEU', 'Germany'                                 , 'Alemania'                                , 155,  51.00 ,  009.00 ),
(288, 'GHA', 'Ghana'                                   , 'Ghana'                                   , 011,  08.00 , -002.00 ),
(292, 'GIB', 'Gibraltar'                               , 'Gibraltar'                               , 039,  36.13 , -005.34 ),
(296, 'KIR', 'Kiribati'                                , 'Kiribati'                                , 055,  01.41 ,  173.00 ),
(300, 'GRC', 'Greece'                                  , 'Grecia'                                  , 039,  39.00 ,  022.00 ),
(304, 'GRL', 'Greenland'                               , 'Groenlandia'                             , 021,  72.00 , -040.00 ),
(308, 'GRD', 'Grenada'                                 , 'Granada'                                 , 029,  12.11 , -061.66 ),
(316, 'GUM', 'Guam'                                    , 'Guam'                                    , 055,  13.46 ,  144.78 ),
(320, 'GTM', 'Guatemala'                               , 'Guatemala'                               , 013,  15.50 , -090.25 ),
(324, 'GIN', 'Guinea'                                  , 'Guinea'                                  , 011,  11.00 , -010.00 ),
(328, 'GUY', 'Guyana'                                  , 'Guyana'                                  , 005,  05.00 , -059.00 ),
(332, 'HTI', 'Haiti'                                   , 'Haití'                                   , 029,  19.00 , -072.41 ),
(336, 'VAT', 'Vatican City'                            , 'Santa Sede'                              , 039,  41.89 ,  012.44 ),
(340, 'HND', 'Honduras'                                , 'Honduras'                                , 013,  15.00 , -086.50 ),
(344, 'HKG', 'Hong Kong'                               , 'Hong Kong'                               , 030,  22.25 ,  114.16 ),
(348, 'HUN', 'Hungary'                                 , 'Hungría'                                 , 151,  47.00 ,  020.00 ),
(352, 'ISL', 'Iceland'                                 , 'Islandia'                                , 154,  65.00 , -018.00 ),
(356, 'IND', 'India'                                   , 'India'                                   , 062,  20.00 ,  077.00 ),
(360, 'IDN', 'Indonesia'                               , 'Indonesia'                               , 035, -05.00 ,  120.00 ),
(364, 'IRN', 'Iran'                                    , 'República Islámica del Irán'             , 062,  32.00 ,  053.00 ),
(368, 'IRQ', 'Iraq'                                    , 'Iraq'                                    , 145,  33.00 ,  044.00 ),
(372, 'IRL', 'Ireland'                                 , 'Irlanda'                                 , 154,  53.00 , -008.00 ),
(376, 'ISR', 'Israel'                                  , 'Israel'                                  , 145,  31.50 ,  034.75 ),
(380, 'ITA', 'Italy'                                   , 'Italia'                                  , 039,  42.83 ,  012.83 ),
(384, 'CIV', 'Côte dIvoire'                            , 'Côte d’Ivoire'                           , 011,  08.00 , -005.00 ),
(388, 'JAM', 'Jamaica'                                 , 'Jamaica'                                 , 029,  18.25 , -077.50 ),
(392, 'JPN', 'Japan'                                   , 'Japón'                                   , 030,  36.00 ,  138.00 ),
(398, 'KAZ', 'Kazakhstan'                              , 'Kazajstán'                               , 062,  48.00 ,  068.00 ),
(400, 'JOR', 'Jordan'                                  , 'Jordania'                                , 145,  31.00 ,  036.00 ),
(404, 'KEN', 'Kenya'                                   , 'Kenya'                                   , 014,  01.00 ,  038.00 ),
(408, 'PRK', 'North Korea'                             , 'República Popular Democrática de Corea'  , 030,  40.00 ,  127.00 ),
(410, 'KOR', 'South Korea'                             , 'República de Corea'                      , 030,  37.00 ,  127.50 ),
(414, 'KWT', 'Kuwait'                                  , 'Kuwait'                                  , 145,  29.50 ,  045.75 ),
(417, 'KGZ', 'Kyrgyzstan'                              , 'Kirguistán'                              , 062,  41.00 ,  075.00 ),
(418, 'LAO', 'Laos'                                    , 'República Democrática Popular Lao'       , 035,  18.00 ,  105.00 ),
(422, 'LBN', 'Lebanon'                                 , 'Líbano'                                  , 145,  33.83 ,  035.83 ),
(426, 'LSO', 'Lesotho'                                 , 'Lesotho'                                 , 018, -29.50 ,  028.50 ),
(428, 'LVA', 'Latvia'                                  , 'Letonia'                                 , 154,  57.00 ,  025.00 ),
(430, 'LBR', 'Liberia'                                 , 'Liberia'                                 , 011,  06.50 , -009.50 ),
(434, 'LBY', 'Libya'                                   , 'Jamahiriya Árabe Libia'                  , 015,  25.00 ,  017.00 ),
(438, 'LIE', 'Liechtenstein'                           , 'Liechtenstein'                           , 155,  47.26 ,  009.53 ),
(440, 'LTU', 'Lithuania'                               , 'Lituania'                                , 154,  56.00 ,  024.00 ),
(442, 'LUX', 'Luxembourg'                              , 'Luxemburgo'                              , 155,  49.75 ,  006.16 ),
(446, 'MAC', 'Macau'                                   , 'Macao'                                   , 030,  22.16 ,  113.55 ),
(450, 'MDG', 'Madagascar'                              , 'Madagascar'                              , 014, -20.00 ,  047.00 ),
(454, 'MWI', 'Malawi'                                  , 'Malawi'                                  , 014, -13.50 ,  034.00 ),
(458, 'MYS', 'Malaysia'                                , 'Malasia'                                 , 035,  02.50 ,  112.50 ),
(462, 'MDV', 'Maldives'                                , 'Maldivas'                                , 062,  03.25 ,  073.00 ),
(466, 'MLI', 'Mali'                                    , 'Malí'                                    , 011,  17.00 , -004.00 ),
(470, 'MLT', 'Malta'                                   , 'Malta'                                   , 039,  35.83 ,  014.58 ),
(478, 'MRT', 'Mauritania'                              , 'Mauritania'                              , 011,  20.00 , -012.00 ),
(480, 'MUS', 'Mauritius'                               , 'Mauricio'                                , 014, -20.28 ,  057.54 ),
(484, 'MEX', 'Mexico'                                  , 'México'                                  , 013,  23.00 , -102.00 ),
(492, 'MCO', 'Monaco'                                  , 'Mónaco'                                  , 155,  43.73 ,  007.40 ),
(496, 'MNG', 'Mongolia'                                , 'Mongolia'                                , 030,  46.00 ,  105.00 ),
(498, 'MDA', 'Moldova'                                 , 'República de Moldova'                    , 151,  47.00 ,  029.00 ),
(499, 'MNE', 'Montenegro'                              , 'Montenegro'                              , 039,  42.78 ,  019.46 ),
(500, 'MSR', 'Montserrat'                              , 'Montserrat'                              , 029,  16.75 , -062.20 ),
(504, 'MAR', 'Morocco'                                 , 'Marruecos'                               , 015,  32.00 , -005.00 ),
(508, 'MOZ', 'Mozambique'                              , 'Mozambique'                              , 014, -18.25 ,  035.00 ),
(512, 'OMN', 'Oman'                                    , 'Omán'                                    , 145,  21.00 ,  057.00 ),
(516, 'NAM', 'Namibia'                                 , 'Namibia'                                 , 018, -22.00 ,  017.00 ),
(520, 'NRU', 'Nauru'                                   , 'Nauru'                                   , 055, -00.53 ,  166.91 ),
(524, 'NPL', 'Nepal'                                   , 'Nepal'                                   , 062,  28.00 ,  084.00 ),
(528, 'NLD', 'Netherlands'                             , 'Países Bajos'                            , 155,  52.50 ,  005.75 ),
(533, 'ABW', 'Aruba'                                   , 'Aruba'                                   , 029,  12.50 , -069.96 ),
(540, 'NCL', 'New Caledonia'                           , 'Nueva Caledonia'                         , 054, -21.50 ,  165.50 ),
(548, 'VUT', 'Vanuatu'                                 , 'Vanuatu'                                 , 054, -16.00 ,  167.00 ),
(554, 'NZL', 'New Zealand'                             , 'Nueva Zelandia'                          , 053, -41.00 ,  174.00 ),
(558, 'NIC', 'Nicaragua'                               , 'Nicaragua'                               , 013,  13.00 , -085.00 ),
(562, 'NER', 'Niger'                                   , 'Níger'                                   , 011,  16.00 ,  008.00 ),
(566, 'NGA', 'Nigeria'                                 , 'Nigeria'                                 , 011,  10.00 ,  008.00 ),
(570, 'NIU', 'Niue'                                    , 'Niue'                                    , 055, -19.03 , -169.86 ),
(574, 'NFK', 'Norfolk Island'                          , 'Islas Norfolk'                           , 053, -29.03 ,  167.94 ),
(578, 'NOR', 'Norway'                                  , 'Noruega'                                 , 154,  62.00 ,  010.00 ),
(580, 'MNP', 'Northern Mariana Islands'                , 'Islas Marianas Septentrionales'          , 055,  15.19 ,  145.75 ),
(583, 'FSM', 'Federated States of Micronesia'          , 'Estados Federados de Micronesia'         , 055,  06.91 ,  158.25 ),
(584, 'MHL', 'Marshall Islands'                        , 'Islas Marshall'                          , 055,  09.00 ,  168.00 ),
(585, 'PLW', 'Palau'                                   , 'Palau'                                   , 055,  07.50 ,  134.50 ),
(586, 'PAK', 'Pakistan'                                , 'Pakistán'                                , 062,  30.00 ,  070.00 ),
(591, 'PAN', 'Panama'                                  , 'Panamá'                                  , 013,  09.00 , -080.00 ),
(598, 'PNG', 'Papua New Guinea'                        , 'Papua Nueva Guinea'                      , 054, -06.00 ,  147.00 ),
(600, 'PRY', 'Paraguay'                                , 'Paraguay'                                , 005, -23.00 , -058.00 ),
(604, 'PER', 'Peru'                                    , 'Perú'                                    , 005, -10.00 , -076.00 ),
(608, 'PHL', 'Philippines'                             , 'Filipinas'                               , 035,  13.00 ,  122.00 ),
(612, 'PCN', 'Pitcairn Islands'                        , 'Pitcairn'                                , 055, -25.06 , -130.09 ),
(616, 'POL', 'Poland'                                  , 'Polonia'                                 , 151,  52.00 ,  020.00 ),
(620, 'PRT', 'Portugal'                                , 'Portugal'                                , 039,  39.50 , -008.00 ),
(624, 'GNB', 'Guinea-Bissau'                           , 'Guinea-Bissau'                           , 011,  12.00 , -015.00 ),
(626, 'TLS', 'Timor-Leste'                             , 'Timor Oriental'                          , 035, -08.83 ,  125.91 ),
(630, 'PRI', 'Puerto Rico'                             , 'Puerto Rico'                             , 029,  18.25 , -066.50 ),
(634, 'QAT', 'Qatar'                                   , 'Qatar'                                   , 145,  25.50 ,  051.25 ),
(638, 'REU', 'Réunion'                                 , 'Reunión'                                 , 014, -21.11 ,  055.53 ),
(642, 'ROU', 'Romania'                                 , 'Rumania'                                 , 151,  46.00 ,  025.00 ),
(643, 'RUS', 'Russia'                                  , 'Federación de Rusia'                     , 151,  60.00 ,  100.00 ),
(646, 'RWA', 'Rwanda'                                  , 'Rwanda'                                  , 014, -02.00 ,  030.00 ),
(654, 'SHN', 'Saint Helena'                            , 'Santa Elena'                             , 011, -15.94 , -005.70 ),
(659, 'KNA', 'Saint Kitts and Nevis'                   , 'Saint Kitts y Nevis'                     , 029,  17.33 , -062.75 ),
(660, 'AIA', 'Anguilla'                                , 'Anguila'                                 , 029,  18.25 , -063.16 ),
(662, 'LCA', 'Saint Lucia'                             , 'Santa Lucía'                             , 029,  13.88 , -060.96 ),
(666, 'SPM', 'Saint Pierre and Miquelon'               , 'San Pedro y Miquelón'                    , 021,  46.83 , -056.33 ),
(670, 'VCT', 'Saint Vincent and the Grenadines'        , 'San Vicente y las Granadinas'            , 029,  13.25 , -061.20 ),
(674, 'SMR', 'San Marino'                              , 'San Marino'                              , 039,  43.76 ,  012.41 ),
(678, 'STP', 'Sao Tome and Principe'                   , 'Santo Tomé y Príncipe'                   , 017,  01.00 ,  007.00 ),
(682, 'SAU', 'Saudi Arabia'                            , 'Arabia Saudita'                          , 145,  25.00 ,  045.00 ),
(686, 'SEN', 'Senegal'                                 , 'Senegal'                                 , 011,  14.00 , -014.00 ),
(688, 'SRB', 'Serbia'                                  , 'Serbia'                                  , 039,  44.80 ,  020.46 ),
(690, 'SYC', 'Seychelles'                              , 'Seychelles'                              , 014, -04.58 ,  055.66 ),
(694, 'SLE', 'Sierra Leone'                            , 'Sierra Leona'                            , 011,  08.50 , -011.50 ),
(702, 'SGP', 'Singapore'                               , 'Singapur'                                , 035,  01.36 ,  103.80 ),
(703, 'SVK', 'Slovakia'                                , 'Eslovaquia'                              , 151,  48.14 ,  017.11 ),
(704, 'VNM', 'Vietnam'                                 , 'Viet Nam'                                , 035,  16.16 ,  107.83 ),
(705, 'SVN', 'Slovenia'                                , 'Eslovenia'                               , 039,  46.11 ,  014.81 ),
(706, 'SOM', 'Somalia'                                 , 'Somalia'                                 , 014,  10.00 ,  049.00 ),
(710, 'ZAF', 'South Africa'                            , 'Sudáfrica'                               , 018, -29.00 ,  024.00 ),
(716, 'ZWE', 'Zimbabwe'                                , 'Zimbabwe'                                , 014, -20.00 ,  030.00 ),
(724, 'ESP', 'Spain'                                   , 'España'                                  , 039,  40.00 , -004.00 ),
(728, 'SSD', 'South Sudan'                             , 'Sudán del Sur'                           , 014,  04.85 ,  031.60 ),
(729, 'SDN', 'Sudan'                                   , 'Sudán'                                   , 014,  15.63 ,  032.53 ),
(732, 'ESH', 'Western Sahara'                          , 'Sáhara Occidental'                       , 015,  24.50 , -013.00 ),
(740, 'SUR', 'Suriname'                                , 'Suriname'                                , 005,  04.00 , -056.00 ),
(744, 'SJM', 'Svalbard'                                , 'Islas Svalbard y Jan Mayen'              , 154,  78.00 ,  020.00 ),
(748, 'SWZ', 'Swaziland'                               , 'Swazilandia'                             , 018, -26.50 ,  031.50 ),
(752, 'SWE', 'Sweden'                                  , 'Suecia'                                  , 154,  62.00 ,  015.00 ),
(756, 'CHE', 'Switzerland'                             , 'Suiza'                                   , 155,  47.00 ,  008.00 ),
(760, 'SYR', 'Syria'                                   , 'República Árabe Siria'                   , 145,  35.00 ,  038.00 ),
(762, 'TJK', 'Tajikistan'                              , 'Tayikistán'                              , 062,  39.00 ,  071.00 ),
(764, 'THA', 'Thailand'                                , 'Tailandia'                               , 035,  15.00 ,  100.00 ),
(768, 'TGO', 'Togo'                                    , 'Togo'                                    , 011,  08.00 ,  001.16 ),
(772, 'TKL', 'Tokelau'                                 , 'Tokelau'                                 , 055, -09.00 , -172.00 ),
(776, 'TON', 'Tonga'                                   , 'Tonga'                                   , 055, -20.00 , -175.00 ),
(780, 'TTO', 'Trinidad and Tobago'                     , 'Trinidad y Tabago'                       , 029,  11.00 , -061.00 ),
(784, 'ARE', 'United Arab Emirates'                    , 'Emiratos Árabes Unidos'                  , 145,  24.00 ,  054.00 ),
(788, 'TUN', 'Tunisia'                                 , 'Túnez'                                   , 015,  34.00 ,  009.00 ),
(792, 'TUR', 'Turkey'                                  , 'Turquía'                                 , 145,  39.00 ,  035.00 ),
(795, 'TKM', 'Turkmenistan'                            , 'Turkmenistán'                            , 062,  40.00 ,  060.00 ),
(796, 'TCA', 'Turks and Caicos Islands'                , 'Islas Turcas y Caicos'                   , 029,  21.75 , -071.58 ),
(798, 'TUV', 'Tuvalu'                                  , 'Tuvalu'                                  , 055, -08.00 ,  178.00 ),
(800, 'UGA', 'Uganda'                                  , 'Uganda'                                  , 014,  01.00 ,  032.00 ),
(804, 'UKR', 'Ukraine'                                 , 'Ucrania'                                 , 151,  49.00 ,  032.00 ),
(807, 'MKD', 'Macedonia'                               , 'ex República Yugoslava de Macedonia'     , 039,  41.83 ,  022.00 ),
(818, 'EGY', 'Egypt'                                   , 'Egipto'                                  , 015,  27.00 ,  030.00 ),
(826, 'GBR', 'United Kingdom'                          , 'Reino Unido'                             , 154,  54.00 , -002.00 ),
(833, 'IMN', 'Isle of Man'                             , 'Isla de Man'                             , 154,  54.25 , -004.50 ),
(834, 'TZA', 'Tanzania'                                , 'República Unida de Tanzanía'             , 014, -06.00 ,  035.00 ),
(840, 'USA', 'United States'                           , 'Estados Unidos de América'               , 021,  38.00 , -097.00 ),
(850, 'VIR', 'Virgin Islands'                          , 'Islas Vírgenes de los Estados Unidos'    , 029,  18.33 , -064.83 ),
(854, 'BFA', 'Burkina Faso'                            , 'Burkina Faso'                            , 011,  13.00 , -002.00 ),
(858, 'URY', 'Uruguay'                                 , 'Uruguay'                                 , 005, -33.00 , -056.00 ),
(860, 'UZB', 'Uzbekistan'                              , 'Uzbekistán'                              , 062,  41.00 ,  064.00 ),
(862, 'VEN', 'Venezuela'                               , 'Venezuela'                               , 005,  08.00 , -066.00 ),
(876, 'WLF', 'Wallis and Futuna'                       , 'Islas Wallis y Futuna'                   , 055, -13.30 , -176.19 ),
(882, 'WSM', 'Samoa'                                   , 'Samoa'                                   , 055, -13.58 , -172.33 ),
(887, 'YEM', 'Yemen'                                   , 'Yemen'                                   , 145,  15.00 ,  048.00 ),
(894, 'ZMB', 'Zambia'                                  , 'Zambia'                                  , 014, -15.00 ,  030.00 );



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
-- NOT USED!


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
 (3,'other' , 'otro');


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
INSERT INTO roles VALUES (0,'user'), (1,'admin');


-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
-- TABLES DEPENDENT FROM THE INSTANCE
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
DROP TABLE IF EXISTS instances CASCADE;
DROP TABLE IF EXISTS organization_types CASCADE;
DROP TABLE IF EXISTS categories CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS users_recovery CASCADE;
DROP TABLE IF EXISTS instances_users CASCADE;
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
    passphrase  VARCHAR(255) NOT NULL DEFAULT 'token',
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
CREATE TABLE users (
    id          SERIAL UNIQUE,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    genre_id    INT NOT NULL DEFAULT 0 REFERENCES genres(id) ON DELETE SET DEFAULT,
    created   TIMESTAMP,
    modified  TIMESTAMP,
    PRIMARY KEY (id)
);


CREATE TABLE users_recovery (
    user_id   INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    random    VARCHAR(128) NOT NULL,
    modified  TIMESTAMP,
    PRIMARY KEY (user_id)
);

-- TABLE belongsToMany Join
CREATE TABLE instances_users (
    instance_id INT NOT NULL REFERENCES instances(id) ON DELETE CASCADE,
    user_id     INT NOT NULL REFERENCES users(id)     ON DELETE CASCADE,
    role_id     INT NOT NULL DEFAULT 0 REFERENCES roles(id),
    contact     VARCHAR(100),
    main_organization VARCHAR(255),
    organization_type_id INT NOT NULL DEFAULT 1 REFERENCES organization_types(id) ON DELETE SET DEFAULT,
    PRIMARY KEY (instance_id, user_id)
);


-- TABLE projects
CREATE TABLE projects (
    id           SERIAL UNIQUE,
    name         VARCHAR(255) NOT NULL,
    user_id      INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    instance_id  INT NOT NULL REFERENCES instances(id) ON DELETE CASCADE,
    description  TEXT NOT NULL,
    url          VARCHAR(255),
    contribution TEXT NOT NULL,
    contributing TEXT NOT NULL,
    organization VARCHAR(255),
    organization_type_id INT NOT NULL DEFAULT 1 REFERENCES organization_types(id) ON DELETE SET DEFAULT,
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
-- populate database for SYSADMIN
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
-- password: tester
INSERT INTO instances (name, name_es, namespace, description, description_es) VALUES 
('[null]', '[null]', 'app', '[null]', '[null]');
INSERT INTO organization_types (name, name_es, instance_id) VALUES
 ('[null]', '[null]', 1);
INSERT INTO users (name, email, password, genre_id, created, modified) VALUES
('Lionel Brossi', 'lionelbrossi@gmail.com', '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 1, '2016-08-01 12:00:00', '2016-08-01 12:00:00');
INSERT INTO instances_users (instance_id, user_id, role_id, contact, main_organization, organization_type_id) VALUES
(1, 1, 1, 'lionelbrossi@gmail.com', '[null]', 1);


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

INSERT INTO instances_users (instance_id, user_id, role_id, contact, main_organization, organization_type_id) VALUES
(2, 1, 1, 'lionelbrossi@gmail.com', 'ICEI, Universidad de Chile', 3);

INSERT INTO projects (name, user_id, instance_id, description, url, contribution, contributing, organization, organization_type_id, project_stage_id, country_id, city_id, latitude, longitude, created, modified, start_date, finish_date) VALUES
('DVINE WEB-APP', 1, 2, 'DVINE WEB APP is a tool that helps to visualize and geolocalize projects in a given field.

It helps to map and explore projects that are being developed in different countries around the world, allowing the visualization of categories, networks and relevant information.', 'http://app.dvine.cl/', '---------------------------------------', '---------------------------------------', 'Conectados al Sur', 3, 3, 152, 0, 0, 0, '2016-10-31 00:00:00', '2016-10-30 05:30:13', '2016-10-31', NULL);


INSERT INTO categories_projects (project_id, category_id) VALUES
(1, 3);


GRANT USAGE, SELECT ON SEQUENCE categories_id_seq TO dvinecl_baker;
GRANT USAGE, SELECT ON SEQUENCE instances_id_seq TO dvinecl_baker;
GRANT USAGE, SELECT ON SEQUENCE organization_types_id_seq TO dvinecl_baker;
GRANT USAGE, SELECT ON SEQUENCE projects_id_seq TO dvinecl_baker;
GRANT USAGE, SELECT ON SEQUENCE users_id_seq TO dvinecl_baker;
ALTER SEQUENCE instances_id_seq          RESTART WITH  3;
ALTER SEQUENCE organization_types_id_seq RESTART WITH 12;
ALTER SEQUENCE users_id_seq              RESTART WITH  2;
ALTER SEQUENCE categories_id_seq         RESTART WITH 20;
ALTER SEQUENCE projects_id_seq           RESTART WITH  2;

