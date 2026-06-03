<?php
namespace NikosIoannidis\Softone;

use NikosIoannidis\Softone\Enums\ServiceName;

class SoftoneBrowser extends Softone
{

    /**
     * @param $object
     * @param string $filters
     * @param string $list
     * @param $start
     * @param $limit
     * @return void
     * @throws \Exception
     *
     * Set limit to -1, it will get all the data
     *
     */
    public function search($object, string $filters='', string $list='', $start='', $limit='' ): void
    {
        $this->getBrowserInfo($object, $filters, $list);

        if ($limit==-1){
            $limit = $this->response->totalcount;
        }

        $this->getBrowserData($start, $limit);
    }

    /**
     * @throws \Exception
     */
    public function info($object, $filters='', $list='' ): void
    {
        $this->getBrowserInfo($object, $filters, $list);
    }

    /**
     * @throws \Exception
     */
    public function getBrowserInfo($object, $filters='', $list='' ): void
    {
        $this->setService(ServiceName::BrowserInfo->value);
        $this->setObject($object);
        $this->setFilters($filters);
        $this->setList($list);
        $this->send();
    }

    /**
     * @throws \Exception
     */
    public function data($start='', $limit='' ): void
    {
        $this->getBrowserData($start, $limit);
    }

    /**
     * @throws \Exception
     */
    public function getBrowserData( $start='', $limit='' ): void
    {
        $this->setService(ServiceName::BrowserData->value);
        $this->setReqId($this->response->reqID);
        $this->start($start);
        $this->limit($limit);
        $this->send();
    }

    /**
     * @throws \Exception
     */
    public function getData( $object , $key ): void
    {
        $this->setService(ServiceName::GetData->value);
        $this->setObject($object);
        $this->setKey($key);
        $this->send();
    }

    /**
     * Returns data from a Selector of the application.
     *
     * @param string $editor  The editor key (e.g. "CUSTOMER")
     * @param string|null $value  Optional filter value
     * @return void
     * @throws \Exception
     */
    public function getSelectorData(string $editor, ?string $value = null): void
    {
        $this->setService(ServiceName::GetSelectorData->value);
        $this->setEditor($editor);
        $this->setEditorValue($value);
        $this->send();
    }

    /**
     * Returns data of specific fields from a table (selector lookup).
     *
     * @param string $tableName   Table name (e.g. "CUSTOMER")
     * @param string $keyName     Key field name (e.g. "CUSTID")
     * @param int|string $keyValue  Key field value (e.g. 27)
     * @param string $resultFields  Comma-separated fields to return (e.g. "NAME,AFM")
     * @return void
     * @throws \Exception
     */
    public function selectorFields(string $tableName, string $keyName, int|string $keyValue, string $resultFields): void
    {
        $this->setService(ServiceName::SelectorFields->value);
        $this->setTableName($tableName);
        $this->setKeyName($keyName);
        $this->setKeyValue($keyValue);
        $this->setResultFields($resultFields);
        $this->send();
    }

}
