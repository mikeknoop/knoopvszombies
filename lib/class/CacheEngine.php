<?php
/**  
 * CacheEngine Class
 * 
 * A simple class which reads and writes cached pages, page pieces, and
 * objects
 * 	
 * @access		public
 */
class CacheEngine {

	/**
	 * Hash File Names when writing? (Default = false)
	 * @var 	bool
	 * @access	public
	 */
	var $HashFileNames = false;

	/**
	 * Path to the Cache Directory
	 * @var 	string
	 * @access	private
	 */
	var $_CacheDirPath = '';

	/**
	 * Path to the Cache File
	 * @var 	string
	 * @access	private
	 */
	var $_CacheFilePath = '';

	/**
	 * Constructor for CacheEngine instances
	 */
	function CacheEngine($dir) {
    //$this->_CacheDirPath = DOCUMENT_ROOT . $dir;
    $this->_CacheDirPath = $dir;
	}
	
	/**
	 * Retrieves a Cache file and returns either an object
	 * or a string
	 *
	 * @return	mixed
	 * @param	string	Name of File in Cache
	 * @param	int		Number of Seconds until File is considered old
	 * @param	bool	Return an object from Cache?
	 * @access	public
	 */
	function GetFromCache( $FileName , $Seconds = 0, $IsObject = false) {

		$this->_BuildFileName($FileName);
		
		$return = false;
		if ($Seconds == 0) {
			if (file_exists($this->_CacheFilePath)) {
				$return = $this->_ReadFromCache();
			}
			else {
				return false;
			}
		} 
		else {
			$refresh_time = time() - (int) $Seconds;
		
      if (file_exists($this->_CacheFilePath)) {		
        if (filemtime($this->_CacheFilePath) > $refresh_time) {
          $return = $this->_ReadFromCache();
        }
        else {
          $this->RemoveFromCache($FileName);
          return false;
        }
      } 
      else {
        return false;
      }
      		
		}
		if ($IsObject) {
		    $return = unserialize($return);
		}
		return $return;
	}
	
	/**
	 * Sets the directory to read and write cache files
	 *
	 * @return	mixed
	 * @param	string	Path of Directory
	 * @access	public
	 */
	function SetCacheDir( $dir_path ) {
		if (strlen(trim($dir_path)) == 0) {
			throw new Exception(get_class($this) . 
						'No Cache directory Path set.'
						, E_USER_ERROR);
			return false;
		}
		else { 
			if (substr(strtoupper(PHP_OS),0,3) != 'WIN') {
				if (substr($dir_path, 0, -1) != '/') {
					$dir_path .= '/';
				}
			}
			else {
				if (substr($dir_path, 0, -1) != "\\") {
					$dir_path .= "\\";
				}
			}
			$this->_CacheDirPath = $dir_path;
			// Check if a real directory
			if (!is_dir($this->_CacheDirPath)) {
				throw new Exception(get_class($this) . 
							'Cache Directory does not exist.'
							, E_USER_ERROR);
				return false;
			}
			
		}
	}
	
	/**
	 * Writes data to the cache
	 *
	 * @return	mixed
	 * @param	string	File Name (may be encoded)
	 * @param	mixed	Data to write
	 * @access	public
	 */
	function WriteToCache( $FileName, $Data ) {
	    if (is_array($Data) || is_object($Data)) {
		$Data = serialize($Data);
	    }
	    $this->_BuildFileName($FileName); 
	    /** 
	     * Use a file swap technique to avoid need
	     * for file locks
	     */
	    if (!$file = fopen($this->_CacheFilePath . getmypid(), "wb")) {
		    throw new Exception(get_class($this) . 
				'::WriteToCache(): Could not open file for writing.'
				, E_USER_ERROR);
		    return false;
	    }
	    $len_data = strlen($Data);
        fwrite($file, $Data, $len_data);
        fclose($file);
	    /** Handle file swap */
	    rename($this->_CacheFilePath . getmypid(), $this->_CacheFilePath);	    
	    return true;
	}
	
	/**
	 * Removes a cache file from the cache directory
	 *
	 * @return	mixed
	 * @param	string	File Name to remove (will be encoded)
	 * @access	public
	 */
	function RemoveFromCache( $file_name ) {
	    $this->_BuildFileName($file_name); 
	    if (!file_exists($this->_CacheFilePath)) {
    		return true;
        }
	    else {
        	if (!unlink($this->_CacheFilePath)) {
		        throw new Exception(get_class($this) . 
				'Unable to remove from cache file'
				, E_USER_ERROR);   
		        return false;
            }
		    else {
		        clearstatcache();
		        return true;
	        }
        }
	}
	
	/**
	 * Reads the local file from the cache directory
	 *
	 * @return	mixed
	 * @access	private
	 */
	function _ReadFromCache() {
	
      // Check if magic_quotes_runtime is active
      if(get_magic_quotes_runtime())
      {
          $mq_setting = get_magic_quotes_runtime();
          set_magic_quotes_runtime(0);
      }

	    if (!$return_data = @ file_get_contents($this->_CacheFilePath)) {
	    	throw new Exception(get_class() . 
				'::_ReadFromCache(): Unable to read file contents'
				, E_USER_ERROR);
	    }
	    
	    // Check if magic_quotes_runtime is active
      if(get_magic_quotes_runtime())
      {
          set_magic_quotes_runtime($mq_setting);
      }
      
	    return $return_data;
	}
	
	/**
	 * Builds filename from file and directory, optionally
	 * hashes the name if HashFileNames property is set to true
	 *
	 * @return	mixed
	 * @param	string	File Name to set to directory
	 * @access	private
	 */
	function _BuildFileName( $file_name ) {
		$this->_CacheFilePath = $this->_CacheDirPath . ($this->HashFileNames ? md5($file_name) : $file_name);
	}	
}
?>
