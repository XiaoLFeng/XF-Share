CREATE TABLE `auth` (
  `id` bigint(20) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `auth` (`id`, `username`, `password`) VALUES ('1','admin','$SHA$e8059c56251214eb$434de2b73e7884c2e2fb270e686ea10397db587159a02d0d73deafbb6090d614');

