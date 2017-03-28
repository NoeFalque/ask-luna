-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mar 28 Mars 2017 à 16:59
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

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `content`, `parent_id`, `score`, `misunderstand`, `date`, `user_id`) VALUES
(27, 20, 'What is a hole?', 0, 0, 0, '2017-03-28 16:29:09', 2),
(28, 20, 'It is dark!', 27, 0, 1, '2017-03-28 16:29:56', 2);

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

--
-- Contenu de la table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `is_seen`, `message`, `url`, `date`) VALUES
(4, 2, 1, 'greg has upvoted your question.', 'http://localhost:8888/picture-of-the-day/20#27', '2017-03-28 16:29:25'),
(5, 2, 1, 'greg replied to your message.', 'http://localhost:8888/picture-of-the-day/20#27', '2017-03-28 16:29:56'),
(6, 2, 1, 'greg didn\'t understand your answer.', 'http://localhost:8888/picture-of-the-day/20#28', '2017-03-28 16:30:05');

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
(20, 'Black Hole Accreting with Jet', 'What happens when a black hole devours a star?  Many details remain unknown, but recent observations are providing new clues. In 2014, a powerful explosion was recorded by the ground-based robotic telescopes of the All Sky Automated Survey for SuperNovae (ASAS-SN) project, and followed up by instruments including NASA\'s Earth-orbiting Swift satellite. Computer modeling of these emissions fit a star being ripped apart by a distant supermassive black hole.  The results of such a collision are portrayed in the featured artistic illustration. The black hole itself is a depicted as a tiny black dot in the center. As matter falls toward the hole, it collides with other matter and heats up. Surrounding the black hole is an accretion disk of hot matter that used to be the star, with a jet emanating from the black hole\'s spin axis.', 'image', '1490629177.jpg', '1490629178.jpg', '2017-03-27'),
(21, 'Tardigrade in Moss', 'Is this an alien?  Probably not, but of all the animals on Earth, the tardigrade might be the best candidate. That\'s because tardigrades are known to be able to go for decades without food or water, to survive temperatures from near absolute zero to well above the boiling point of water, to survive pressures from near zero to well above that on ocean floors, and to survive direct exposure to dangerous radiations.  The far-ranging survivability of these extremophiles was tested in 2011 outside an orbiting space shuttle. Tardigrades are so durable partly because they can repair their own DNA and reduce their body water content to a few percent. Some of these miniature water-bears almost became  extraterrestrials recently when they were launched toward to the Martian moon Phobos on board the Russian mission Fobos-Grunt, but stayed terrestrial when a rocket failed and the capsule remained in Earth orbit.  Tardigrades are more common than humans across most of the Earth. Pictured here in a color-enhanced electron micrograph, a millimeter-long tardigrade crawls on moss.', 'image', '1490629194.jpg', '1490629195.jpg', '2017-03-26'),
(22, 'Ganymede\'s Shadow', 'Approaching opposition early next month, Jupiter is offering some of its best telescopic views from planet Earth. On March 17, this impressively sharp image of the solar system\'s ruling gas giant was taken from a remote observatory in Chile. Bounded by planet girdling winds, familiar dark belts and light zones span the giant planet spotted with rotating oval storms. The solar system\'s largest moon Ganymede is above and left in the frame, its shadow seen in transit across the northern Jovian cloud tops. Ganymede itself is seen in remarkable detail along with bright surface features on fellow Galilean moon Io, right of Jupiter\'s looming disk.', 'image', '1490629204.jpg', '1490629205.jpg', '2017-03-25'),
(23, 'The Comet, the Owl, and the Galaxy', 'Comet 41P/Tuttle-Giacobini-Kresak poses for a Messier moment in this telescopic snapshot from March 21. In fact it shares the 1 degree wide field-of-view with two well-known entries in the 18th century comet-hunting astronomer\'s famous catalog. Sweeping through northern springtime skies just below the Big Dipper, the faint greenish comet was about 75 light-seconds from our fair planet. Dusty, edge-on spiral galaxy Messier 108 (bottom center) is more like 45 million light-years away. At upper right, the planetary nebula with an aging but intensely hot central star, the owlish Messier 97 is only about 12 thousand light-years distant though, still well within our own Milky Way galaxy. Named for its discoverer and re-discoverers, this faint periodic comet was first sighted in 1858 and not again until 1907 and 1951. Matching orbit calculations indicated that the same comet had been observed at widely separated times.  Nearing its best apparition and closest approach to Earth in over 100 years on April 1, comet 41P orbits the Sun with a period of about 5.4 years.', 'image', '1490629211.jpg', '1490629212.jpg', '2017-03-24'),
(24, 'SH2-155: The Cave Nebula', 'This skyscape features dusty Sharpless catalog emission region Sh2-155, the Cave Nebula. In the telescopic image, data taken through a narrowband filter tracks the reddish glow of ionized hydrogen atoms. About 2,400 light-years away, the scene lies along the plane of our Milky Way Galaxy toward the royal northern constellation of Cepheus. Astronomical explorations of the region reveal that it has formed at the boundary of the massive Cepheus B molecular cloud and the hot, young stars of the Cepheus OB 3 association. The bright rim of ionized hydrogen gas is energized by radiation from the hot stars, dominated by the brightest star above and left of picture center. Radiation driven ionization fronts are likely triggering collapsing cores and new star formation within. Appropriately sized for a stellar nursery, the cosmic cave is over 10 light-years across.', 'image', '1490629233.jpg', '1490629235.jpg', '2017-03-23'),
(25, 'Central Cygnus Skyscape', 'In cosmic brush strokes of glowing hydrogen gas, this beautiful skyscape unfolds across the plane of our Milky Way Galaxy near the northern end of the Great Rift and the center of the constellation Cygnus the Swan. A 36 panel mosaic of telescopic image data, the scene spans about six degrees. Bright supergiant star Gamma Cygni (Sadr) to the upper left of the image center lies in the foreground of the complex gas and dust clouds and crowded star fields. Left of Gamma Cygni, shaped like two luminous wings divided by a long dark dust lane is IC 1318 whose popular name is understandably the Butterfly Nebula. The more compact, bright nebula at the lower right is NGC 6888, the Crescent Nebula. Some distance estimates for Gamma Cygni place it at around 1,800 light-years while estimates for IC 1318 and NGC 6888 range from 2,000 to 5,000 light-years.', 'image', '1490629244.jpg', '1490629246.jpg', '2017-03-22'),
(26, 'Fast Stars and Rogue Planets in the Orion Nebula', 'Start with the constellation of Orion.  Below Orion\'s belt is a fuzzy area known as the Great Nebula of Orion.  In this nebula is a bright star cluster known as the Trapezium, marked by four bright stars near the image center. The newly born stars in the Trapezium and surrounding regions show the Orion Nebula to be one of the most active areas of star formation to be found in our area of the Galaxy. In Orion, supernova explosions and close interactions between stars have created rogue planets and stars that rapidly move through space. Some of these fast stars have been found by comparing different images of this region taken by the Hubble Space Telescope many years apart. Many of the stars in the featured image, taken in visible and near-infrared light, appear unusually red because they are seen through dust that scatters away much of their blue light.', 'image', '1490629255.jpg', '1490629256.jpg', '2017-03-21'),
(27, 'The Aurora Tree', 'Yes, but can your tree do this?  Pictured is a visual coincidence between the dark branches of a nearby tree and bright glow of a distant aurora. The beauty of the aurora -- combined with how it seemed to mimic a tree right nearby -- mesmerized the photographer to such a degree that he momentarily forgot to take pictures. When viewed at the right angle, it seemed that this tree had aurora for leaves! Fortunately, before the aurora morphed into a different overall shape, he came to his senses and capture the awe-inspiring momentary coincidence.  Typically triggered by solar explosions, aurora are caused by high energy electrons impacting the Earth\'s atmosphere around 150 kilometers up.  The unusual Earth-sky collaboration was witnessed earlier this month in Iceland.    Follow APOD on: Facebook,  Google Plus,  Instagram, or Twitter', 'image', '1490629264.jpg', '1490629266.jpg', '2017-03-20'),
(28, 'Equinox on a Spinning Earth', 'When does the line between day and night become vertical? Tomorrow. Tomorrow is an equinox on planet Earth, a time of year when day and night are most nearly equal. At an equinox, the Earth\'s terminator -- the dividing line between day and night -- becomes vertical and connects the north and south poles. The featured time-lapse video demonstrates this by displaying an entire year on planet Earth in twelve seconds. From geosynchronous orbit, the Meteosat satellite recorded these infrared images of the Earth every day at the same local time.  The video started at the September 2010 equinox with the terminator line being vertical. As the Earth revolved around the Sun, the terminator was seen to tilt in a way that provides less daily sunlight to the northern hemisphere, causing winter in the north. As the year progressed, the March 2011 equinox arrived halfway through the video, followed by the terminator tilting the other way, causing winter in the southern hemisphere -- and summer in the north. The captured year ends again with the September equinox, concluding another of billions of trips the Earth has taken -- and will take -- around the Sun.', 'video', 'https://www.youtube.com/embed/LUW51lvIFjg?rel=0&showinfo=0', '', '2017-03-19'),
(29, 'JWST: Ghosts and Mirrors', 'Ghosts aren\'t actually hovering over the James Webb Space Telescope. But the lights are out as it stands with gold tinted mirror segments and support structures folded in Goddard Space Flight Center\'s Spacecraft Systems Development and Integration Facility clean room. Following vibration and acoustic testing, bright flashlights and ultraviolet lights are played over the stationary telescope looking for contamination, easier to spot in a darkened room. In the dimness the camera\'s long exposure creates the ghostly apparitions, blurring the moving lights and engineers. A scientific successor to Hubble, the James Webb Space Telescope is optimized for the infrared exploration of the early Universe. Its planned launch is in 2018 from French Guiana on a European Space Agency Ariane 5 rocket.', 'image', '1490629313.jpg', '1490629314.jpg', '2017-03-18'),
(30, 'Phases of Venus', 'Just as the Moon goes through phases, Venus\' visible sunlit hemisphere waxes and wanes. This composite of telescopic images illustrates the steady changes for the inner planet, seen in the west as the evening star, as Venus grows larger but narrows to a thin crescent from December 20, 2016 through March 10. Gliding along its interior orbit between Earth and Sun, Venus grows larger during that period because it is approaching planet Earth. Its crescent narrows, though, as Venus swings closer to our line-of-sight to the Sun. Closest to the Earth-Sun line but passing about 8 degrees north of the Sun on March 25, Venus will reach a (non-judgmental) inferior conjunction. Soon after, Venus will shine clearly above the eastern horizon in predawn skies as planet Earth\'s morning star.', 'image', '1490629321.jpg', '1490629322.jpg', '2017-03-17'),
(31, 'Mimas in Saturnlight', 'Peering from the shadows, the Saturn-facing hemisphere of Mimas lies in near darkness alongside a dramatic sunlit crescent. The mosaic was captured near the Cassini spacecraft\'s final close approach on January 30, 2017. Cassini\'s camera was pointed in a nearly sunward direction only 45,000 kilometers from Mimas. The result is one of the highest resolution views of the icy, crater-pocked, 400 kilometer diameter moon. An enhanced version better reveals the Saturn-facing hemisphere of the synchronously rotating moon lit by sunlight reflected from Saturn itself. To see it, slide your cursor over the image (or follow this link). Other Cassini images of Mimas include the small moon\'s large and ominous Herschel Crater.', 'image', '1490629328.jpg', '1490629329.jpg', '2017-03-16'),
(32, 'The Cone Nebula from Hubble', 'Stars are forming in the gigantic dust pillar called the Cone Nebula. Cones, pillars, and majestic flowing shapes abound in stellar nurseries where natal clouds of gas and dust are buffeted by energetic winds from newborn stars. The Cone Nebula, a well-known example, lies within the bright galactic star-forming region NGC 2264. The Cone was captured in unprecedented detail in this close-up composite of several observations from the Earth-orbiting Hubble Space Telescope. While the Cone Nebula, about 2,500 light-years away in Monoceros, is around 7 light-years long, the region pictured here surrounding the cone\'s blunted head is a mere 2.5 light-years across. In our neck of the galaxy that distance is just over half way from our Sun to its nearest stellar neighbors in the Alpha Centauri star system. The massive star NGC 2264 IRS, seen by Hubble\'s infrared camera in 1997, is the likely source of the wind sculpting the Cone Nebula and lies off the top of the image. The Cone Nebula\'s reddish veil is produced by glowing hydrogen gas.', 'image', '1490629335.jpg', '1490629336.jpg', '2017-03-15'),
(33, 'A Dark Winter Sky over Monfragüe National Park in Spain', 'You, too, can see a night sky like this. That is because Monfragüe National Park in Spain, where this composite image was created, has recently had its night sky officially protected from potential future light pollution.  Icons of the night sky that should continue to stand out during northern winter -- and are visible on the featured image -- include very bright stars like Sirius, Betelgeuse, and Procyon, bright star clusters like the Pleiades, and, photographically, faint nebulas like the California and Rosette Nebulas.  Even 100 years ago, many people were more familiar with a darker night sky than people today, primarily because of the modern light pollution.  Other parks that have been similarly protected as dark-sky preserves include Death Valley National Park (USA) and Grasslands National Park (Canada). Areas such as the city of Flagstaff, Arizona and much of the Big Island of Hawaii also have their night skies protected.', 'image', '1490629347.jpg', '1490629350.jpg', '2017-03-14'),
(34, 'Saturn\'s Moon Pan from Cassini', 'Why does Saturn\'s moon Pan look so odd? Images taken last week from the robotic Cassini spacecraft orbiting Saturn have resolved the moon in unprecedented detail.  The surprising images reveal a moon that looks something like a walnut with a slab through its middle.  Other visible features on Pan include rolling terrain, long ridges, and a few craters. Spanning 30-kilometer across, Pan orbits inside the 300-kilometer wide Encke Gap of Saturn\'s expansive A-ring, a gap known since the late 1800s.  Next month, Cassini will be directed to pass near Saturn\'s massive moon Titan so it can be pulled into a final series of orbits that will take it, on occasion, completely inside Saturn\'s rings and prepare it to dive into Saturn\'s atmosphere.', 'image', '1490629365.jpg', '1490629366.jpg', '2017-03-13'),
(35, 'At the Heart of Orion', 'Near the center of this sharp cosmic portrait, at the heart of the Orion Nebula, are four hot, massive stars known as the Trapezium. Tightly gathered within a region about 1.5 light-years in radius, they dominate the core of the dense Orion Nebula Star Cluster. Ultraviolet ionizing radiation from the Trapezium stars, mostly from the brightest star Theta-1 Orionis C powers the complex star forming region\'s entire visible glow. About three million years old, the Orion Nebula Cluster was even more compact in its younger years and a dynamical study indicates that runaway stellar collisions at an earlier age may have formed a black hole with more than 100 times the mass of the Sun. The presence of a black hole within the cluster could explain the observed high velocities of the Trapezium stars. The Orion Nebula\'s distance of some 1,500 light-years would make it the closest known black hole to planet Earth.', 'image', '1490629372.jpg', '1490629373.jpg', '2017-03-12'),
(36, 'Reflections on vdB 31', 'Riding high in the constellation of Auriga, beautiful, blue vdB 31 is the 31st object in Sidney van den Bergh\'s 1966 catalog of reflection nebulae. It shares this well-composed celestial still life with dark, obscuring clouds recorded in Edward E. Barnard\'s 1919 catalog of dark markings in the sky. All are interstellar dust clouds, blocking the light from background stars in the case of Barnard\'s dark nebulae. For vdB 31, the dust preferentially reflects the bluish starlight from embedded, hot, variable star AB Aurigae. Exploring the environs of AB Aurigae with the Hubble Space Telescope has revealed the several million year young star is itself surrounded by flattened dusty disk with evidence for the ongoing formation of a planetary system. AB Aurigae is about 470 light-years away. At that distance this cosmic canvas would span about four light-years.', 'image', '1490629380.jpg', '1490629381.jpg', '2017-03-11'),
(37, 'Galaxy Cluster Abell 2666', 'The galaxies of Abell 2666 lie far beyond the Milky Way, some 340 million light-years distant toward the high flying constellation Pegasus. Framed in this sharp telescopic image, the pretty cluster galaxies are gathered behind scattered, spiky, Milky Way stars. At cluster center is giant elliptical galaxy NGC 7768, the central dominant galaxy of the cluster. As the cluster forms, such massive galaxies are thought to grow by mergers of galaxies that fall through the center of the cluster\'s gravitational well. Typical of dominant cluster galaxies, NGC 7768 likely harbors a supermassive black hole. At the estimated distance of Abell 2666, this cosmic frame would span about 5 million light-years.', 'image', '1490629388.jpg', '1490629389.jpg', '2017-03-10'),
(38, 'King of Wings Hoodoo under the Milky Way', 'This rock structure is not only surreal -- it\'s real.  The reason it\'s not more famous is that it is, perhaps, smaller than one might guess: the capstone rock overhangs only a few meters.  Even so, the King of Wings outcrop, located in New Mexico, USA, is a fascinating example of an unusual type of rock structure called a hoodoo. Hoodoos may form when a layer of hard rock overlays a layer of eroding softer rock. Figuring out the details of incorporating this hoodoo into a night-sky photoshoot took over a year. Besides waiting for a suitably picturesque night behind a sky with few clouds, the foreground had to be artificially lit just right relative to the natural glow of the background.  After much planning and waiting, the final shot, featured here, was taken in May 2016. Mimicking the horizontal bar, the background sky features the band of our Milky Way Galaxy stretching overhead.', 'image', '1490678076.jpg', '1490678079.jpg', '2017-03-28');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `is_master` int(11) NOT NULL DEFAULT '0',
  `is_pro` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `picture`, `is_master`, `is_pro`) VALUES
(2, 'greg', '9649c12fea9208e65de14ae92db0dbc6e47cdfc6c6145f535e30f3268cb945e5', 'gregoiremielle@gmail.com', '2017-03-27 14:51:45', '1490625848.png', 0, 0);

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
-- Contenu de la table `votes`
--

INSERT INTO `votes` (`id`, `content_type`, `user_id`, `content_type_id`, `type`) VALUES
(79, 'comments', 2, 28, 'misunderstand');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
