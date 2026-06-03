<?php

namespace NikosIoannidis\Softone;

use NikosIoannidis\Softone\Enums\ServiceName;
use NikosIoannidis\Softone\Interfaces\SoftoneInterface;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Softone implements SoftoneInterface
{

    /**
     * Service name or action
     *
     * @var string|null
     */
    public ?string $service;

    /**
     *  Softone user Username
     *
     * @var string|null
     */
    private ?string $username;

    /**
     * Softone password
     * @var string|null
     */
    private ?string $password;

    /**
     * appID
     * @var string
     */
    public string $appId;

    /**
     * Company number
     * @var string|null
     */
    protected ?string $company;

    /**
     * Branch number
     * @var string|null
     */
    protected ?string $branch;

    /**
     * Module number
     *
     * @var string|null
     */
    protected ?string $module;

    /**
     * Ref id
     * @var string|null
     */
    protected ?string $refid;

    /**
     * Client ID
     * @var string|null
     */
    protected ?string $clientID;

    /**
     * Saved reqID from getBrowserInfo for use in getBrowserData
     * @var string|null
     */
    protected ?string $browserReqId = null;

    /**
     * Req ID
     *
     * @var string|null
     */
    public ?string $reqID;

    /**
     * Softone request Object
     * @var string|null
     */
    public ?string $object;

    /**
     * Filters
     * @var string|null
     */
    private ?string $filters;

    /**
     * List
     * @var string|null
     */
    private ?string $list;

    /**
     * UserId
     * @var string|null
     */
    private ?string $userid;

    /**
     * @var null
     */
    private $table;

    /**
     * Page Number
     * @var int|null
     */
    private ?int $pagenum;

    /**
     * Start From
     * @var string|null
     */
    private ?string $start;

    /**
     * Limit
     * @var string|null
     */
    private ?string $limit;

    /**
     * Form
     * @var string|null
     */
    private ?string $form;

    /**
     * Key
     * @var null|int|string
     */
    private null|int|string $key;

    /**
     * Key
     * @var mixed
     */
    private mixed $data;

    /**
     * Locate Info
     * @var string|null
     */
    private ?string $locateInfo;

    /**
     * Editor key for getSelectorData
     * @var string|null
     */
    private ?string $editor;

    /**
     * Value for getSelectorData
     * @var string|null
     */
    private ?string $editorValue;

    /**
     * Table name for selectorFields
     * @var string|null
     */
    private ?string $tableName;

    /**
     * Key name for selectorFields
     * @var string|null
     */
    private ?string $keyName;

    /**
     * Key value for selectorFields
     * @var null|int|string
     */
    private null|int|string $keyValue;

    /**
     * Result fields for selectorFields (comma-separated field names)
     * @var string|null
     */
    private ?string $resultFields;

    /**
     * Requests Body
     * @var array
     */
    public array $body;

    /**
     *  The Response Fields
     */
    public mixed $fields;

    /**
     * Requests response
     * @var mixed
     */
    public mixed $response;

    /**
     * Combined Response data "CUSTOMER.NAME"=>"TEST"
     *
     * @var mixed
     */
    public mixed $responseData;

    /**
     * Set Softone Service
     * @param $service
     * @return void
     */
    public function setService($service): void
    {
        $this->service = $service;
    }

    /**
     * Get Softone Service
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * Set UserName
     * @param $username
     * @return void
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * Get UserName
     * @return string|null
     */
    private function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set Password
     * @param $password
     * @return void
     */
    private function setPass($password): void
    {
        $this->password = $password;
    }

    /**
     * Set App ID
     * @param $appId
     * @return void
     */
    private function setAppId($appId): void
    {
        $this->appId = $appId;
    }

    /**
     * Get AppId
     * @return string
     */
    private function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * Set Company
     * @param $company
     * @return void
     */
    private function setCompany($company): void
    {
        $this->company = $company;
    }

    /**
     * Set Branch
     * @param $branch
     * @return void
     */
    private function setBranch($branch): void
    {
        $this->branch = $branch;
    }

    /**
     * Set Module
     * @param $module
     * @return void
     */
    private function setModule($module): void
    {
        $this->module = $module;
    }


    /**
     * Set Ref id
     * @param $refid
     * @return void
     */
    private function setRefid($refid): void
    {
        $this->refid = $refid;
    }

    /**
     * Set Client ID
     * @param string $clientID
     * @return void
     */
    private function setClientID(string $clientID): void
    {
        $this->clientID = $clientID;
    }

    /**
     * Set Object
     * @param string $object
     * @return void
     */
    public function setObject(string $object): void
    {
        $this->object = $object;
    }

    /**
     * Get Object
     * @return string|null
     */
    public function getObject(): string|null
    {
        return $this->object;
    }

    /**
     * Set Key
     * @param int|string|null $key
     * @return void
     */
    public function setKey(null|int|string $key): void
    {
        $this->key = $key;
    }

    /**
     * Get Key
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set Filters or append to the existing filters
     * @param string $filters
     * @return void
     */
    public function setFilters(string $filters): void
    {
        if (isset($this->filters)) {
            $this->filters = $this->filters . '&&' . $filters;
        } else {
            $this->filters = $filters;
        }
    }

    /**
     * Get Filters
     * @return string
     */
    public function getFilters(): string
    {
        return $this->filters;
    }

    /**
     * Set List
     * @param string $list
     * @return void
     */
    public function setList(string $list): void
    {
        $this->list = $list;
    }

    /**
     * Get List
     * @return string
     */
    public function getList(): string
    {
        return $this->list;
    }

    /**
     * Locate
     * @param string $locate
     * @return void
     */
    public function locate(string $locate): void
    {
        $this->locateInfo = $locate;
    }

    /**
     * Start
     * @param string|integer $start
     * @return void
     */
    public function start(string|int $start): void
    {
        $this->start = $start;
    }

    /**
     * Limit
     * @param string|integer $limit
     * @return void
     */
    public function limit(string|int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Set Req ID
     * @param string $reqID
     * @return void
     */
    public function setReqId(string $reqID): void
    {
        $this->reqID = $reqID;
    }

    /**
     * Get Req ID
     * @return string
     */
    public function getReqId(): string
    {
        return $this->reqID;
    }

    /**
     * Set Request Data
     * @param mixed $data
     * @return void
     */
    public function setRequestData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * Get Request Data
     * @return string
     */
    public function getRequestData(): string
    {
        return $this->data;
    }

    /**
     * Set Page Number of HTML report
     * Valid only when using service getReportData
     * @param $pagenum
     * @return void
     */
    public function setPageNumber($pagenum): void
    {
        $this->pagenum = $pagenum;
    }

    /**
     * Get Page Number of HTML report
     * Valid only when using service getReportData
     * @return int|null
     */
    public function getPageNumber(): int|null
    {
        return $this->pagenum;
    }

    /**
     * Set Any Property set('Property Name', 'Property Value')
     * @param string $key
     * @param string|null $value
     * @return void
     */
    public function set(string $key, string|null $value): void
    {
        $this->$key = $value;
    }

    /**
     * Get Any Property
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return $this->$key;
    }


    /**
     * Constructor
     * @throws Exception
     */
    public function __construct(
        $username   = null,
        $password   = null,
        $appID      = null,
        $company    = null,
        $branch     = null,
        $module     = null,
        $refid      = null,
    ) {
        $this->setService('login');
        $this->setUsername($username ?? config('softone.SOFTONE_USER'));
        $this->setPass($password ?? config('softone.SOFTONE_PASS'));
        $this->setAppId($appID ?? config('softone.SOFTONE_APPID'));
        $this->setCompany($company ?? config('softone.SOFTONE_COMPANY'));
        $this->setBranch($branch ?? config('softone.SOFTONE_BRANCH'));
        $this->setModule($module ?? config('softone.SOFTONE_MODULE'));
        $this->setRefid($refid ?? config('softone.SOFTONE_REFID'));

        $response = $this->send();

        $this->setClientID($response->clientID ?? null);
    }

    /**
     * Set Requests Body
     * @return array
     */
    public function setBody(): array
    {

        $this->body = [
            "service"       => $this->service ?? null,
            "clientID"      => $this->clientID ?? null,
            "username"      => $this->username ?? null,
            "password"      => $this->password ?? null,
            "appId"         => $this->appId ?? null,
            "COMPANY"       => $this->company ?? null,
            "BRANCH"        => $this->branch ?? null,
            "MODULE"        => $this->module ?? null,
            "REFID"         => $this->refid ?? null,
            "USERID"        => $this->userid ?? null,
            "OBJECT"        => $this->object ?? null,
            "TABLE"         => $this->table ?? null,
            "LIST"          => $this->list ?? null,
            "FILTERS"       => $this->filters ?? null,
            "PAGENUM"       => $this->pagenum ?? null,
            "reqID"         => $this->reqID ?? null,
            "START"         => $this->start ?? null,
            "LIMIT"         => $this->limit ?? null,
            "FORM"          => $this->form ?? "",
            "KEY"           => $this->key ?? null,
            "data"          => $this->data ?? null,
            "LOCATEINFO"    => $this->locateInfo ?? "",
            "EDITOR"        => $this->editor ?? null,
            "VALUE"         => $this->editorValue ?? null,
            "TABLENAME"     => $this->tableName ?? null,
            "KEYNAME"       => $this->keyName ?? null,
            "KEYVALUE"      => $this->keyValue ?? null,
            "RESULTFIELDS"  => $this->resultFields ?? null,

        ];

        /* remove null */
        foreach ($this->body as $key => $value) {
            if (!isset($value)) {
                unset($this->body[$key]);
            }
        }

        return $this->body;
    }

    /**
     * Get Requests Body
     * @return array|null[]
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * Reset the request body for the next request
     * @return void
     */
    private function resetBody(): void
    {
        $this->service      = null;
        $this->username     = null;
        $this->password     = null;
        $this->company      = null;
        $this->branch       = null;
        $this->module       = null;
        $this->refid        = null;
        $this->userid       = null;
        $this->reqID        = null;
        $this->object       = null;
        $this->filters      = null;
        $this->list         = null;
        $this->table        = null;
        $this->pagenum      = null;
        $this->start        = null;
        $this->limit        = null;
        $this->form         = null;
        $this->key          = null;
        $this->locateInfo   = null;
        $this->editor       = null;
        $this->editorValue  = null;
        $this->tableName    = null;
        $this->keyName      = null;
        $this->keyValue     = null;
        $this->resultFields = null;

        $this->setBody();
    }

    /**
     * Save the response fields from getBrowserInfo
     *
     * @return Collection|mixed|null
     *
     */
    public function saveFields(): mixed
    {

        if (isset($this->response->fields)) {

            $this->fields = collect(Arr::pluck($this->toArray()['fields'], 'name'));
        }

        return $this->fields ?? null;
    }

    /**
     * Combines the fields position with the value
     * for example "CUSTOMER.CODE" => "000000000000"
     *             "CUSTOMER.NAME" => "TEST COMPANY"
     *
     */

    public function combine()
    {
        if (isset($this->fields) && isset($this->response->rows)) {

            foreach ($this->response->rows as $row) {

                if (collect($row)->count() != $this->fields->count()) {
                    return false;
                }

                $this->responseData[] = $this->fields->combine(collect($row));
            }
        }

        return $this->responseData ?? null;
    }

    /**
     * Send the request and save the response to the response property
     * @return Response|mixed
     * @throws Exception
     */
    public function send(): mixed
    {
        $this->setBody();

        if (empty($this->body)) {
            throw new Exception("the body of the request is not defined or empty");
        }

        $response = Http::post(config('softone.SOFTONE_URL'), $this->body)->throw();

        $this->response = json_decode(iconv("windows-1253", "UTF-8//IGNORE", $response->body()));

        if ($response->successful()) {

            switch ($this->service) {
                case ServiceName::BrowserInfo->value:
                    $this->saveFields();
                    break;
                case ServiceName::BrowserData->value:
                    $this->combine();
                    break;
                case ServiceName::ReportData->value:
                    return iconv("windows-1253", "UTF-8", $response->body());
            }

            /* prepare for the next request */
            $this->resetBody();

            return $this->response;
        }

        if (empty($this->response)) {
            throw new Exception("Response body is empty");
        }

        if (!$this->response->success) {
            throw new \ErrorException($this->response->error, $this->response->errorcode);
        }


        throw new Exception('ERROR:' . $response->body());
    }

    /**
     * Get the index of field named 'Key' from the getBrowserInfo response
     * @param mixed $response
     * @param string $key
     * @return string|null
     */
    public function getIndexOfFieldName(mixed $response, string $key): ?string
    {

        if (isset($response->fields)) {

            $indexes = array_flip(Arr::pluck($response->fields, 'name'));
        }

        return $indexes[$key] ?? null;
    }

    /**
     * Get the index of field named 'Key' from the getBrowserInfo response
     * @param string $key
     * @return string|null
     */
    public function getIndex(string $key): ?string
    {

        if (isset($this->response->fields)) {

            $indexes = array_flip(Arr::pluck($this->response->fields, 'name'));
        }

        return $indexes[$key] ?? null;
    }

    public function toArray(): array
    {
        if (isset($this->response)) {
            return json_decode(json_encode($this->response), true);
        }

        return [];
    }

    /**
     * Set Editor key (getSelectorData)
     * @param string $editor
     * @return void
     */
    public function setEditor(string $editor): void
    {
        $this->editor = $editor;
    }

    /**
     * Set Editor value (getSelectorData)
     * @param string|null $value
     * @return void
     */
    public function setEditorValue(?string $value): void
    {
        $this->editorValue = $value;
    }

    /**
     * Set Table name (selectorFields)
     * @param string $tableName
     * @return void
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * Set Key name (selectorFields)
     * @param string $keyName
     * @return void
     */
    public function setKeyName(string $keyName): void
    {
        $this->keyName = $keyName;
    }

    /**
     * Set Key value (selectorFields)
     * @param int|string $keyValue
     * @return void
     */
    public function setKeyValue(int|string $keyValue): void
    {
        $this->keyValue = $keyValue;
    }

    /**
     * Set Result fields (selectorFields) — comma-separated field names
     * @param string $resultFields
     * @return void
     */
    public function setResultFields(string $resultFields): void
    {
        $this->resultFields = $resultFields;
    }
}
