<?php
/**
 * Main class for group objects
 *
 * PHP version 5
 *
 * @category Group
 * @package  FOGProject
 * @author   Tom Elliott <tommygunsster@gmail.com>
 * @license  http://opensource.org/licenses/gpl-3.0 GPLv3
 * @link     https://fogproject.org
 */
/**
 * Main class for group objects
 *
 * @category Group
 * @package  FOGProject
 * @author   Tom Elliott <tommygunsster@gmail.com>
 * @license  http://opensource.org/licenses/gpl-3.0 GPLv3
 * @link     https://fogproject.org
 */
class Group extends FOGController
{
    /**
     * The database table
     *
     * @var string
     */
    protected $databaseTable = 'groups';
    /**
     * Common to db field associations
     *
     * @var array
     */
    protected $databaseFields = array(
        'id' => 'groupID',
        'name' => 'groupName',
        'description' => 'groupDesc',
        'createdBy' => 'groupCreateBy',
        'createdTime' => 'groupDateTime',
        'building' => 'groupBuilding',
        'kernel' => 'groupKernel',
        'kernelArgs' => 'groupKernelArgs',
        'kernelDevice' => 'groupPrimaryDisk',
    );
    /**
     * Required fields
     *
     * @var array
     */
    protected $databaseFieldsRequired = array(
        'name',
    );
    /**
     * Additional fields
     *
     * @var array
     */
    protected $additionalFields = array(
        'hosts',
        'hostsnotinme',
    );
    /**
     * Destroy the group object and all associations
     *
     * @param string $field the field to scan for
     *
     * @return bool
     */
    public function destroy($field = 'id')
    {
        self::getClass('GroupAssociationManager')
            ->destroy(
                array(
                    'groupID' => $this->get('id')
                )
            );
        return parent::destroy($field);
    }
    /**
     * Saves the group elements
     *
     * @return object
     */
    public function save()
    {
        parent::save();
        return $this->assocSetter('Group', 'host');
    }
    /**
     * Returns the host count
     *
     * @return int
     */
    public function getHostCount()
    {
        return self::getClass('HostManager')
            ->count(
                array(
                    'id' => $this->get('hosts'),
                )
            );
    }
    /**
     * Add or remove printers from all hosts in the group
     * Sets printer management level for all hosts as well
     *
     * @param mixed $printerAdd the printers to add
     * @param mixed $printerDel the printers to remove
     * @param int   $level      the management level to set
     *
     * @return object
     */
    public function addPrinter($printerAdd, $printerDel, $level = 0)
    {
        self::getClass('HostManager')->update(
            array(
                'id' => $this->get('hosts')
            ),
            '',
            array(
                'printerLevel' => $level
            )
        );
        if (count($printerDel) > 0) {
            self::getClass('PrinterAssociationManager')
                ->destroy(
                    array(
                        'hostID' => $this->get('hosts'),
                        'printerID' => $printerDel
                    )
                );
        }
        if (count($printerAdd) > 0) {
            $insert_fields = array('hostID','printerID');
            $insert_values = array();
            $hosts = $this->get('hosts');
            array_walk(
                $hosts,
                function (
                    &$hostID,
                    $index
                ) use (
                    &$insert_values,
                    $printerAdd
                ) {
                    foreach ((array)$printerAdd as &$printerID) {
                        $insert_values[] = array($hostID, $printerID);
                        unset($printerID);
                    }
                }
            );
            if (count($insert_values) > 0) {
                self::getClass('PrinterAssociationManager')
                    ->insertBatch(
                        $insert_fields,
                        $insert_values
                    );
            }
        }
        return $this;
    }
    /**
     * Add Snapins to all hosts in the group.
     *
     * @param array $addArray the items to add
     *
     * @return object
     */
    public function addSnapin($addArray)
    {
        $insert_fields = array('hostID','snapinID');
        $insert_values = array();
        array_walk(
            $this->get('hosts'),
            function (
                &$hostID,
                $index
            ) use (
                &$insert_values,
                $addArray
            ) {
                foreach ($addArray as $snapinID) {
                    $insert_values[] = array($hostID, $snapinID);
                }
            }
        );
        if (count($insert_values) > 0) {
            self::getClass('SnapinAssociationManager')
                ->insertBatch(
                    $insert_fields,
                    $insert_values
                );
        }
        return $this;
    }
    /**
     * Remove snapin from all hosts in group
     *
     * @param array $removeArray the items to remove
     *
     * @return object
     */
    public function removeSnapin($removeArray)
    {
        self::getClass('SnapinAssociationManager')
            ->destroy(
                array(
                    'hostID' => $this->get('hosts'),
                    'snapinID' => $removeArray
                )
            );
        return $this;
    }
    /**
     * Add modules to all hosts in group
     *
     * @param array $addArray the items to add
     *
     * @return object
     */
    public function addModule($addArray)
    {
        $insert_fields = array('hostID','moduleID','state');
        $insert_values = array();
        $hostids = $this->get('hosts');
        foreach ((array)$hostids as &$hostid) {
            foreach ((array)$addArray as &$moduleid) {
                $insert_values[] = array($hostid, $moduleid, 1);
                unset($moduleid);
            }
            unset($hostid);
        }
        if (count($insert_values) > 0) {
            self::getClass('ModuleAssociationManager')
                ->insertBatch(
                    $insert_fields,
                    $insert_values
                );
            unset($insert_value);
        }
        return $this;
    }
    /**
     * Remove modules from hosts in group
     *
     * @param array $removeArray The items to remove
     *
     * @return object
     */
    public function removeModule($removeArray)
    {
        self::getClass('ModuleAssociationManager')
            ->destroy(
                array(
                    'hostID' => $this->get('hosts'),
                    'moduleID' => $removeArray
                )
            );
        return $this;
    }
    /**
     * Set's the display for all hosts in group.
     *
     * @param mixed $x the width to set
     * @param mixed $y the height to set
     * @param mixed $r the refresh rate to set
     *
     * @return object
     */
    public function setDisp($x, $y, $r)
    {
        self::getClass('HostScreenSettingsManager')
            ->destroy(
                array(
                    'hostID' => $this->get('hosts')
                )
            );
        $insert_fields = array(
            'hostID',
            'width',
            'height',
            'refresh',
        );
        $insert_items = array();
        foreach ((array)$this->get('hosts') as &$hostID) {
            $insert_items[] = array($hostID, $x, $y, $r);
            unset($hostID);
        }
        self::getClass('HostScreenSettingsManager')
            ->insertBatch(
                $insert_fields,
                $insert_items
            );
        return $this;
    }
    /**
     * Set's the auto logout time for all hosts
     *
     * @param mixed $time the time to set to
     *
     * @return object
     */
    public function setAlo($time)
    {
        self::getClass('HostAutoLogoutManager')
            ->destroy(
                array(
                    'hostID' => $this->get('hosts')
                )
            );
        $insert_fields = array(
            'hostID',
            'time'
        );
        $insert_items = array();
        foreach ((array)$this->get('hosts') as &$hostID) {
            $insert_items[] = array(
                $hostID,
                $time
            );
        }
        self::getClass('HostAutoLogoutManager')
            ->insertBatch($insert_fields, $insert_items);
        return $this;
    }
    /**
     * Add host to the group
     *
     * @param array $addArray the host to add
     *
     * @return object
     */
    public function addHost($addArray)
    {
        return $this->addRemItem('hosts', (array)$addArray, 'merge');
    }
    /**
     * Remove host from the group
     *
     * @param array $removeArray the host to remove
     *
     * @return object
     */
    public function removeHost($removeArray)
    {
        return $this->addRemItem('hosts', (array)$removeArray, 'diff');
    }
    /**
     * Add image to all hosts
     *
     * @param int $imageID the image id to associate
     *
     * @throws Exception
     * @return object
     */
    public function addImage($imageID)
    {
        $Image = new Image($imageID);
        if (!$Image->isValid() && is_numeric($imageID)) {
            throw new Exception(_('Select a valid image'));
        }
        $states = array_merge(
            $this->getQueuedStates(),
            (array)$this->getProgressState()
        );
        $TaskCount = self::getClass('TaskManager')
            ->count(
                array(
                    'hostID' => $this->get('hosts'),
                    'stateID' => $states
                )
            );
        if ($TaskCount > 0) {
            throw new Exception(_('There is a host in a tasking'));
        }
        self::getClass('HostManager')
            ->update(
                array(
                    'id' => $this->get('hosts')
                ),
                '',
                array('imageID' => $imageID)
            );
        return $this;
    }
    /**
     * Creates image packages for all hosts associated.
     *
     * @param int    $taskTypeID    the task type id
     * @param string $taskName      the name of the tasking
     * @param bool   $shutdown      whether to shutdown the hosts
     * @param bool   $debug         is tasking debug
     * @param mixed  $deploySnapins All, false, or specified snapin
     * @param bool   $isGroupTask   will always be true here
     * @param string $username      username creating the task
     * @param string $passreset     which account to reset if pass reset
     * @param mixed  $sessionjoin   the multicast session to join
     * @param bool   $wol           whether to wake on lan or not
     *
     * @return array
     */
    public function createImagePackage(
        $taskTypeID,
        $taskName = '',
        $shutdown = false,
        $debug = false,
        $deploySnapins = false,
        $isGroupTask = true,
        $username = '',
        $passreset = '',
        $sessionjoin = false,
        $wol = false
    ) {
        $hostCount = $this->getHostCount();
        if ($hostCount < 1) {
            throw new Exception(_('No hosts to task'));
        }
        $hostids = $this->get('hosts');
        $TaskCount = self::getClass('TaskManager')
            ->count(
                array(
                    'hostID' => $hostids,
                    'stateID' => array_merge(
                        $this->getQueuedStates(),
                        (array)$this->getProgressState()
                    )
                )
            );
        if ($TaskCount > 0) {
            throw new Exception(_('There is a host in a tasking'));
        }
        $TaskType = new TaskType($taskTypeID);
        if (!$TaskType->isValid()) {
            throw new Exception(self::$foglang['TaskTypeNotValid']);
        }
        $imagingTypes = $TaskType->isImagingTask();
        $now = $this->niceDate();
        if ($TaskType->isMulticast()) {
            $imageID = @min(
                self::getSubObjectIDs(
                    'Host',
                    array(
                        'id' => $this->get('hosts'),
                    ),
                    'imageID'
                )
            );
            $Image = new Image($imageID);
            if (!$Image->isValid()) {
                throw new Exception(self::$foglang['ImageNotValid']);
            }
            if (!$Image->get('isEnabled')) {
                throw new Exception(_('Image is not enabled'));
            }
            $StorageGroup = $Image->getStorageGroup();
            if (!$StorageGroup->isValid()) {
                throw new Exception(self::$foglang['ImageGroupNotValid']);
            }
            $StorageNode = $StorageGroup->getMasterStorageNode();
            if (!$StorageNode->isValid()) {
                throw new Exception(_('Unable to find master Storage Node'));
            }
            $port = (
                self::getSetting('FOG_MULTICAST_PORT_OVERRIDE') ?
                self::getSetting('FOG_MULTICAST_PORT_OVERRIDE') :
                self::getSetting('FOG_UDPCAST_STARTINGPORT')
            );
            $MulticastSession = self::getClass('MulticastSessions')
                ->set('name', $taskName)
                ->set('port', $port)
                ->set('logpath', $Image->get('path'))
                ->set('image', $Image->get('id'))
                ->set('interface', $StorageNode->get('interface'))
                ->set('stateID', 0)
                ->set('starttime', $now->format('Y-m-d H:i:s'))
                ->set('percent', 0)
                ->set('isDD', $Image->get('imageTypeID'))
                ->set('NFSGroupID', $StorageGroup->get('id'));
            if ($MulticastSession->save()) {
                self::getClass('MulticastSessionsAssociationManager')
                    ->destroy(
                        array(
                            'hostID' => $this->get('hosts')
                        )
                    );
                $randomnumber = mt_rand(24576, 32766) * 2;
                while ($randomnumber == $MulticastSession->get('port')) {
                    $randomnumber = mt_rand(24576, 32766) * 2;
                }
                $this->setSetting('FOG_UDPCAST_STARTINGPORT', $randomnumber);
            }
            $hostIDs = $this->get('hosts');
            $batchFields = array(
                'name',
                'createdBy',
                'hostID',
                'isForced',
                'stateID',
                'typeID',
                'wol',
                'imageID',
                'shutdown',
                'isDebug',
                'passreset'
            );
            $batchTask = array();
            for ($i = 0; $i < $hostCount; $i++) {
                $batchTask[] = array(
                    $taskName,
                    $username,
                    $hostIDs[$i],
                    0,
                    $this->getQueuedState(),
                    $TaskType->get('id'),
                    $wol,
                    $Image->get('id'),
                    $shutdown,
                    $debug,
                    $passreset
                );
            }
            if (count($batchTask) > 0) {
                list(
                    $first_id,
                    $affected_rows
                ) = self::getClass('TaskManager')
                ->insertBatch(
                    $batchFields,
                    $batchTask
                );
                $ids = range($first_id, ($first_id + $affected_rows - 1));
                $multicastsessionassocs = array();
                foreach ((array)$batchTask as $index => &$val) {
                    $multicastsessionassocs[] = array(
                        $MulticastSession->get('id'),
                        $ids[$index]
                    );
                    unset($val);
                }
                if (count($multicastsessionassocs) > 0) {
                    self::getClass('MulticastSessionsAssociationManager')
                        ->insertBatch(
                            array(
                                'msID',
                                'taskID'
                            ),
                            $multicastsessionassocs
                        );
                }
            }
            unset(
                $hostCount,
                $hostIDs,
                $batchTask,
                $first_id,
                $affected_rows,
                $ids,
                $multicastsessionassocs
            );
            $this->_createSnapinTasking($now, -1);
        } elseif ($TaskType->isDeploy()) {
            $hostIDs = $this->get('hosts');
            $imageIDs = self::getSubObjectIDs(
                'Host',
                array(
                    'id' => $hostIDs
                ),
                'imageID',
                false,
                'AND',
                'name',
                false,
                ''
            );
            $batchFields = array(
                'name',
                'createdBy',
                'hostID',
                'isForced',
                'stateID',
                'typeID',
                'wol',
                'imageID',
                'shutdown',
                'isDebug',
                'passreset'
            );
            $batchTask = array();
            for ($i = 0; $i < $hostCount; $i++) {
                $batchTask[] = array(
                    $taskName,
                    $username,
                    $hostIDs[$i],
                    0,
                    $this->getQueuedState(),
                    $TaskType->get('id'),
                    $wol,
                    $imageIDs[$i],
                    $shutdown,
                    $debug,
                    $passreset
                );
            }
            if (count($batchTask) > 0) {
                self::getClass('TaskManager')
                    ->insertBatch(
                        $batchFields,
                        $batchTask
                    );
            }
            unset(
                $hostCount,
                $hostIDs,
                $batchTask,
                $first_id,
                $affected_rows,
                $ids,
                $multicastsessionassocs
            );
            $this->_createSnapinTasking($now, $deploySnapins);
        } elseif ($TaskType->isSnapinTasking()) {
            $hostIDs = $this->_createSnapinTasking($now, $deploySnapins);
            $hostCount = count($hostIDs);
            $batchFields = array(
                'name',
                'createdBy',
                'hostID',
                'stateID',
                'typeID',
                'wol'
            );
            $batchTask = array();
            for ($i = 0; $i < $hostCount; $i++) {
                $batchTask[] = array(
                    $taskName,
                    $username,
                    $hostIDs[$i],
                    $this->getQueuedState(),
                    $TaskType->get('id'),
                    $wol
                );
            }
            if (count($batchTask) > 0) {
                self::getClass('TaskManager')
                    ->insertBatch($batchFields, $batchTask);
            }
        }
        if ($wol) {
            session_write_close();
            ignore_user_abort(true);
            set_time_limit(0);
            $this->wakeOnLAN();
        }
        return array('All hosts successfully tasked');
    }
    /**
     * Perform wake on lan to all hosts in group
     *
     * @return void
     */
    public function wakeOnLAN()
    {
        $hostMACs = self::getSubObjectIDs(
            'MACAddressAssociation',
            array(
                'hostID' => $this->get('hosts'),
                'pending' => array(
                    '0',
                    0,
                    null,
                    ''
                )
            ),
            'mac'
        );
        $hostMACs = $this->parseMacList($hostMACs);
        $macStr = implode(
            '|',
            $hostMACs
        );
        $this->wakeUp($hostMACs);
    }
    /**
     * Create snapin tasks for hosts
     *
     * @param mixed $now    the current time
     * @param int   $snapin the snapin to task (all is -1)
     *
     * @return array
     */
    private function _createSnapinTasking($now, $snapin = -1)
    {
        if ($snapin === false) {
            return;
        }
        $hostCount = $this->getHostCount();
        $hostIDs = array_values(
            self::getSubObjectIDs(
                'SnapinAssociation',
                array(
                    'hostID' => $this->get('hosts')
                ),
                'hostID'
            )
        );
        $hostCount = count($hostIDs);
        $snapinJobs = array();
        for ($i = 0; $i < $hostCount; $i++) {
            $hostID = $hostIDs[$i];
            $snapins[$hostID] = (
                $snapin === -1 ?
                self::getSubObjectIDs(
                    'SnapinAssociation',
                    array(
                        'hostID' => $hostID
                    ),
                    'snapinID'
                ) :
                array($snapin)
            );
            if (count($snapins[$hostID]) < 1) {
                continue;
            }
            $snapinJobs[] = array(
                $hostID,
                $this->getQueuedState(),
                $now->format('Y-m-d H:i:s')
            );
        }
        if (count($snapinJobs) > 0) {
            list(
                $first_id,
                $affected_rows
            ) = self::getClass('SnapinJobManager')
            ->insertBatch(
                array(
                    'hostID',
                    'stateID',
                    'createdTime'
                ),
                $snapinJobs
            );
            $ids = range($first_id, ($first_id + $affected_rows - 1));
            for ($i = 0; $i < $hostCount; $i++) {
                $hostID = $hostIDs[$i];
                $jobID = $ids[$i];
                $snapinCount = count($snapins[$hostID]);
                for ($j = 0; $j < $snapinCount; $j++) {
                    $snapinTasks[] = array(
                        $jobID,
                        $this->getQueuedState(),
                        $snapins[$hostID][$j]
                    );
                }
            }
            if (count($snapinTasks) > 0) {
                self::getClass('SnapinTaskManager')
                    ->insertBatch(
                        array(
                            'jobID',
                            'stateID',
                            'snapinID'
                        ),
                        $snapinTasks
                    );
            }
        }
        return $hostIDs;
    }
    /**
     * Sets all hosts AD information
     *
     * @param int    $useAD   tells whether to enable/disable AD
     * @param string $domain  the domain to associate
     * @param string $ou      the ou to associate
     * @param string $user    the user to join domain with
     * @param string $pass    the user password for domain join
     * @param string $legacy  the legacy password for legacy client
     * @param int    $enforce sets whether to enforce changes
     *
     * @return object
     */
    public function setAD(
        $useAD,
        $domain,
        $ou,
        $user,
        $pass,
        $legacy,
        $enforce
    ) {
        $pass = trim($this->encryptpw($pass));
        self::getClass('HostManager')
            ->update(
                array(
                    'id' => $this->get('hosts')
                ),
                '',
                array(
                    'useAD' => $useAD,
                    'ADDomain' => trim($domain),
                    'ADOU' => trim($ou),
                    'ADUser' => trim($user),
                    'ADPass' => $pass,
                    'ADPassLegacy' => $legacy,
                    'enforce' => $enforce
                )
            );
        return $this;
    }
    /**
     * Checks all hosts have the same image associated
     *
     * @return bool
     */
    public function doMembersHaveUniformImages()
    {
        $test = self::getClass('HostManager')
            ->distinct(
                'imageID',
                array('id' => $this->get('hosts'))
            );
        return $test == 1;
    }
    /**
     * Updates all host's default printers
     *
     * @param int $printerid the printer id to set as default
     *
     * @return object
     */
    public function updateDefault($printerid)
    {
        $AllGroupHostsPrinters = self::getSubObjectIDs(
            'PrinterAssociation',
            array(
                'hostID' => $this->get('hosts')
            )
        );
        self::getClass('PrinterAssociationManager')
            ->update(
                array(
                    'id' => $AllGroupHostsPrinters
                ),
                '',
                array(
                    'isDefault' => '0'
                )
            );
        self::getClass('PrinterAssociationManager')
            ->update(
                array(
                    'printerID' => $printerid,
                    'hostID' => $this->get('hosts')
                ),
                '',
                array(
                    'isDefault' => 1
                )
            );
        return $this;
    }
    /**
     * Loads hosts in this group
     *
     * @return void
     */
    protected function loadHosts()
    {
        $this->set(
            'hosts',
            self::getSubObjectIDs(
                'GroupAssociation',
                array(
                    'groupID' => $this->get('id')
                ),
                'hostID'
            )
        );
        $this->getHostCount();
    }
    /**
     * Loads hosts not in this group
     *
     * @return void
     */
    protected function loadHostsnotinme()
    {
        $find = array('id' => $this->get('hosts'));
        $this->set(
            'hostsnotinme',
            self::getSubObjectIDs(
                'Host',
                $find,
                'id',
                true
            )
        );
        unset($find);
    }
}
