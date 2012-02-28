<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: image.php 367 2010-06-04 15:43:10Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

class JWallpapersHelperImage {
	
	
	function createThumb($fileName, $fileExt, $destDir, $type) {
		
		
		$option = 'com_jwallpapers';
		
		$fileAndPath = $destDir . DS . $fileName . "." . $fileExt;
		
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$image_library = $params->get ( 'image_library' );
		$thumbs_resize_method = $params->get ( 'thumbs_resize_method' );
		
		$small_thumbs_width = ( int ) $params->get ( 'small_thumbs_width' );
		$small_thumbs_height = ( int ) $params->get ( 'small_thumbs_height' );
		$big_thumbs_width = ( int ) $params->get ( 'big_thumbs_width' );
		$big_thumbs_height = ( int ) $params->get ( 'big_thumbs_height' );
		$light_thumbs_width = ( int ) $params->get ( 'light_thumbs_width' );
		$light_thumbs_height = ( int ) $params->get ( 'light_thumbs_height' );
		$image_quality = ( int ) $params->get ( 'image_quality' );
		
		if ($image_library == 'Imagick') {
			
			
			$thumb = new Imagick ( $fileAndPath );
			
			
			$width = $thumb->getImageWidth ();
			$height = $thumb->getImageHeight ();
			
			$aspect_ratio = number_format ( $width / $height, 3 );
			
			switch ($type) {
				default :
					$type = 'small';
				
				case 'small' :
					
					$aspect_ratio_thumb = number_format ( $small_thumbs_width / $small_thumbs_height, 3 );
					
					switch ($thumbs_resize_method) {
						case 'noaspect' :
							
							$thumb->thumbnailImage ( $small_thumbs_width, $small_thumbs_height );
							break;
						case 'aspect' :
							
							
							if ($aspect_ratio >= $aspect_ratio_thumb) {
								
								$thumb->thumbnailImage ( $small_thumbs_width, 0 );
							} else {
								
								$thumb->thumbnailImage ( 0, $small_thumbs_height );
							}
							break;
						case 'crop' :
							
							$thumb->cropThumbnailImage ( $small_thumbs_width, $small_thumbs_height );
							break;
					}
					$new_fileName = 'thumb_' . $fileName . '.jpg';
					break;
				case 'big' :
					
					
					
					if ($big_thumbs_height) {
						$aspect_ratio_thumb = number_format ( $big_thumbs_width / $big_thumbs_height, 3 );
						
						
						if ($aspect_ratio >= $aspect_ratio_thumb) {
							
							$thumb->thumbnailImage ( $big_thumbs_width, 0 );
						} else {
							
							$thumb->thumbnailImage ( 0, $big_thumbs_height );
						}
					} else {
						
						$thumb->thumbnailImage ( $big_thumbs_width, 0 );
					}
					$new_fileName = 'big_thumb_' . $fileName . '.jpg';
					break;
				case 'light' :
					
					
					
					if ($light_thumbs_height) {
						$aspect_ratio_thumb = number_format ( $light_thumbs_width / $light_thumbs_height, 3 );
						
						
						if ($aspect_ratio >= $aspect_ratio_thumb) {
							
							$thumb->thumbnailImage ( $light_thumbs_width, 0 );
						} else {
							
							$thumb->thumbnailImage ( 0, $light_thumbs_height );
						}
					} else {
						
						$thumb->thumbnailImage ( $light_thumbs_width, 0 ); 
					}
					$new_fileName = 'light_thumb_' . $fileName . '.jpg';
					break;
			}
			if ($params->get ( 'watermark_thumbs' )) {
				
				JWallpapersHelperImage::watermarkImage ( $thumb );
			}
			
			$thumb->setImageCompression ( Imagick::COMPRESSION_JPEG );
			$thumb->setImageCompressionQuality ( $image_quality );
			
			$thumb->writeImage ( $destDir . DS . $new_fileName );
			
			$thumb->clear ();
			$thumb->destroy ();
		
		} elseif ($image_library == 'GD') {
			
			
			$image = imagecreatefromstring ( file_get_contents ( $fileAndPath ) );
			
			list ( $width, $height ) = getimagesize ( $fileAndPath );
			
			$aspect_ratio = number_format ( $width / $height, 3 );
			
			switch ($type) {
				default :
					$type = 'small';
				case 'small' :
					
					$aspect_ratio_thumb = number_format ( $small_thumbs_width / $small_thumbs_height, 3 );
					
					switch ($thumbs_resize_method) {
						case 'noaspect' :
							
							$thumb = imagecreatetruecolor ( $small_thumbs_width, $small_thumbs_height );
							
							imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $small_thumbs_width, $small_thumbs_height, $width, $height );
							break;
						case 'aspect' :
							
							
							if ($aspect_ratio >= $aspect_ratio_thumb) {
								$thumb_height = round ( ($small_thumbs_width / $width) * $height );
								
								$thumb = imagecreatetruecolor ( $small_thumbs_width, $thumb_height );
								
								imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $small_thumbs_width, $thumb_height, $width, $height );
							} else {
								$thumb_width = round ( ($small_thumbs_height / $height) * $width );
								
								$thumb = imagecreatetruecolor ( $thumb_width, $small_thumbs_height );
								
								imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $thumb_width, $small_thumbs_height, $width, $height );
							}
							break;
						case 'crop' :
							
							$thumb = imagecreatetruecolor ( $small_thumbs_width, $small_thumbs_height );
							
							
							if ($width / $height >= $small_thumbs_width / $small_thumbs_height) {
								
								$crop_width = round ( ($small_thumbs_height * $width - $small_thumbs_width * $height) / (2 * $small_thumbs_height) );
								imagecopyresampled ( $thumb, $image, 0, 0, $crop_width, 0, $small_thumbs_width, $small_thumbs_height, $width - 2 * $crop_width, $height );
							} else {
								
								$crop_height = round ( ($small_thumbs_width * $height - $small_thumbs_height * $width) / (2 * $small_thumbs_width) );
								imagecopyresampled ( $thumb, $image, 0, 0, 0, $crop_height, $small_thumbs_width, $small_thumbs_height, $width, $height - 2 * $crop_height );
							}
							break;
					}
					$new_fileName = 'thumb_' . $fileName . '.jpg';
					break;
				case 'big' :
					
					
					
