-- Configuration BDD
SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS siop1_wiki;
USE siop1_wiki;

-- ---------------------------------------------

-- Désactive temporairement les contraintes de clé étrangère
SET FOREIGN_KEY_CHECKS = 0;

-- Suppression des tables dans le bon ordre
DROP TABLE IF EXISTS article_versions;
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS bans;
DROP TABLE IF EXISTS contact;
DROP TABLE IF EXISTS users;

-- Réactive les contraintes de clé étrangère
SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------

-- Création des tables :
-- Table `users`
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE, -- UNIQUE pour éviter les doublons
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL -- ENUM pour obliger à choisir entre 'user' ou 'admin'
) ENGINE=InnoDB;

-- Table `articles`
CREATE TABLE IF NOT EXISTS article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATE NOT NULL,
    updated_at DATE NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table `article_versions`
CREATE TABLE IF NOT EXISTS article_version (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATE NOT NULL,
    image_url TEXT NULL,
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    FOREIGN KEY (article_id) REFERENCES article(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table `images`
CREATE TABLE IF NOT EXISTS image (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url TEXT NOT NULL,
    created_at DATE NOT NULL,
    article_id INT NOT NULL,
    FOREIGN KEY (article_id) REFERENCES article(id) ON DELETE CASCADE
)ENGINE=InnoDB;

-- Table `bans`
CREATE TABLE IF NOT EXISTS ban (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reason TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE DEFAULT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table `contact`
CREATE TABLE IF NOT EXISTS contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------

-- Jeux de données

-- Insertion des utilisateurs fictifs avec génération de hash
INSERT INTO user (username, password, role) VALUES
('root', SHA2('root', 256), 'admin'), -- Utilisateur administrateur
('user1', SHA2('password1', 256), 'user'),       -- Premier utilisateur fictif
('user2', SHA2('password2', 256), 'user');       -- Deuxième utilisateur fictif


-- Insertion d'un ban temporaire pour 'user2' pour une durée de 7 jours
INSERT INTO ban (reason, start_date, end_date, user_id)
VALUES 
('Violation des règles de conduite', NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), 3);


-- Insertion du contenu d'articles sur les civilisations

INSERT INTO article (title, content, created_at, user_id)
VALUES
("Les Incas : Maîtres des Andes et Architectes d'un Empire Légendaire",
"La civilisation inca, épanouie entre le XIIIᵉ et le XVIᵉ siècle, a su dominer les vastes étendus de l'Amérique du Sud, englobant des territoires correspondant aujourd'hui au Pérou, à l'Équateur, à la Bolivie, ainsi qu'à des parties de la Colombie, du Chili et de l'Argentine. Au cœur de cet empire se trouvait Cuzco, la capitale sacrée, considérée comme le 'nombril du monde'.

Les Incas ont développé une société hautement organisée, avec une administration centralisée et une infrastructure impressionnante. Le réseau routier inca, s'étendant sur des milliers de kilomètres, facilitait les communications et le contrôle des vastes territoires. Les chasquis, messagers rapides, parcouraient ces routes pour transmettre des informations à travers l'empire.

L'agriculture était au cœur de l'économie inca. Grâce à des techniques ingénieuses comme les terrasses de culture et des systèmes d'irrigation avancés, ils cultivaient une variété de produits tels que le maïs, la pomme de terre et le quinoa. L'élevage de camélidés, comme les lamas et les alpagas, fournissait de la laine, de la viande et servait de moyen de transport. 

La religion inca était polythéiste, avec un panthéon de divinités liées aux forces de la nature. Inti, le dieu Soleil, occupait une place prépondérante, et son culte était central dans la vie religieuse et politique. Les Incas pratiquaient également le culte des ancêtres et des huacas, des objets ou lieux sacrés. 
L'architecture inca témoigne de leur maîtrise technique et esthétique. Des sites emblématiques comme le Machu Picchu illustrent leur capacité à intégrer harmonieusement les constructions dans des environnements naturels difficiles, utilisant des techniques de taille de pierre précises sans mortier. 

Malgré leur puissance, les Incas ont été confrontés à l'arrivée des conquistadors espagnols au XVIᵉ siècle. En 1532, l'empereur Atahualpa fut capturé par Francisco Pizarro, marquant le début de la chute de l'empire inca. Cependant, l'héritage inca perdure à travers les traditions, les langues et les vestiges archéologiques qui continuent de fasciner le monde entier.
", 
NOW(), 2),

("Les Mayas : Astronomes Érudits et Architectes des Cités Éternelles", 
"La civilisation maya, l'une des plus fascinantes de Mésoamérique, s'est épanouie sur une vaste région englobant le sud du Mexique, le Guatemala, le Belize, ainsi que des parties du Honduras et du Salvador. Connus pour leurs avancées remarquables en écriture, art, architecture, agriculture, mathématiques et astronomie, les Mayas ont laissé un héritage culturel inestimable. 

Les cités-États mayas, telles que Tikal, Palenque et Copán, étaient des centres urbains sophistiqués, dotés de pyramides majestueuses, de palais ornés et de terrains de jeu de balle cérémoniels. L'architecture maya se distingue par son intégration harmonieuse avec l'environnement naturel et l'utilisation de techniques de construction avancées. 

Les Mayas ont développé un système d'écriture hiéroglyphique complexe, l'un des rares systèmes d'écriture entièrement développés des Amériques précolombiennes. Leur expertise en mathématiques, notamment l'utilisation du concept du zéro, et leurs observations astronomiques précises ont permis l'élaboration de calendriers sophistiqués, reflétant une compréhension approfondie des cycles célestes. 

La société maya était structurée en une hiérarchie complexe, avec une élite dirigeante, des prêtres, des artisans et des agriculteurs. La religion jouait un rôle central, avec un panthéon de divinités liées aux forces de la nature et des rituels incluant des offrandes et des sacrifices destinés à maintenir l'équilibre cosmique. 
Vers la fin de la période classique, entre le VIIIᵉ et le IXᵉ siècle, de nombreuses cités mayas des Basses-Terres ont été abandonnées, marquant un déclin mystérieux souvent qualifié d'effondrement de la civilisation maya classique. Les causes de cet effondrement font l'objet de débats parmi les chercheurs, impliquant des facteurs tels que des conflits internes, des changements environnementaux et des perturbations économiques.

Malgré ces bouleversements, les Mayas ont perduré, et aujourd'hui, des millions de descendants continuent de vivre dans les régions ancestrales, préservant leur langue et leurs traditions, témoignant de la résilience et de la continuité de cette civilisation emblématique.
", 
NOW(), 1),

("Les Aztèques : Guerriers Valeureux et Bâtisseurs d''un Empire Flottant", 
"Les Aztèques, également appelés Mexicas, étaient un peuple amérindien de langue nahuatl qui a dominé la Mésoamérique entre le XIVᵉ et le XVIᵉ siècle. Originaires d'Aztlan, une région mythique du nord, ils ont migré vers le plateau central du Mexique, fondant en 1325 leur capitale, Mexico-Tenochtitlan, sur les îles du lac Texcoco.

Leur société était hautement structurée, avec une hiérarchie rigide dominée par le tlatoani, souverain suprême, assisté de conseillers et de prêtres influents. Les Aztèques étaient réputés pour leur puissance militaire, soumettant de nombreuses cités-États et exigeant des tributs, consolidant ainsi un vaste empire. 

La religion occupait une place centrale dans la vie aztèque, avec un panthéon riche en divinités telles que Huitzilopochtli, dieu de la guerre et du soleil, et Quetzalcoatl, le serpent à plumes. Les sacrifices humains étaient pratiqués pour apaiser les dieux et assurer la prospérité de l'empire. 

L'architecture aztèque se distinguait par des constructions impressionnantes, notamment le Templo Mayor, grand temple dédié aux principales divinités, situé au cœur de Tenochtitlan. La ville elle-même était un chef-d'œuvre d'ingénierie, avec ses canaux, ses chaussées et ses jardins flottants appelés chinampas, témoignant de leur maîtrise de l'environnement lacustre. 

L'arrivée des conquistadors espagnols, menés par Hernán Cortés en 1519, a marqué le début de la chute de l'empire aztèque. Après des alliances avec des peuples soumis et des épidémies dévastatrices, Tenochtitlan est tombée en 1521, signant la fin de cette civilisation florissante.

Aujourd'hui, l'héritage aztèque perdure à travers les traditions, la langue nahuatl encore parlée par des communautés, et les vestiges archéologiques qui continuent de fasciner et d'inspirer le monde entier.
", 
NOW(), 1),

("Les Vikings : Navigateurs audacieux et bâtisseurs d'empires", 
"Les Vikings, originaires des régions actuelles de la Norvège, du Danemark et de la Suède, sont des figures emblématiques du Moyen Âge, connus pour leur audace, leur expertise maritime et leur influence durable sur l'histoire de l'Europe et au-delà. Entre le VIIIᵉ et le XIᵉ siècle, ces peuples scandinaves ont marqué le monde par leurs raids, leurs explorations et leurs conquêtes, s'étendant sur de vastes territoires, de l'Islande au Groenland, en passant par la Normandie, la Russie, et même l'Amérique du Nord.

Les Vikings étaient des maîtres navigateurs, construisant des drakkars, des navires longs et robustes, parfaitement adaptés pour les raids rapides le long des côtes, mais aussi pour de longues explorations maritimes. Ces embarcations leur ont permis de franchir des mers tumultueuses et d'établir des colonies à des milliers de kilomètres de leur terre d'origine. Leurs voyages ne se limitaient pas seulement aux côtes européennes, mais les menaient également en Asie centrale, au Moyen-Orient et jusqu’en Amérique du Nord, où ils fondèrent des colonies comme l’Anse aux Meadows au Canada, plusieurs siècles avant Christophe Colomb.

Outre leurs exploits guerriers, les Vikings étaient d'habiles commerçants. Grâce à leurs routes maritimes, ils ont établi un réseau commercial qui s’étendait de la mer Méditerranée jusqu’à l'Asie centrale. Ce réseau leur a permis d’échanger des fourrures, des esclaves, des armes et des objets d’artisanat, contribuant à la diffusion de nouvelles technologies et à l'échange de cultures à travers l'Asie, l'Europe et l'Afrique.

La société viking était centrée autour des clans familiaux, où l'honneur, la bravoure et la loyauté étaient des valeurs essentielles. Les Vikings étaient également des guerriers redoutables, et leurs croyances polythéistes jouaient un rôle crucial dans leur culture. Ils vénéraient des dieux puissants comme Odin, Thor et Freyja, et croyaient fermement à l'importance de l'au-delà, en particulier au Valhalla, où les guerriers morts au combat étaient accueillis par les dieux.

L'impact des Vikings sur l'histoire mondiale est immense. De la toponymie aux traditions culturelles, en passant par des vestiges archéologiques qui témoignent de leur passage, leur influence se fait encore sentir aujourd’hui. Leurs raids ont contribué à façonner les frontières et les sociétés européennes, et leur culture continue de fasciner par sa richesse et son mystère. Les Vikings, loin d’être de simples pillards, ont été des bâtisseurs de civilisations, laissant derrière eux une empreinte indélébile sur l'histoire de l'humanité.
", 
NOW(), 2),

("Les Atlantes : Peuple légendaire des confins de l''Afrique antique", 
"Les Atlantes sont un peuple mythique évoqué par les auteurs antiques, notamment Hérodote, qui les situe dans les régions désertiques de la Libye, à proximité de la montagne nommée « Atlas ». Cette localisation précise demeure incertaine, et les informations sur ce peuple sont principalement légendaires.

Selon Hérodote, les Atlantes résidaient dans une région éloignée des Colonnes d'Héraclès, sur un « bourrelet sablonneux » à proximité de la montagne Atlas, décrite comme la « colonne du ciel ». Ils étaient réputés pour leur mode de vie particulier, notamment leur végétarisme et le fait qu'ils ne rêvaient pas.

Le nom « Atlantes » a inspiré Platon pour nommer la civilisation fictive de l'Atlantide, présentée dans ses dialogues du « Critias » et du « Timée ». Cette civilisation mythique est décrite comme une puissance maritime avancée, qui aurait disparu après une catastrophe.

Outre Hérodote, d'autres auteurs antiques mentionnent les Atlantes, bien que leurs descriptions soient souvent vagues et légendaires. Par exemple, Pline l'Ancien rapporte que les Atlantes habitent « au milieu des solitudes », sans fournir de détails supplémentaires.

En somme, les Atlantes demeurent un peuple mystérieux de l'Antiquité, dont les récits ont traversé les âges, alimentant l'imaginaire collectif et inspirant diverses légendes, notamment celle de l'Atlantide.
", 
NOW(), 1),

("Les Peuples de la Mésopotamie : Berceaux des Civilisations Anciennes", 
"La Mésopotamie, située entre les fleuves Tigre et Euphrate, est souvent qualifiée de « berceau de la civilisation ». Cette région a été le foyer de plusieurs peuples et civilisations qui ont marqué l'histoire antique par leurs innovations culturelles, politiques et technologiques.

Les Sumériens, considérés comme l'un des premiers peuples de la Mésopotamie, ont fondé des cités-États indépendantes telles qu'Uruk, Ur et Lagash. Ils sont notamment reconnus pour l'invention de l'écriture cunéiforme vers 3500 av. J.-C., un système d'écriture sur tablettes d'argile qui a permis la documentation des transactions commerciales, des lois et des récits mythologiques. Leurs réalisations architecturales, comme les ziggourats, témoignent de leur avancée en matière d'urbanisme et de construction.

Sous le règne de Sargon d'Akkad au XXIVᵉ siècle av. J.-C., les Akkadiens ont réussi à unifier une grande partie de la Mésopotamie, établissant ainsi le premier empire connu de l'histoire. Cette unification a favorisé les échanges culturels et commerciaux entre les différentes régions, consolidant l'influence mésopotamienne dans le Proche-Orient ancien.

Babylone, fondée par les Amorrites au XVIIIᵉ siècle av. J.-C., est devenue un centre majeur de la Mésopotamie. Le roi Hammurabi (1792-1750 av. J.-C.) est célèbre pour avoir promulgué le Code de Hammurabi, l'un des premiers codes de lois écrits, qui a influencé les systèmes juridiques ultérieurs. Babylone était également renommée pour ses avancées en astronomie, en mathématiques et pour ses jardins suspendus, l'une des sept merveilles du monde antique.

Les Assyriens, originaires du nord de la Mésopotamie, ont établi un empire puissant entre le IXᵉ et le VIIᵉ siècle av. J.-C. Ils sont reconnus pour leur organisation militaire avancée, leur utilisation de la cavalerie et des chars de guerre, ainsi que pour leurs techniques de siège innovantes. Leur capitale, Ninive, était un centre culturel et administratif majeur, abritant la célèbre bibliothèque d'Assurbanipal, qui contenait des milliers de tablettes d'argile.

Après la chute de Babylone en 1595 av. J.-C., les Kassites, un peuple asiatique dont l'origine est encore incertaine, s'installent en Mésopotamie. Ils ont régné sur Babylone pendant environ 400 ans, apportant une stabilité relative et intégrant des éléments de la culture babylonienne tout en préservant leurs propres traditions.

Au VIᵉ siècle av. J.-C., les Chaldéens, également appelés Néobabyloniens, ont restauré la grandeur de Babylone sous le règne de Nabuchodonosor II. Ils sont célèbres pour la reconstruction de la ville, notamment la porte d'Ishtar et les jardins suspendus, et pour leur rôle dans la déportation des Juifs à Babylone.

La Mésopotamie a ainsi été le théâtre de civilisations successives, chacune contribuant à l'évolution de la région et laissant un héritage durable dans les domaines de l'écriture, du droit, des sciences et de l'urbanisme.
", 
NOW(), 1),

("Les Hittites : Pionniers du Fer et Diplomates de l’Antiquité", 
"La civilisation hittite, établie en Anatolie (l’actuelle Turquie), a prospéré entre le XVIIᵉ et le XIIᵉ siècle av. J.-C. Leur capitale, Hattusa, située dans les collines du nord de l'Anatolie, était un centre politique et religieux entouré de puissantes fortifications et ornée de portes monumentales comme la Porte des Lions. Les Hittites étaient des maîtres de la métallurgie du fer, une technologie qui leur conférait un avantage militaire significatif et renforçait leur économie.

Sur le plan militaire, ils se sont distingués par l’utilisation des chars de guerre, jouant un rôle clé dans leurs campagnes. Leur puissance atteignit son apogée sous le règne de Suppiluliuma Iᵉʳ, qui étendit leur influence jusqu’au Levant. Ils sont également célèbres pour avoir signé le premier traité de paix connu de l’histoire, le traité de Kadesh, conclu avec Ramsès II d’Égypte après une bataille majeure en 1274 av. J.-C.

La religion hittite était polythéiste, intégrant des divinités locales et étrangères, ce qui reflétait la diversité culturelle de leur empire. Cependant, vers 1200 av. J.-C., les Hittites disparurent brutalement, probablement à cause des invasions des Peuples de la mer et des bouleversements internes. Leur héritage demeure important, notamment dans les domaines de la diplomatie et de la métallurgie.
", 
NOW(), 1),

("Les Phéniciens : Navigateurs Ingénieux et Créateurs de l’Alphabet", 
"Les Phéniciens, établis sur les côtes de l’actuel Liban, ont prospéré entre le XIIᵉ et le IIIᵉ siècle av. J.-C. Connus comme des maîtres navigateurs, ils étaient d’excellents commerçants, reliant les côtes méditerranéennes grâce à un réseau de ports florissants comme Tyr, Sidon et Byblos. Ils ont également fondé de nombreuses colonies, dont la plus célèbre est Carthage, qui deviendra plus tard une puissance majeure.

Leur principale contribution à l’histoire est leur invention de l’alphabet phénicien, un système d’écriture simple et pratique qui a servi de base aux alphabets grec, latin et hébreu. Ce développement a révolutionné la communication et facilité les échanges commerciaux et culturels.

Les Phéniciens étaient célèbres pour leur teinture pourpre, produite à partir du murex, un mollusque marin. Cette couleur, rare et précieuse, était réservée à l’élite et symbolisait le pouvoir et la richesse. Leur influence s’étendait bien au-delà du commerce : ils ont diffusé des idées, des technologies et des produits dans toute la Méditerranée.

Malgré leur prospérité, les Phéniciens ont subi la domination des Assyriens, des Babyloniens, et enfin des Romains, ce qui a marqué le déclin progressif de leur civilisation. Leur héritage perdure à travers l’alphabet et les vestiges de leurs colonies.
", 
NOW(), 1),

("Les Minoens : L’Âge d’Or de la Crète", 
"Les Minoens, qui ont prospéré sur l’île de Crète entre 3000 et 1450 av. J.-C., sont l’une des premières grandes civilisations européennes. Leur culture doit son nom au légendaire roi Minos, connu pour le mythe du Minotaure. La société minoenne était centrée sur le commerce maritime, reliant la Crète à l’Égypte, au Proche-Orient et à la Grèce continentale.

Leurs palais, comme celui de Cnossos, étaient des complexes sophistiqués dotés de cours centrales, de fresques éclatantes et de systèmes de gestion de l’eau avancés. Ces palais servaient de centres politiques, économiques et religieux, reflétant une organisation sociale avancée. L’art minoen, célèbre pour ses fresques colorées représentant des scènes marines et des activités rituelles, témoigne d’une culture pacifique et prospère.

Les Minoens utilisaient un système d’écriture appelé Linéaire A, encore indéchiffré, ce qui limite notre compréhension de leur société. Cependant, leur influence sur les Grecs mycéniens est évidente, notamment dans les domaines religieux et artistiques.

Vers 1450 av. J.-C., la civilisation minoenne déclina brusquement, probablement à cause de l’éruption volcanique de Santorin, suivie d’invasions des Mycéniens. Malgré leur disparition, leur héritage perdure dans la mythologie grecque et les vestiges archéologiques.
", 
NOW(), 3),

("Les Mycéniens : Les Guerriers d’Homère", 
"Les Mycéniens, qui ont dominé la Grèce continentale entre 1600 et 1100 av. J.-C., sont considérés comme les prédécesseurs directs des Grecs classiques. Leur civilisation tire son nom de la cité de Mycènes, l’une des nombreuses cités fortifiées qui étaient au cœur de leur culture.

Les Mycéniens étaient des guerriers redoutables, et leurs récits ont inspiré les épopées d’Homère, comme L’Iliade et L’Odyssée. Leur société était hiérarchisée, dirigée par des rois locaux appelés wanax, résidant dans des palais entourés de fortifications massives en pierre, connues sous le nom de « murailles cyclopéennes ».

Ils maîtrisaient l’écriture sous la forme du Linéaire B, un système utilisé pour des documents administratifs, ce qui montre leur organisation avancée. Leurs richesses provenaient du commerce, des raids et de l’agriculture, et ils ont établi des contacts avec les Minoens, les Hittites et les Égyptiens.

La civilisation mycénienne déclina vers 1100 av. J.-C., marquant le début de l’âge sombre grec. Les raisons de cet effondrement restent débattues, impliquant peut-être des invasions, des troubles internes et des catastrophes naturelles. Cependant, leur influence se retrouve dans la culture grecque classique, notamment dans leur architecture, leur art et leurs récits héroïques.
",
NOW(), 1);


-- Insertion du contenu d'articles sur les civilisations

INSERT INTO article_version (title, content, created_at, user_id, article_id)
VALUES
("Les Incas : Maîtres des andes & Architectes d'un empire légendaire",
"La civilisation inca, épanouie entre le XIIIᵉ et le XVIᵉ siècle, a su dominer les vastes étendus de l'Amérique du Sud, englobant des territoires correspondant aujourd'hui au Pérou, à l'Équateur, à la Bolivie, ainsi qu'à des parties de la Colombie, du Chili et de l'Argentine. Au cœur de cet empire se trouvait Cuzco, la capitale sacrée, considérée comme le 'nombril du monde'.

Les Incas ont développé une société hautement organisée, avec une administration centralisée et une infrastructure impressionnante. Le réseau routier inca, s'étendant sur des milliers de kilomètres, facilitait les communications et le contrôle des vastes territoires. Les chasquis, messagers rapides, parcouraient ces routes pour transmettre des informations à travers l'empire.

L'agriculture était au cœur de l'économie inca. Grâce à des techniques ingénieuses comme les terrasses de culture et des systèmes d'irrigation avancés, ils cultivaient une variété de produits tels que le maïs, la pomme de terre et le quinoa. L'élevage de camélidés, comme les lamas et les alpagas, fournissait de la laine, de la viande et servait de moyen de transport.
", "2025/01/01", 1, 1),

("Les Minoens : L’Âge d’Or de la crète", 
"Les Minoens, qui ont prospéré sur l’île de Crète entre 3000 et 1450 av. J.-C., sont l’une des premières grandes civilisations européennes. Leur culture doit son nom au légendaire roi Minos, connu pour le mythe du Minotaure.
", "2025/01/01", 1, 9),

("Les Vikings", 
"En attente d'informations
", "2025/01/01", 1, 1);