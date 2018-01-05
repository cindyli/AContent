<?php
/************************************************************************/
/* AContent                                                             */
/************************************************************************/
/* Copyright (c) 2010                                                   */
/* Inclusive Design Institute                                           */
/*                                                                      */
/* This program is free software. You can redistribute it and/or        */
/* modify it under the terms of the GNU General Public License          */
/* as published by the Free Software Foundation.                        */
/************************************************************************/

/**
 * DAO for "patches_files" table
 * @access	public
 * @author	Cindy Qi Li
 * @package	DAO
 */

if (!defined('TR_INCLUDE_PATH')) exit;

require_once(TR_INCLUDE_PATH. 'classes/DAO/DAO.class.php');

class PatchesFilesDAO extends DAO {

	/**
	 * Create new row
	 * @access  public
	 * @param   patch_id, action, $name, $location
	 * @return  patches_files_id, if successful
	 *          false and add error into global var $msg, if unsuccessful
	 * @author  Cindy Qi Li
	 */
	public function Create($patch_id, $action, $name, $location)
	{

        $sql = "INSERT INTO " . TABLE_PREFIX. "patches_files " .
                 "(patches_id, 
                   action,
                   name,
                   location)
                  VALUES (?,?,?,?)";	
        $values = array($patch_id, $action, $name, $location);
        $types = "isss";
		if (!$this->execute($sql, $values, $types))
		{
			$msg->addError('DB_NOT_UPDATED');
			return false;
		}
		else
		{
			return $this->ac_insert_id();
		}
	}

	/**
	 * Return number of times that the given file have been updated by Updater
	 * @access  public
	 * @param   $file: file name
	 * @return  number of times
	 * @author  Cindy Qi Li
	 */
	public function getNumOfUpdatesOnFile($file)
	{

		$sql = "SELECT count(*) num_of_updates FROM " . TABLE_PREFIX. "patches patches, " . TABLE_PREFIX."patches_files patches_files " .
			       "WHERE patches.applied_version = '" . VERSION . "' ".
			       "  AND patches.status = 'Installed' " .
			       "  AND patches.patches_id = patches_files.patches_id " .
			       "  AND patches_files.name = ?";	
		$values = 	$file;
		$types = "s";
		return $this->execute($sql, $values, $types);
	}		
}
?>