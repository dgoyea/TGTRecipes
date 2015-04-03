<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */

// no direct access
defined('_JEXEC') or die;
//Zur zeit nur eine sammlung von Feldern die hinzugefügt werden müssen für Joomla version 2.5
//Datum zeit reihenfolge ist wichtig
//ALTER TABLE`g1t9u_garyscookbook`ADD`created` DATETIME NOT NULL AFTER`imgdate`  DEFAULT'0000-00-00 00:00:00'
//UPDATE `g1t9u_garyscookbook`SET`created`= FROM_UNIXTIME(`imgdate`)
//ALTER TABLE`g1t9u_garyscookbook`DROP`imgdate`

//Neue Felder
//ALTER TABLE`g1t9u_garyscookbook`ADD`featured` TINYINT( 3)NOT NULL DEFAULT '0'
//ALTER TABLE`g1t9u_garyscookbook`ADD`language` CHAR( 7)NOT NULL DEFAULT '*'
//ALTER TABLE`g1t9u_garyscookbook`ADD`publish_up` DATETIME NOT NULL DEFAULT'0000-00-00 00:00:00', ADD`publish_down` DATETIME NOT NULL DEFAULT'0000-00-00 00:00:00'
//ALTER TABLE`g1t9u_garyscookbook`ADD`params` TEXT NOTNULLAFTER`ordering`
//ALTER TABLE`g1t9u_garyscookbook`ADD`default_con` TINYINT( 1)NOTNULLAFTER`published`
//ALTER TABLE`g1t9u_garyscookbook`ADD`modified` DATETIME NOTNULLAFTER`created_by`
//ALTER TABLE`g1t9u_garyscookbook`ADD`modified_by` INT( 10)NOTNULLAFTER`modified`
//ALTER TABLE`g1t9u_garyscookbook`CHANGE`expic1``expic1` VARCHAR( 200)CHARACTERSET latin1 COLLATE latin1_german2_ci NULLDEFAULT NULL
//ALTER TABLE`g1t9u_garyscookbook`CHANGE`expic2``expic2` VARCHAR( 200)CHARACTERSET latin1 COLLATE latin1_german2_ci NULLDEFAULT NULL
//ALTER TABLE`g1t9u_garyscookbook`CHANGE`expic3``expic3` VARCHAR( 200)CHARACTERSET latin1 COLLATE latin1_german2_ci NULLDEFAULT NULL
//ALTER TABLE`g1t9u_garyscookbook`CHANGE`expic4``expic4` VARCHAR( 200)CHARACTERSET latin1 COLLATE latin1_german2_ci NULLDEFAULT NULL
// ALTER TABLE`g1t9u_garyscookbook`ADD`created_by_alias` VARCHAR( 255)CHARACTERSET utf8 COLLATE utf8_general_ci NOTNULLAFTER`created_by`
//UPDATE`gkb25`.`g1t9u_garyscookbook`SET`access`='1'
// Die Tabelle g1t9u_garyscookbook wurde erfolgreich geändert
//ALTER TABLE`g1t9u_garyscookbook`ADD`used_ips` VARCHAR( 15)NOT NULL AFTER`imgvotesum`
?>