<?php

namespace Lagan\Property;

use \Sirius\Upload\Handler as UploadHandler;

/**
 * Controller for the Lagan Contenttools property.
 * Uses http://getcontenttools.com/
 *
 * A property type controller can contain a set, read, delete and options method. All methods are optional.
 * To be used with Lagan: https://github.com/lutsen/lagan
 */

class Contenttools {

	/**
	 * The set method is executed each time a property with this type is set.
	 *
	 * @param bean		$bean		The Redbean bean object with the property.
	 * @param array		$property	Lagan model property arrray.
	 * @param string	$new_value
	 *
	 * @return string	If a new file is uploaded it returns the new file path relative to APP_PATH. For validation pusposes, if a new file is not uploaded, it returns the current value.
	 */
	public function set($bean, $property, $new_value) {

		if ( $bean->id === 0 ) \R::store( $bean ); // Store new bean to get ID

		// Create directory named like bean id.
		$directory = APP_PATH . $property['directory'] . '/' . $bean->id;
		if ( !file_exists( $directory ) ) {
			mkdir( $directory, 0755, true );
		}

		// TO DO: Check for deleted images on page, so we can delete them from the images directory.

		return $new_value;

	}

	/**
	 * The delete method is executed each time a an object with a property with this type is deleted.
	 *
	 * @param bean		$bean		The Redbean bean object with the property.
	 * @param array		$property	Lagan model property arrray.
	 */
	public function delete($bean, $property) {

		// Delete directory
		$directory = APP_PATH . $property['directory'] . '/' . $bean->id;
		if ( file_exists( $directory ) ) {
			array_map( 'unlink', glob( "$directory/*.*" ) ); // Delete all files in directory
			rmdir( $directory );
		}

	}

}

?>