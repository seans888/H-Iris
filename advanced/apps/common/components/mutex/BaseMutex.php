<?php defined('MW_PATH') || exit('No direct script access allowed');



/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
 
abstract class BaseMutex extends CApplicationComponent 
{
    /**
     * @var boolean whether all locks acquired in this process (i.e. local locks) must be released automagically
     * before finishing script execution. Defaults to true. Setting this property to true means that all locks
     * acquire in this process must be released in any case (regardless any kind of errors or exceptions).
     */
    public $autoRelease = true;
    
    /**
     * @var $_locks names of the locks acquired in the current PHP process.
     */
    private $_locks = array();
    
    /**
     * Initializes the mutex component.
     */
    public function init()
    {
        if ($this->autoRelease) {
            register_shutdown_function(array($this, '_onShutdown'));
        }
        parent::init();
    }
    
    /**
     * Acquires lock by given name.
     * @param string $name of the lock to be acquired. Must be unique.
     * @param integer $timeout to wait for lock to be released. Defaults to zero meaning that method will return
     * false immediately in case lock was already acquired.
     * @return boolean lock acquiring result.
     */
    public function acquire($name, $timeout = 0)
    {
        if ($this->acquireLock($name, $timeout)) {
            $this->_locks[] = $name;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Release acquired lock. This method will return false in case named lock was not found.
     * @param string $name of the lock to be released. This lock must be already created.
     * @return boolean lock release result: false in case named lock was not found..
     */
    public function release($name)
    {
        if ($this->releaseLock($name)) {
            $index = array_search($name, $this->_locks);
            if ($index !== false) {
                unset($this->_locks[$index]);
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Registered shutdown function to clear the locks
     */
    public function _onShutdown()
    {
        foreach ($this->_locks as $lock) {
            $this->release($lock);
        }
    }
    
    /**
     * This method should be extended by concrete mutex implementations. Acquires lock by given name.
     * @param string $name of the lock to be acquired.
     * @param integer $timeout to wait for lock to become released.
     * @return boolean acquiring result.
     */
    abstract protected function acquireLock($name, $timeout = 0);
    
    /**
     * This method should be extended by concrete mutex implementations. Releases lock by given name.
     * @param string $name of the lock to be released.
     * @return boolean release result.
     */
    abstract protected function releaseLock($name);

}