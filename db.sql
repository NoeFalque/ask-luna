-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Jeu 30 Mars 2017 à 19:07
-- Version du serveur :  5.6.35
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `space`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `misunderstand` int(11) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE `medias` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_seen` int(11) NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `media_type` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `url_hd` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `media_type`, `url`, `url_hd`, `date`) VALUES
(46, 'The Aurora Tree', 'Yes, but can your tree do this?  Pictured is a visual coincidence between the dark branches of a nearby tree and bright glow of a distant aurora. The beauty of the aurora -- combined with how it seemed to mimic a tree right nearby -- mesmerized the photographer to such a degree that he momentarily forgot to take pictures. When viewed at the right angle, it seemed that this tree had aurora for leaves! Fortunately, before the aurora morphed into a different overall shape, he came to his senses and capture the awe-inspiring momentary coincidence.  Typically triggered by solar explosions, aurora are caused by high energy electrons impacting the Earth\'s atmosphere around 150 kilometers up.  The unusual Earth-sky collaboration was witnessed earlier this month in Iceland.    Follow APOD on: Facebook,  Google Plus,  Instagram, or Twitter', 'image', '1490893396.jpg', '1490893397.jpg', '2017-03-20'),
(47, 'Fast Stars and Rogue Planets in the Orion Nebula', 'Start with the constellation of Orion.  Below Orion\'s belt is a fuzzy area known as the Great Nebula of Orion.  In this nebula is a bright star cluster known as the Trapezium, marked by four bright stars near the image center. The newly born stars in the Trapezium and surrounding regions show the Orion Nebula to be one of the most active areas of star formation to be found in our area of the Galaxy. In Orion, supernova explosions and close interactions between stars have created rogue planets and stars that rapidly move through space. Some of these fast stars have been found by comparing different images of this region taken by the Hubble Space Telescope many years apart. Many of the stars in the featured image, taken in visible and near-infrared light, appear unusually red because they are seen through dust that scatters away much of their blue light.', 'image', '1490893449.jpg', '1490893450.jpg', '2017-03-21'),
(48, 'Central Cygnus Skyscape', 'In cosmic brush strokes of glowing hydrogen gas, this beautiful skyscape unfolds across the plane of our Milky Way Galaxy near the northern end of the Great Rift and the center of the constellation Cygnus the Swan. A 36 panel mosaic of telescopic image data, the scene spans about six degrees. Bright supergiant star Gamma Cygni (Sadr) to the upper left of the image center lies in the foreground of the complex gas and dust clouds and crowded star fields. Left of Gamma Cygni, shaped like two luminous wings divided by a long dark dust lane is IC 1318 whose popular name is understandably the Butterfly Nebula. The more compact, bright nebula at the lower right is NGC 6888, the Crescent Nebula. Some distance estimates for Gamma Cygni place it at around 1,800 light-years while estimates for IC 1318 and NGC 6888 range from 2,000 to 5,000 light-years.', 'image', '1490893480.jpg', '1490893482.jpg', '2017-03-22'),
(49, 'SH2-155: The Cave Nebula', 'This skyscape features dusty Sharpless catalog emission region Sh2-155, the Cave Nebula. In the telescopic image, data taken through a narrowband filter tracks the reddish glow of ionized hydrogen atoms. About 2,400 light-years away, the scene lies along the plane of our Milky Way Galaxy toward the royal northern constellation of Cepheus. Astronomical explorations of the region reveal that it has formed at the boundary of the massive Cepheus B molecular cloud and the hot, young stars of the Cepheus OB 3 association. The bright rim of ionized hydrogen gas is energized by radiation from the hot stars, dominated by the brightest star above and left of picture center. Radiation driven ionization fronts are likely triggering collapsing cores and new star formation within. Appropriately sized for a stellar nursery, the cosmic cave is over 10 light-years across.', 'image', '1490893498.jpg', '1490893500.jpg', '2017-03-23'),
(50, 'The Comet, the Owl, and the Galaxy', 'Comet 41P/Tuttle-Giacobini-Kresak poses for a Messier moment in this telescopic snapshot from March 21. In fact it shares the 1 degree wide field-of-view with two well-known entries in the 18th century comet-hunting astronomer\'s famous catalog. Sweeping through northern springtime skies just below the Big Dipper, the faint greenish comet was about 75 light-seconds from our fair planet. Dusty, edge-on spiral galaxy Messier 108 (bottom center) is more like 45 million light-years away. At upper right, the planetary nebula with an aging but intensely hot central star, the owlish Messier 97 is only about 12 thousand light-years distant though, still well within our own Milky Way galaxy. Named for its discoverer and re-discoverers, this faint periodic comet was first sighted in 1858 and not again until 1907 and 1951. Matching orbit calculations indicated that the same comet had been observed at widely separated times.  Nearing its best apparition and closest approach to Earth in over 100 years on April 1, comet 41P orbits the Sun with a period of about 5.4 years.', 'image', '1490893512.jpg', '1490893513.jpg', '2017-03-24'),
(51, 'Ganymede\'s Shadow', 'Approaching opposition early next month, Jupiter is offering some of its best telescopic views from planet Earth. On March 17, this impressively sharp image of the solar system\'s ruling gas giant was taken from a remote observatory in Chile. Bounded by planet girdling winds, familiar dark belts and light zones span the giant planet spotted with rotating oval storms. The solar system\'s largest moon Ganymede is above and left in the frame, its shadow seen in transit across the northern Jovian cloud tops. Ganymede itself is seen in remarkable detail along with bright surface features on fellow Galilean moon Io, right of Jupiter\'s looming disk.', 'image', '1490893523.jpg', '1490893524.jpg', '2017-03-25'),
(52, 'Tardigrade in Moss', 'Is this an alien?  Probably not, but of all the animals on Earth, the tardigrade might be the best candidate. That\'s because tardigrades are known to be able to go for decades without food or water, to survive temperatures from near absolute zero to well above the boiling point of water, to survive pressures from near zero to well above that on ocean floors, and to survive direct exposure to dangerous radiations.  The far-ranging survivability of these extremophiles was tested in 2011 outside an orbiting space shuttle. Tardigrades are so durable partly because they can repair their own DNA and reduce their body water content to a few percent. Some of these miniature water-bears almost became  extraterrestrials recently when they were launched toward to the Martian moon Phobos on board the Russian mission Fobos-Grunt, but stayed terrestrial when a rocket failed and the capsule remained in Earth orbit.  Tardigrades are more common than humans across most of the Earth. Pictured here in a color-enhanced electron micrograph, a millimeter-long tardigrade crawls on moss.', 'image', '1490893536.jpg', '1490893537.jpg', '2017-03-26'),
(53, 'Black Hole Accreting with Jet', 'What happens when a black hole devours a star?  Many details remain unknown, but recent observations are providing new clues. In 2014, a powerful explosion was recorded by the ground-based robotic telescopes of the All Sky Automated Survey for SuperNovae (ASAS-SN) project, and followed up by instruments including NASA\'s Earth-orbiting Swift satellite. Computer modeling of these emissions fit a star being ripped apart by a distant supermassive black hole.  The results of such a collision are portrayed in the featured artistic illustration. The black hole itself is a depicted as a tiny black dot in the center. As matter falls toward the hole, it collides with other matter and heats up. Surrounding the black hole is an accretion disk of hot matter that used to be the star, with a jet emanating from the black hole\'s spin axis.', 'image', '1490893548.jpg', '1490893549.jpg', '2017-03-27'),
(54, 'King of Wings Hoodoo under the Milky Way', 'This rock structure is not only surreal -- it\'s real.  The reason it\'s not more famous is that it is, perhaps, smaller than one might guess: the capstone rock overhangs only a few meters.  Even so, the King of Wings outcrop, located in New Mexico, USA, is a fascinating example of an unusual type of rock structure called a hoodoo. Hoodoos may form when a layer of hard rock overlays a layer of eroding softer rock. Figuring out the details of incorporating this hoodoo into a night-sky photoshoot took over a year. Besides waiting for a suitably picturesque night behind a sky with few clouds, the foreground had to be artificially lit just right relative to the natural glow of the background.  After much planning and waiting, the final shot, featured here, was taken in May 2016. Mimicking the horizontal bar, the background sky features the band of our Milky Way Galaxy stretching overhead.', 'image', '1490893565.jpg', '1490893566.jpg', '2017-03-28'),
(55, 'Nebula with Laser Beams', 'Four laser beams cut across this startling image of the Orion Nebula, as seen from ESO\'s Paranal Observatory in the Atacama desert on planet Earth. Not part of an interstellar conflict, the lasers are being used for an observation of Orion by UT4, one of the observatory\'s very large telescopes, in a technical test of an image-sharpening adaptive optics system. This view of the nebula with laser beams was captured by a small telescope from outside the UT4 enclosure. The beams are visible from that perspective because in the first few kilometers above the observatory the Earth\'s dense lower atmosphere scatters the laser light. The four small segments appearing beyond the beams are emission from an atmospheric layer of sodium atoms excited by the laser light at higher altitudes of 80-90 kilometers. Seen from the perspective of the UT4, those segments form bright spots or artificial guide stars. Their fluctuations are used in real-time to correct for atmospheric blurring along the line-of-sight by controlling a deformable mirror in the telescope\'s optical path.', 'image', '1490893587.jpg', '1490893588.jpg', '2017-03-29'),
(56, 'Young Stars and Dusty Nebulae in Taurus', 'This complex of dusty nebulae lingers along the edge of the Taurus molecular cloud, a mere 450 light-years distant. Stars are forming on the cosmic scene. Composed from almost 40 hours of image data, the 2 degree wide telescopic field of view includes some youthful T-Tauri class stars embedded in the remnants of their natal clouds at the right. Millions of years old and still going through stellar adolescence, the stars are variable in brightness and in the late phases of their gravitational collapse. Their core temperatures will rise to sustain nuclear fusion as they grow into stable, low mass, main sequence stars, a stage of stellar evolution achieved by our middle-aged Sun about 4.5 billion years ago. Another youthful variable star, V1023 Tauri, can be spotted on the left. Within its yellowish dust cloud, it lies next to the striking blue reflection nebula Cederblad 30, also known as LBN 782. Just above the bright bluish reflection nebula is dusty dark nebula Barnard 7.', 'image', '1490893600.jpg', '1490893602.jpg', '2017-03-30');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `description` longtext NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `google_connected` varchar(255) NOT NULL DEFAULT '0',
  `is_master` int(11) NOT NULL DEFAULT '0',
  `is_pro` int(11) NOT NULL DEFAULT '0',
  `has_one` int(11) NOT NULL DEFAULT '0',
  `has_two` int(11) NOT NULL DEFAULT '0',
  `has_three` int(11) NOT NULL DEFAULT '0',
  `has_four` int(11) NOT NULL DEFAULT '0',
  `has_five` int(11) NOT NULL DEFAULT '0',
  `has_six` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