					if ($big_thumbs_height) {
						$aspect_ratio_thumb = number_format ( $big_thumbs_width / $big_thumbs_height, 3 );
						
						
						if ($aspect_ratio >= $aspect_ratio_thumb) {
							$thumb_height = round ( ($big_thumbs_width / $width) * $height );
							
							$thumb = imagecreatetruecolor ( $big_thumbs_width, $thumb_height );
							
							imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $big_thumbs_width, $thumb_height, $width, $height );
						} else {
							$thumb_width = round ( ($big_thumbs_height / $height) * $width );
							
							$thumb = imagecreatetruecolor ( $thumb_width, $big_thumbs_height );
							
							imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $thumb_width, $big_thumbs_height, $width, $height );
						}
					} else {
						
						$thumb_height = round ( ($big_thumbs_width / $width) * $height );
						
						$thumb = imagecreatetruecolor ( $big_thumbs_width, $thumb_height );
						
						imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $big_thumbs_width, $thumb_height, $width, $height );
					}
					$new_fileName = 'big_thumb_' . $fileName . '.jpg';
					break;
				case 'light' :
					
					
					
					if ($light_thumbs_height) {
						$aspect_ratio_thumb = number_format ( $light_thumbs_width / $light_thumbs_height, 3 );
						
						
						if ($aspect_ratio >= $aspect_ratio_thumb) {
							$thumb_height = round ( ($light_thumbs_width / $width) * $height );
							
							$thumb = imagecreatetruecolor ( $light_thumbs_width, $thumb_height );
							
							imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $light_thumbs_width, $thumb_height, $width, $height );
						} else {
							$thumb_width = round ( ($light_thumbs_height / $height) * $width );
							
							$thumb = imagecreatetruecolor ( $thumb_width, $light_thumbs_height );
							
							imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $thumb_width, $light_thumbs_height, $width, $height );
						}
					} else {
						
						$thumb_height = round ( ($light_thumbs_width / $width) * $height );
						
						$thumb = imagecreatetruecolor ( $light_thumbs_width, $thumb_height );
						
						imagecopyresampled ( $thumb, $image, 0, 0, 0, 0, $light_thumbs_width, $thumb_height, $width, $height );
					}
					$new_fileName = 'light_thumb_' . $fileName . '.jpg';
					break;
			}
			if ($params->get ( 'watermark_thumbs' )) {
				
				JWallpapersHelperImage::watermarkImage ( $thumb );
			}
			
			
			imagejpeg ( $thumb, $destDir . DS . $new_fileName, $image_quality );
			
			imagedestroy ( $image );
			imagedestroy ( $thumb );
		}
	}
	
	
	function validateResize($pic_id, $size_format, &$pic_res, &$res_res, $cat_id) {
		
		global $option;
		
		$params = & JComponentHelper::getParams ( $option );
		
		$extrapolate = $params->get ( 'resizes_extrapolate' );
		
		
		if (! $extrapolate) {
			$sql_cond = ' AND width < ' . $pic_res ['width'] . ' AND height < ' . $pic_res ['height'];
		} else {
			$sql_cond = '';
		}
		
		$db = & JFactory::getDBO ();
		
		
		$queries = array ();
		$queries [] = 'SELECT CONCAT(width, height) FROM #__jwallpapers_files_resizes WHERE file_id = ' . ( int ) $pic_id . $sql_cond;
		$queries [] = 'SELECT CONCAT(width, height) FROM #__jwallpapers_categories_resizes WHERE cat_id = ' . ( int ) $cat_id . ' AND FIND_IN_SET(' . ( int ) $size_format . ',size_formats)' . $sql_cond;
		$queries [] = 'SELECT CONCAT(width, height) FROM #__jwallpapers_global_resizes WHERE FIND_IN_SET(' . $size_format . ',size_formats)' . $sql_cond;
		
		for($i = 0; $i < 3; $i ++) {
			
			$db->setQUery ( $queries [$i] );
			$results = $db->loadResultArray ();
			
			if (! empty ( $results )) {
				
				break;
			}
		
		}
		
		
		
		foreach ( $results as $result ) {
			if ($res_res ['width'] . $res_res ['height'] == $result) {
				
				return 1;
			}
		}
		
		
		return 0;
	}
	
	
	function generateResize($filePath, $fileName, $fileExt, $width, $height) {
		
		
		$option = 'com_jwallpapers';
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$image_library = $params->get ( 'image_library' );
		$image_quality = $params->get ( 'image_quality' );
		
		$fullPath = $filePath . DS . $fileName . '.' . $fileExt;
		
		switch ($image_library) {
			default :
				$image_library = 'GD';
			case 'GD' :
				
				$image = imagecreatefromstring ( file_get_contents ( $fullPath ) );
				
				list ( $imageWidth, $imageHeight ) = getimagesize ( $fullPath );
				
				$imageResize = imagecreatetruecolor ( $width, $height );
				
				imagecopyresampled ( $imageResize, $image, 0, 0, 0, 0, $width, $height, $imageWidth, $imageHeight );
				if ($params->get ( 'watermark_downloads' )) {
					
					JWallpapersHelperImage::watermarkImage ( $imageResize );
				}
				
				
				imagejpeg ( $imageResize, $filePath . DS . $width . '_' . $height . '_' . $fileName . '.jpg', $image_quality );
				
				imagedestroy ( $imageResize );
				imagedestroy ( $image );
				break;
			case 'Imagick' :
				$image = new Imagick ( $fullPath );
				
				
				$image->resizeImage ( $width, $height, imagick::FILTER_LANCZOS, 1 );
				if ($params->get ( 'watermark_downloads' )) {
					
					JWallpapersHelperImage::watermarkImage ( $image );
				}
				
				$image->setImageCompression ( Imagick::COMPRESSION_JPEG );
				$image->setImageCompressionQuality ( $image_quality );
				$image->writeImage ( $filePath . DS . $width . '_' . $height . '_' . $fileName . '.jpg' );
				
				$image->clear ();
				$image->destroy ();
				break;
		}
	
	}
	
	function setImageInfo(&$image_resolution, &$row) {
		
		global $option;
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$image_library = $params->get ( 'image_library' );
		
		
		$row->width = $image_resolution ['width'];
		$row->height = $image_resolution ['height'];
		
		
		$aspect_ratio = number_format ( $row->width / $row->height, 3 );
		
		if ($aspect_ratio == 1.333) {
			$row->size_format = 0;
		} elseif ($aspect_ratio == 1.6) {
			$row->size_format = 1;
		} elseif ($aspect_ratio == 1.25) {
			$row->size_format = 2;
		} elseif ($aspect_ratio == 1.778) {
			$row->size_format = 4;
		} else {
			$row->size_format = 3; 
		}
	
	}
	
	
	
	function getImageResolution($fileAndPath, &$resolution) {
		
		global $option;
		
		$resolution = array ();
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$image_library = $params->get ( 'image_library' );
		
		switch ($image_library) {
			case 'GD' :
				$size = getimagesize ( $fileAndPath );
				if ($size === FALSE) {
					return false;
				}
				$resolution ['width'] = $size [0];
				$resolution ['height'] = $size [1];
				break;
			case 'Imagick' :
				try {
					
					
					$image = new Imagick ( $fileAndPath );
				} catch ( Exception $e ) {
					return false;
				}
				$resolution ['width'] = $image->getImageWidth ();
				$resolution ['height'] = $image->getImageHeight ();
				$image->clear ();
				$image->destroy ();
				break;
		}
		return true;
	}
	
	function getSizeFormat($width, $height) {
		$ratio = number_format ( $width / $height, 3 );
		switch ($ratio) {
			case 1.333 :
				
				return 0;
				break;
			case 1.6 :
				
				return 1;
				break;
			case 1.25 :
				
				return 2;
				break;
			case 1.778 :
				
				return 4;
				break;
			default :
				
				return 3;
				break;
		}
	}
	
	
	
	function validateImageFileName(&$fileName, $fileExt, $destDir) {
		
		while ( true ) {
			
			if (! file_exists ( $destDir . DS . $fileName . '.' . $fileExt )) {
				
				break;
			} else {
				
				$fileName = md5 ( $fileName . time () );
			}
		}
	
	}
	
	
	function sendDownload($id, $size = array()) {
		
		global $option;
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		$db = & JFactory::getDBO ();
		
		
		$query = 'UPDATE #__jwallpapers_files SET downloads = downloads + 1 WHERE id = ' . ( int ) $id;
		$db->Execute ( $query );
		
		$query = 'SELECT file_name AS name, file_ext AS ext, title, YEAR(upload_date) AS year, MONTH(upload_date) AS month FROM #__jwallpapers_files WHERE id = ' . ( int ) $id;
		
		$db->setQuery ( $query );
		$fileInfo = $db->loadObject ();
		
		if (! empty ( $size )) {
			
			$fileInfo->name = $size ['width'] . '_' . $size ['height'] . '_' . $fileInfo->name;
		}
		
		$imageFile = JPATH_SITE . DS . 'jwallpapers_files' . DS . $fileInfo->year . DS . $fileInfo->month . DS . $fileInfo->name . '.' . $fileInfo->ext;
		$imageName = str_replace ( ' ', '_', $fileInfo->title );
		$imageName .= '.' . $fileInfo->ext;
		
		if (! file_exists ( $imageFile )) {
			die ( 'File does not exists' );
		}
		
		
		
		if (empty ( $size ) && $params->get ( 'watermark_downloads' )) {
			
			$watermarked_imageFile = JPATH_ROOT . DS . 'jwallpapers_files' . DS . $fileInfo->year . DS . $fileInfo->month . DS . 'water_' . $fileInfo->name . '.jpg';
			if (! file_exists ( $watermarked_imageFile ) || filesize ( $watermarked_imageFile ) == 0) {
				touch ( $watermarked_imageFile );
				
				$watermark_original_image_control_file = JPATH_ROOT . DS . 'jwallpapers_files' . DS . 'wtrorgimgctrl.txt';
				if (! file_exists ( $watermark_original_image_control_file )) {
					touch ( $watermark_original_image_control_file );
				}
				$watermark_original_image_control_handler = fopen ( $watermark_original_image_control_file, 'r' );
				
				flock ( $watermark_original_image_control_handler, LOCK_EX );
				
				
				

				
				
				
				
				
				clearstatcache ();
				
				
				
				
				if (filesize ( $watermarked_imageFile ) == 0) {
					
					$image_quality = $params->get ( 'image_quality' );
					switch ($params->get ( 'image_library' )) {
						case 'Imagick' :
							$image = new Imagick ( $imageFile );
							JWallpapersHelperImage::watermarkImage ( $image );
							
							$image->setImageCompression ( Imagick::COMPRESSION_JPEG );
							$image->setImageCompressionQuality ( $image_quality );
							$image->writeImage ( $watermarked_imageFile );
							
							$image->clear ();
							$image->destroy ();
							break;
						case 'GD' :
							$image = imagecreatefromstring ( file_get_contents ( $imageFile ) );
							JWallpapersHelperImage::watermarkImage ( $image );
							
							
							imagejpeg ( $image, $watermarked_imageFile, $image_quality );
							
							imagedestroy ( $image );
							break;
					}
				}
				
				flock ( $watermark_original_image_control_handler, LOCK_UN );
				
				fclose ( $watermark_original_image_control_handler );
				
				
				clearstatcache ();
			}
			
			$imageFile = $watermarked_imageFile;
		}
		
		
		$fp = fopen ( $imageFile, 'rb' );
		
		
		
		header ( "Content-Type: image" );
		header ( "Content-Length: " . filesize ( $imageFile ) );
		header ( "Content-Disposition: attachment; filename=\"$imageName\"" );
		
		
		fpassthru ( $fp );
		fclose ( $fp );
		exit ();
	
	}
	
	
	function imageGenChk(&$item, $type, &$resize = null) {
		
		global $mainframe;
		
		
		$option = 'com_jwallpapers';
		
		$itemDir = 'jwallpapers_files/' . $item->year . '/' . $item->month;
		
		
		if ($mainframe->isAdmin ()) {
			
			$itemDir = '../' . $itemDir;
		}
		
		switch ($type) {
			case 'thumb' :
				$element = $itemDir . '/thumb_' . $item->name . '.jpg';
				break;
			case 'big_thumb' :
				$element = $itemDir . '/big_thumb_' . $item->name . '.jpg';
				break;
			case 'light_thumb' :
				$element = $itemDir . '/light_thumb_' . $item->name . '.jpg';
				break;
			case 'resize' :
				$element = $itemDir . '/' . $resize->width . '_' . $resize->height . '_' . $item->name . '.jpg';
				break;
		}
		
		
		if (! file_exists ( $element )) {
			
			
			$params = & JComponentHelper::getParams ( $option );
			
			
			
			$temp_control_file = $element . '.tmp';
			
			$should_create_element = 0;
			
			if (! file_exists ( $temp_control_file )) {
				touch ( $temp_control_file );
				$should_create_element = 1;
			} elseif ((time () - filemtime ( $temp_control_file )) > 10) {
				
				
				
				
				$should_create_element = 1;
			
			}
			
			if ($should_create_element) {
				
				switch ($type) {
					case 'thumb' :
						JWallpapersHelperImage::createThumb ( $item->name, $item->ext, $itemDir, 'small' );
						break;
					case 'big_thumb' :
						JWallpapersHelperImage::createThumb ( $item->name, $item->ext, $itemDir, 'big' );
						break;
					case 'light_thumb' :
						JWallpapersHelperImage::createThumb ( $item->name, $item->ext, $itemDir, 'light' );
						break;
					case 'resize' :
						JWallpapersHelperImage::generateResize ( $itemDir, $item->name, $item->ext, $resize->width, $resize->height );
						break;
				}
				
				
				unlink ( $temp_control_file );
			}
		
		}
	}
	
	
	function processImageFile(&$file, &$dataFromForm, &$params, &$admin_msgs, &$msg, &$submit_model, $file_in_server = 0) {
		
		global $option, $mainframe;
		
		$row = & JTable::getInstance ( 'JWallpapers_File', 'Table' );
		
		
		$fields = array ('error', 'name', 'type', 'tmp_name', 'size' );
		if (! JWallpapersHelperSystem::isFormDataComplete ( $file, $fields )) {
			$msg = JText::_ ( 'FORM_VAR_CHECK_ERROR' );
			return 0;
		}
		
		
		
		
		if (! $file_in_server) {
			if ($file ['error'] != 0) {
				switch ($file ['error']) {
					case 1 : 
						$msg = JText::_ ( 'FILESIZE_EXCEEDED_MAX_SETUP' );
						return 0;
						break;
					case 2 : 
						$msg = JText::_ ( 'FILESIZE_EXCEEDED_MAX_SETUP' );
						return 0;
						break;
					case 3 : 
						$msg = JText::_ ( 'PARTIAL_UPLOAD' );
						return 0;
						break;
					case 4 : 
						$msg = JText::_ ( 'FILE_MISSING' );
						return 0;
						break;
				}
			}
		}
		
		
		
		
		if (! $file_in_server) {
			if (! (is_uploaded_file ( $file ['tmp_name'] ) && filesize ( $file ['tmp_name'] ) <= $params->get ( 'max_upload_size' ) * 1024)) {
				$msg = JText::_ ( 'FILESIZE_EXCEEDED_MAX_SETUP' );
				return 0;
			}
		}
		
		
		if (preg_match ( '/[\x00-\x1F\x7F-\x9F\/\\\\]/', $file ['name'] )) {
			$msg = JText::_ ( 'INVALID_NAME' );
			return 0;
		}
		
		
		
		if (! JWallpapersHelperImage::getImageResolution ( $file ['tmp_name'], $imageResolution )) {
			$msg = JText::_ ( 'INVALID_TYPE' );
			return 0;
		}
		
		
		$max_resolution = (( int ) $params->get ( 'max_upload_resolution' )) * 1000000;
		$combined_resolution = $imageResolution ['width'] * $imageResolution ['height'];
		if ($combined_resolution > $max_resolution) {
			$msg = JText::_ ( 'RESOLUTION_EXCEEDED_MAX_SETUP' );
			return 0;
		}
		
		
		if (! $row->bind ( $dataFromForm )) {
			echo "<script> alert('" . $row->getError () . "');
	    window.history.go(-1); </script>\n";
			exit ();
		}
		
		$uploadTimestamp = time ();
		$row->upload_date = date ( 'Y-m-d H:i:s', $uploadTimestamp );
		
		$uploadYear = date ( 'Y', $uploadTimestamp );
		$uploadMonth = date ( 'n', $uploadTimestamp );
		
		
		$destDir = JPATH_SITE . DS . 'jwallpapers_files' . DS . $uploadYear . DS . $uploadMonth;
		
		
		if (! is_dir ( $destDir )) {
			mkdir ( $destDir, 0777, true ); 
		}
		
		if (! preg_match ( '/^(.*)\.(.*)$/m', $file ['name'], $result )) {
			$msg = JText::_ ( 'REG_EXP_NAME_FAILED' );
			return 0;
		}
		
		$originalFileName = $result [1];
		$ext = $result [2];
		
		$fileName = md5 ( $originalFileName . $uploadTimestamp );
		
		
		JWallpapersHelperImage::validateImageFileName ( $fileName, $ext, $destDir );
		
		$fileAndPath = JPATH_SITE . DS . 'jwallpapers_files' . DS . $uploadYear . DS . $uploadMonth . DS . $fileName . '.' . $ext;
		
		
		if ($params->get ( 'selective_resolution' )) {
			
			if (empty ( $submit_model )) {
				require_once (JPATH_ROOT . DS . 'components' . DS . $option . DS . 'models' . DS . 'submit.php');
				$submit_model = new JWallpapersModelSubmit ( );
			}
			
			
			
			$allowedResolutions = & $submit_model->getAllowedResolutions ();
			
			
			$imageResolution_formated = array ($imageResolution ['width'] . 'x' . $imageResolution ['height'] );
			
			
			if (array_intersect ( $imageResolution_formated, $allowedResolutions ) == array ()) {
				$msg = JTEXT::_ ( 'SELECTIVE_RESOLUTION' );
				return 0;
			}
		}
		
		
		if ($file_in_server) {
			if (! copy ( $file ['tmp_name'], $fileAndPath )) {
				$msg = JText::_ ( 'FILE_COPY_FAILED' );
				return 0;
			}
		} else {
			if (! move_uploaded_file ( $file ['tmp_name'], $fileAndPath )) {
				$msg = JText::_ ( 'FILE_UPLOAD_FAILED' );
				return 0;
			}
		}
		
		if ($dataFromForm ['title'] == '') {
			
			$row->title = $originalFileName;
		}
		
		
		$row->check ();
		
		
		JWallpapersHelperImage::setImageInfo ( $imageResolution, $row );
		
		$row->file_name = $fileName;
		$row->file_ext = $ext;
		
		
		if ($params->get ( 'generate_thumbs_upload' )) {
			
			JWallpapersHelperImage::createThumb ( $fileName, $ext, $destDir, 'small' );
			JWallpapersHelperImage::createThumb ( $fileName, $ext, $destDir, 'big' );
			JWallpapersHelperImage::createThumb ( $fileName, $ext, $destDir, 'light' );
		}
		
		
		if (! $row->store ()) {
			echo "<script> alert('" . $row->getError () . "');
	    window.history.go(-1); </script>\n";
			exit ();
		}
		
		
		$row->validate ();
		
		
		if (! $mainframe->isAdmin () && $params->get ( 'msg_method' )) {
			
			
			$admin_msgs [] = JText::sprintf ( 'FRONTEND_UPLOAD_NOTICE', $row->title, $row->id, $dataFromForm ['user_id'], $row->cat_id );
		}
		
		return 1;
	
	}
	
	function processZipFile(&$file, &$dataFromForm, $file_in_server, &$params) {
		
		global $mainframe;
		
		
		
		if (preg_match ( '/[\x00-\x1F\x7F-\x9F\/\\\\]/', $file ['name'] )) {
			$msg = JText::_ ( 'INVALID_NAME' ) . ' ' . $file ['name']; // "Invalid file name."
			return 0;
		}
		
		
		
		if (! ini_get ( 'safe_mode' )) {
			set_time_limit ( 0 );
		}
		
		jimport ( 'joomla.filesystem.archive' );
		jimport ( 'joomla.filesystem.folder' );
		
		$uploadTimestamp = time ();
		
		
		$fileName = md5 ( JFile::getName ( $file ['name'] ) . $uploadTimestamp ); 
		$zipExtractionPath = JPATH_SITE . DS . 'tmp' . DS . 'tmp_' . $fileName;
		if (! is_dir ( $zipExtractionPath )) {
			
			JFolder::create ( $zipExtractionPath );
		}
		$zipNameAndPath = $zipExtractionPath . DS . $fileName . '.zip';
		
		
		if (! $file_in_server) {
			
			
			
			if (! JFile::upload ( $file ['tmp_name'], $zipNameAndPath )) {
				$msg = JText::_ ( 'FILE_UPLOAD_FAILED' );
				return 0;
			}
		} else {
			
			if (! JFile::copy ( $file ['tmp_name'], $zipNameAndPath )) {
				$msg = JText::_ ( 'FILE_COPY_FAILED' );
				return 0;
			}
		}
		
		$imagesExtractionPath = $zipExtractionPath . DS . 'images' . DS;
		
		if (! JArchive::extract ( $zipNameAndPath, $imagesExtractionPath )) {
			$msg = JText::_ ( 'FILE_EXTRACTION_FAILED' ); // "Extracion failed." 
			return 0;
		}
		
		
		$images = $imagesExtractionPath . '*';
		
		
		
		
		
		
		
		

		
		$failed_counter = 0;
		$success_counter = 0;
		
		foreach ( glob ( $images ) as $image ) {
			
			
			
			
			
			
			
			
			

			
			$image_file = array ('tmp_name' => $image, 'is_in_server' => 1, 'error' => '', 'size' => '', 'type' => '' );
			
			if (JWallpapersHelperSystem::isWin ()) {
				$regexp = '/^.*\\\\(.*)\.(.*)$/m';
			} else {
				$regexp = '/^.*\/(.*)\.(.*)$/m';
			}
			
			if (! preg_match ( $regexp, $image, $result )) {
				$msg = JText::_ ( 'REG_EXP_FILE_NAME_EXT' );
				return 0;
			}
			
			
			$image_file ['name'] = $result [1] . '.' . $result [2];
			
			if (! JWallpapersHelperImage::processImageFile ( $image_file, $dataFromForm, $params, $admin_msgs, $msg, $submit_model, 1 )) {
				
				$msg = $image_file ['name'] . ': ' . $msg;
				$mainframe->enqueueMessage ( $msg, 'notice' );
				$failed_counter ++;
			} else {
				$success_counter ++;
			}
		}
		
		
		
		foreach ( glob ( $images ) as $fileToDelete ) {
			JFile::delete ( $fileToDelete );
		}
		
		JFolder::delete ( $imagesExtractionPath );
		JFile::delete ( $zipNameAndPath );
		JFolder::delete ( $zipExtractionPath );
		
		if (! $success_counter) {
			$msg = JText::_ ( 'UPLOAD_FAILED' );
			return 0;
		}
		
		if ($success_counter && $failed_counter) {
			$mainframe->enqueueMessage ( JText::_ ( 'UPLOAD_PARTIAL_SUCCESS' ), 'notice' );
		}
		
		return 1;
	
	}
	
	
	function watermarkImage(&$image) {
		
		
		$option = 'com_jwallpapers';
		
		$component = JComponentHelper::getComponent ( $option );
		$params = new JParameter ( $component->params );
		
		
		$image_library = $params->get ( 'image_library' );
		$watermark_size_ratio = ( int ) $params->get ( 'watermark_size_ratio' );
		$watermark_position = $params->get ( 'watermark_position' );
		$watermark_margin = ( int ) $params->get ( 'watermark_margin' );
		$watermark_image_path = $params->get ( 'watermark_image_path' );
		
		
		if (! file_exists ( $watermark_image_path )) {
			
			return;
		}
		
		switch ($image_library) {
			
			case 'Imagick' :
				
				$watermark = new Imagick ( $watermark_image_path );
				
				$image_width = $image->getImageWidth ();
				$image_height = $image->getImageHeight ();
				
				$watermark_width = $watermark->getImageWidth ();
				$watermark_height = $watermark->getImageHeight ();
				break;
			case 'GD' :
				
				$watermark = imagecreatefromstring ( file_get_contents ( $watermark_image_path ) );
				
				$image_width = imagesx ( $image );
				$image_height = imagesy ( $image );
				
				$watermark_width = imagesx ( $watermark );
				$watermark_height = imagesy ( $watermark );
				break;
		}
		
		
		$new_watermark_width = round ( $image_width * $watermark_size_ratio / 100 );
		$new_watermark_height = round ( $watermark_height * $new_watermark_width / $watermark_width );
		
		
		switch ($watermark_position) {
			case 0 :
				$pos_x = $watermark_margin;
				$pos_y = $watermark_margin;
				break;
			case 1 :
				$pos_x = $image_width - $new_watermark_width - $watermark_margin;
				$pos_y = $watermark_margin;
				break;
			case 2 :
				$pos_x = round ( ($image_width - $new_watermark_width) / 2 );
				$pos_y = round ( ($image_height - $new_watermark_height) / 2 );
				break;
			case 3 :
				$pos_x = $watermark_margin;
				$pos_y = $image_height - $new_watermark_height - $watermark_margin;
				break;
			default :
				$watermark_position = 4;
			case 4 :
				$pos_x = $image_width - $new_watermark_width - $watermark_margin;
				$pos_y = $image_height - $new_watermark_height - $watermark_margin;
				break;
		}
		
		switch ($image_library) {
			case 'Imagick' :
				
				$watermark->thumbnailImage ( $new_watermark_width, $new_watermark_height );
				
				$image->compositeImage ( $watermark, Imagick::COMPOSITE_OVER, $pos_x, $pos_y );
				
				$watermark->clear ();
				$watermark->destroy ();
				break;
			case 'GD' :
				
				
				$new_watermark = imagecreatetruecolor ( $new_watermark_width, $new_watermark_height );
				
				
				imagealphablending ( $new_watermark, false );
				imagesavealpha ( $new_watermark, true );
				
				imagecopyresampled ( $new_watermark, $watermark, 0, 0, 0, 0, $new_watermark_width, $new_watermark_height, $watermark_width, $watermark_height );
				
				imagecopy ( $image, $new_watermark, $pos_x, $pos_y, 0, 0, $new_watermark_width, $new_watermark_height );
				
				imagedestroy ( $watermark );
				imagedestroy ( $new_watermark );
				break;
		}
	
	}
	
	
	function updateResizeList(&$dataFromForm) {
		
		$controller = JRequest::getVar ( 'controller' );
		
		switch ($controller) {
			case 'settings' :
				$resize_row = & JTable::getInstance ( 'JWallpapers_Global_Resize', 'Table' );
				break;
			case 'categories' :
				$resize_row = & JTable::getInstance ( 'JWallpapers_Category_Resize', 'Table' );
				break;
		}
		
		if (isset ( $dataFromForm ['resizesCount'] )) {
			for($i = 1; $i <= $dataFromForm ['resizesCount']; $i ++) {
				
				$resizeParamsId = $dataFromForm ['resize_id_' . $i];
				
				$size_formats_array = array ();
				
				$resize_row->load ( $resizeParamsId );
				$formatBoxes = array ('resize_format_0_' . $i, 'resize_format_1_' . $i, 'resize_format_2_' . $i, 'resize_format_3_' . $i, 'resize_format_4_' . $i );
				
				
				$j = 0;
				foreach ( $formatBoxes as $formatBox ) {
					if (isset ( $dataFromForm [$formatBox] )) {
						$size_formats_array [] = $j;
					}
					$j ++;
				}
				
				$resize_row->size_formats = implode ( ',', $size_formats_array );
				
				if (! $resize_row->store ()) {
					JError::raiseError ( 500, $resize_row->getError () );
				}
				
				$resize_row->reset ();
				$resize_row->id = null;
			}
			return 1;
		} else {
			return 0;
		}
	
	}

}
?>
