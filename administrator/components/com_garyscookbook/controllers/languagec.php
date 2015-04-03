<?php
/**
 * @package		Garyscookbook.Admin
 * @subpackage	com_garyscookbook
 * @copyright	Copyright (C) 2005 - 2014 Web and Edv Service Gerald Berger, Ove Eriksson, Jens Straube. All rights reserved.
 * @license		GNU General Public License version 2 or later;
 *
 */
//languagefiles copy Controller
defined('_JEXEC') or die('Restricted access');

class GaryscookbookControllerLanguagec extends JControllerLegacy {

	function save() {

		JRequest::checkToken() or jexit( 'Invalid Token' );
		$extension = 'com_garyscookbook';
		$jform = JRequest::getVar('jform', '');

		if ($jform['langfrom'] == $jform['langto'] || !$jform['langfrom'] || !$jform['langto']) {
			JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_COPIED', $topath));
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=languages&extension=com_garyscoobook', false));

			return false;
		}

		$app = JFactory::getApplication();

		//copy frontendfile
		$frompath = JPATH_SITE.'/language/'.$jform['langfrom'].'/'.$jform['langfrom'].'.'.$extension.'.ini';
		$topath = JPATH_SITE.'/language/'.$jform['langto'].'/'.$jform['langto'].'.'.$extension.'.ini';

		if (!JFile::exists($frompath)) {
			JError::raiseNotice( 100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_EXISTS',$frompath) );
		} else {
			if (JFile::exists($topath)) {
				JError::raiseNotice( 100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_EXISTS',$topath) );
				if (isset($jform['override'])) {
					if (!$result = JFile::delete($topath)) {
						JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_DELETED', $topath));
					} else {
						if ($result = JFile::copy($frompath, $topath)) {
							$app->enqueueMessage( JText::sprintf('COM_GARYSCOOKBOOK_FILE_COPIED', $topath),'message');
						} else {
							JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_COPIED', $topath));
						}
					}
				}
			} else {
				if ($result = JFile::copy($frompath, $topath)) {
					$app->enqueueMessage( JText::sprintf('COM_GARYSCOOKBOOK_FILE_COPIED', $topath),'message');
				} else {
					JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_COPIED', $topath));
				}
			}
		}

		//copy backendfile


		$frompath = JPATH_ADMINISTRATOR.'/language/'.$jform['langfrom'].'/'.$jform['langfrom'].'.'.$extension.'.ini';
		$topath = JPATH_ADMINISTRATOR.'/language/'.$jform['langto'].'/'.$jform['langto'].'.'.$extension.'.ini';

			if (!JFile::exists($frompath)) {
				JError::raiseNotice( 100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_EXISTS',$frompath) );
			} else {
				if (JFile::exists($topath)) {
					JError::raiseNotice( 100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_EXISTS',$topath) );
					if (isset($jform['override'])) {
						if (!$result = JFile::delete($topath)) {
							JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_DELETED', $topath));
						} else {
							if ($result = JFile::copy($frompath, $topath)) {
								$app->enqueueMessage( JText::sprintf('COM_GARYSCOOKBOOK_FILE_COPIED', $topath),'message');
							} else {
								JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_COPIED', $topath));
							}
						}
					}
				} else {
					if ($result = JFile::copy($frompath, $topath)) {
						$app->enqueueMessage( JText::sprintf('COM_GARYSCOOKBOOK_FILE_COPIED', $topath),'message');
					} else {
						JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_COPIED', $topath));
					}
				}
			}

		//copy backend sys file

			$frompath = JPATH_ADMINISTRATOR.'/language/'.$jform['langfrom'].'/'.$jform['langfrom'].'.'.$extension.'.sys.ini';
			$topath = JPATH_ADMINISTRATOR.'/language/'.$jform['langto'].'/'.$jform['langto'].'.'.$extension.'.sys.ini';

			if (!JFile::exists($frompath)) {
				JError::raiseNotice( 100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_EXISTS',$frompath) );
			} else {
				if (JFile::exists($topath)) {
					JError::raiseNotice( 100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_EXISTS',$topath) );
					if (isset($jform['override'])) {
						if (!$result = JFile::delete($topath)) {
							JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_DELETED', $topath));
						} else {
							if ($result = JFile::copy($frompath, $topath)) {
								$app->enqueueMessage( JText::sprintf('COM_GARYSCOOKBOOK_FILE_COPIED', $topath),'message');
							} else {
								JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_COPIED', $topath));
							}
						}
					}
				} else {
					if ($result = JFile::copy($frompath, $topath)) {
						$app->enqueueMessage( JText::sprintf('COM_GARYSCOOKBOOK_FILE_COPIED', $topath),'message');
					} else {
						JError::raiseWarning(100, JText::sprintf('COM_GARYSCOOKBOOK_FILE_NOT_COPIED', $topath));
					}
				}
			}

		$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=languages&extension=com_garyscoobook', false));
		return ;
	}

	function cancel() {
			$this->setRedirect(JRoute::_('index.php?option=com_garyscookbook&view=languages&extension=com_garyscoobook', false));
	return ;
}
}