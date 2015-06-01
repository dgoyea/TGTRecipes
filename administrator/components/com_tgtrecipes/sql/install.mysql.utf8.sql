CREATE TABLE IF NOT EXISTS `#__tgtrecipes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `catid` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `ingredients` text,
  `directions` text,
  `ingredient1` varchar(255) DEFAULT NULL,
  `ingredient2` varchar(255) DEFAULT NULL,
  `ingredient3` varchar(255) DEFAULT NULL,
  `ingredient4` varchar(255) DEFAULT NULL,
  `ingredient5` varchar(255) DEFAULT NULL,
  `ingredient6` varchar(255) DEFAULT NULL,
  `ingredient7` varchar(255) DEFAULT NULL,
  `ingredient8` varchar(255) DEFAULT NULL,
  `ingredient9` varchar(255) DEFAULT NULL,
  `ingredient10` varchar(255) DEFAULT NULL,
  `ingredient11` varchar(255) DEFAULT NULL,
  `ingredient12` varchar(255) DEFAULT NULL,
  `ingredient13` varchar(255) DEFAULT NULL,
  `ingredient14` varchar(255) DEFAULT NULL,
  `ingredient15` varchar(255) DEFAULT NULL,
  `ingredient16` varchar(255) DEFAULT NULL,
  `ingredient17` varchar(255) DEFAULT NULL,
  `ingredient18` varchar(255) DEFAULT NULL,
  `ingredient19` varchar(255) DEFAULT NULL,
  `ingredient20` varchar(255) DEFAULT NULL,
  `ingredient21` varchar(255) DEFAULT NULL,
  `ingredient22` varchar(255) DEFAULT NULL,
  `ingredient23` varchar(255) DEFAULT NULL,
  `ingredient24` varchar(255) DEFAULT NULL,
  `ingredient25` varchar(255) DEFAULT NULL,
  `ingrqty1` int(10) DEFAULT NULL,
  `ingrqty2` int(10) DEFAULT NULL,
  `ingrqty3` int(10) DEFAULT NULL,
  `ingrqty4` int(10) DEFAULT NULL,
  `ingrqty5` int(10) DEFAULT NULL,
  `ingrqty6` int(10) DEFAULT NULL,
  `ingrqty7` int(10) DEFAULT NULL,
  `ingrqty8` int(10) DEFAULT NULL,
  `ingrqty9` int(10) DEFAULT NULL,
  `ingrqty10` int(10) DEFAULT NULL,
  `ingrqty11` int(10) DEFAULT NULL,
  `ingrqty12` int(10) DEFAULT NULL,
  `ingrqty13` int(10) DEFAULT NULL,
  `ingrqty14` int(10) DEFAULT NULL,
  `ingrqty15` int(10) DEFAULT NULL,
  `ingrqty16` int(10) DEFAULT NULL,
  `ingrqty17` int(10) DEFAULT NULL,
  `ingrqty18` int(10) DEFAULT NULL,
  `ingrqty19` int(10) DEFAULT NULL,
  `ingrqty20` int(10) DEFAULT NULL,
  `ingrqty21` int(10) DEFAULT NULL,
  `ingrqty22` int(10) DEFAULT NULL,
  `ingrqty23` int(10) DEFAULT NULL,
  `ingrqty24` int(10) DEFAULT NULL,
  `ingrqty25` int(10) DEFAULT NULL,
  `ingrqtytype1` varchar(255) DEFAULT NULL,
  `ingrqtytype2` varchar(255) DEFAULT NULL,
  `ingrqtytype3` varchar(255) DEFAULT NULL,
  `ingrqtytype4` varchar(255) DEFAULT NULL,
  `ingrqtytype5` varchar(255) DEFAULT NULL,
  `ingrqtytype6` varchar(255) DEFAULT NULL,
  `ingrqtytype7` varchar(255) DEFAULT NULL,
  `ingrqtytype8` varchar(255) DEFAULT NULL,
  `ingrqtytype9` varchar(255) DEFAULT NULL,
  `ingrqtytype10` varchar(255) DEFAULT NULL,
  `ingrqtytype11` varchar(255) DEFAULT NULL,
  `ingrqtytype12` varchar(255) DEFAULT NULL,
  `ingrqtytype13` varchar(255) DEFAULT NULL,
  `ingrqtytype14` varchar(255) DEFAULT NULL,
  `ingrqtytype15` varchar(255) DEFAULT NULL,
  `ingrqtytype16` varchar(255) DEFAULT NULL,
  `ingrqtytype17` varchar(255) DEFAULT NULL,
  `ingrqtytype18` varchar(255) DEFAULT NULL,
  `ingrqtytype19` varchar(255) DEFAULT NULL,
  `ingrqtytype20` varchar(255) DEFAULT NULL,
  `ingrqtytype21` varchar(255) DEFAULT NULL,
  `ingrqtytype22` varchar(255) DEFAULT NULL,
  `ingrqtytype23` varchar(255) DEFAULT NULL,
  `ingrqtytype24` varchar(255) DEFAULT NULL,
  `ingrqtytype25` varchar(255) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;