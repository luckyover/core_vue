<?php

namespace App\Services;

use DB;
use IdentityService;
use Illuminate\Support\Facades\File;
use NotAcceptableException;
use PDO;

class DbService
{
    const FROM_ENCODING = 'SJIS';

    const TO_ENCODING = 'UTF-8';

    const NUMBER_OF_LOG_FILE = 365;

    const DEFAULT_OPTION = [
        'escape_value' => [],
        'debug' => false,
        'meta_flag' => false,
        'is_get_data_default' => false,
        'decode_html' => true,
        'convert_encoding_key' => false,
        'is_no_result' => false,
    ];

    private $executeTime = 0;

    public function __construct()
    {
    }

    /**
     * Check have error data from SPC or not
     * Created: 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param array Data from SPC
     * @return bool true - if not error, false - if have error from DB, Exception if SPC have exception
     */
    public static function hasDatabaseError($result)
    {
        if (empty($result)) {
            return false;
        } // haven't error
        // Check SQL error
        if (isset($result[0][0]['error_typ']) && $result[0][0]['error_typ'] != 0 && $result[0][0]['error_typ'] != '') {
            // Logic error
            throw new NotAcceptableException($result[0][0]['message_cd'], $result[0]);
        }

        return false;
    }

    /**
     * Call store procedure and get data from stote procedute to return
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $sProcedure Name of SPC will call
     * @param array $aParams array have params of SPC
     * @param array $option Options for call SPC
     * @return array Data from SPC
     */
    public static function execSQL($sProcedure, $aParams = [], $option = [])
    {
        $result = [];
        try {
            // get object of DAO for some common process for Database
            $this_ = new DbService;
            $aParams = DbService::addCommonParams($aParams);
            if (isset($option['fake_data'])) {
                $this_->writeLogFile($sProcedure, $aParams);

                return $option['fake_data'];
            }
            // get default options
            $option = $this_->getDefaultOptions($option);
            // if is debug then return SQL command whit style to client
            if ($option['debug']) {
                echo $this_->debugQuery($sProcedure, $aParams);
                exit;
            }
            $stmt = $this_->callSPC($sProcedure, $aParams, $option);
            $result = $this_->getDataFromSPC($stmt, $option);
            $this_->writeLogFile($sProcedure, $aParams);
        } catch (\Exception $e) {
            $this_->writeLogFile($sProcedure, $aParams);
            throw $e;
        }

        return $result;
    }

    /**
     * add common params to code
     * Created: 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param array Param for SPC
     * @return array Param for SPC with more common params
     */
    public static function addCommonParams($params)
    {
        $userId = IdentityService::GetCurrentUserId();
        $IP = IdentityService::GetIPAddress();
        $prg = 'SPKL';
        $headers = getallheaders();
        if (isset($headers['X-Screen-Id'])) {
            $prg = $headers['X-Screen-Id'];
        }
        $prefixParam = [
        ];
        $result = array_merge(
            $prefixParam,
            $params,
            [
                'act_user_cd' => $userId ?? '',
                'pgr' => $prg,
                'ip' => $IP,
            ]
        );

        return $result;
    }

    /**
     * Get value default of options if not set
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param array $option Options for call SPC
     * @return array Options with default value
     */
    protected function getDefaultOptions($option)
    {
        try {
            if (!isset($option) || count($option) == 0) {
                $option = self::DEFAULT_OPTION;
            } else {
                if (!isset($option['escape_value'])) {
                    $option['escape_value'] = self::DEFAULT_OPTION['escape_value'];
                }
                if (!isset($option['debug'])) {
                    $option['debug'] = self::DEFAULT_OPTION['debug'];
                }
                if (!isset($option['meta_flag'])) {
                    $option['meta_flag'] = self::DEFAULT_OPTION['meta_flag'];
                }
                if (!isset($option['is_get_data_default'])) {
                    $option['is_get_data_default'] = self::DEFAULT_OPTION['is_get_data_default'];
                }
                if (!isset($option['decode_html'])) {
                    $option['decode_html'] = self::DEFAULT_OPTION['decode_html'];
                }
                if (!isset($option['convert_encoding_key'])) {
                    $option['convert_encoding_key'] = self::DEFAULT_OPTION['convert_encoding_key'];
                }
                $option['debug'] = $option['debug'] === true || $option['debug'] == 'true';
                $option['meta_flag'] = $option['meta_flag'] === true || $option['meta_flag'] == 'true';
                $option['is_get_data_default'] = $option['is_get_data_default'] === true || $option['is_get_data_default'] == 'true';
                $option['decode_html'] = $option['decode_html'] === true || $option['decode_html'] == 'true';
                $option['convert_encoding_key'] = $option['convert_encoding_key'] === true || $option['convert_encoding_key'] == 'true';
            }

            return $option;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Execute a store procedure
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $sProcedure Name of SPC will call
     * @param array $aParams array have params of SPC
     * @param array $option Options for call SPC
     * @return PDOStatement an associated result set
     */
    protected function callSPC($sProcedure, $aParams, $option)
    {
        try {
            // create database connection
            $db = DB::connection()->getPdo();
            $db->setAttribute(constant('PDO::SQLSRV_ATTR_DIRECT_QUERY'), true);
            // allow get data decimals
            $db->setAttribute(PDO::SQLSRV_ATTR_FORMAT_DECIMALS, true);
            //
            $db->query('SET NOCOUNT ON');
            // if any params are present, add them
            $sParamsIn = '';
            if (isset($aParams) && is_array($aParams) && count($aParams) > 0) {
                // loop through params and set
                foreach ($aParams as $sParam) {
                    $sParamsIn .= '?,';
                }
                // trim the last comma from the params in string
                $sParamsIn = substr($sParamsIn, 0, strlen($sParamsIn) - 1);
            }

            $from = microtime(true);
            // create initial stored procedure call
            $stmt = $db->prepare("{CALL $sProcedure($sParamsIn)}");
            $to = microtime(true);
            $this->executeTime = $to - $from;

            // if any params are present, add them
            if (isset($aParams) && is_array($aParams) && count($aParams) > 0) {
                $iParamCount = 1;
                // loop through params and bind value to the prepare statement
                foreach ($aParams as $key => &$value) {
                    if (in_array($key, $option['escape_value'])) {
                        $value = $this->sqlServerEscapeString($value);
                    }
                    $stmt->bindParam($iParamCount, $value);
                    $iParamCount++;
                }
            }

            // execute the stored procedure
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $stmt;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get all data had returned from SPC
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param PDOStatement $stmt an associated result set
     * @param array $option Options for how to get Data
     * @return array Data from SPC
     */
    protected function getDataFromSPC($stmt, $option)
    {
        try {
            if ($option['is_no_result']) {
                return [];
            }
            $result = [];
            $i = 0;
            do {
                while ($response = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    foreach ($response as $key_from_encoding => $res_from_encoding) {
                        $key_to_encoding = $option['convert_encoding_key'] ? mb_convert_encoding($key_from_encoding, self::TO_ENCODING, self::FROM_ENCODING) : $key_from_encoding;
                        if (gettype($res_from_encoding) == 'string') {
                            $res_from_encoding = $option['decode_html'] ? htmlspecialchars_decode($res_from_encoding) : htmlspecialchars($res_from_encoding);
                        }
                        if ($option['convert_encoding_key']) {
                            unset($response[$key_from_encoding]);
                        }
                        $response[$key_to_encoding] = $res_from_encoding;
                    }
                    $result[$i][] = $response;
                }

                if ($option['is_get_data_default'] && !isset($result[$i])) {
                    $result[$i] = $this->getDefaultValueOfColumns($stmt);
                }
                // if need to get meta data
                if ($option['meta_flag']) {
                    // then add meta data to the result
                    $result['meta_data' . $i] = $this->getAllColumnMetaData($stmt);
                }
                $i++;
            } while ($stmt->nextRowset());

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Write a SQL command had executed to a file log
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $sProcedure Name of SPC will call
     * @param array $aParams array have params of SPC
     */
    protected function writeLogFile($sProcedure, $aParams)
    {
        try {
            // Logging
            $log_sql = 'EXEC ' . $sProcedure . " '" . implode("','", $aParams) . "';";
            $time = date('Y-m-d H:i:s');
            $execTime = round($this->executeTime / 1000.0, 4) . 'ms';
            if ($this->executeTime > 1000000) {
                $execTime = round($this->executeTime / 1000000.0, 4) . 's';
            }

            // path to folder log
            $path = storage_path('logs');
            // path to current file log
            $path_files_log = $path . DIRECTORY_SEPARATOR . date('Y-m-d') . '_query.log';

            // write log to file
            $logFile = fopen($path_files_log, 'a+');
            fwrite($logFile, $time . ' (' . $execTime . ')' . "\t: " . $log_sql . PHP_EOL);
            fclose($logFile);

            // Get current list file log
            $files = File::files($path);
            // get index of current day log file
            $files_log_index = array_search($path_files_log, $files);
            // Delete old file log file except newest NUMBER_OF_LOG_FILE files
            if ($files_log_index > self::NUMBER_OF_LOG_FILE) {
                $index = $files_log_index - self::NUMBER_OF_LOG_FILE;
                for ($i = 0; $i <= $index; $i++) {
                    File::delete($files[$i]);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Create a html code have content of SQL command
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $query Name of SPC will call
     * @param array $params array have params of SPC
     * @return string Html code have content of SQL command
     */
    protected function debugQuery($query, $params)
    {
        try {
            $quote_css = '<span style="color:#FF0000;">' . "'" . '</span>';
            $comma_css = '<span style="color:#808080;">,</span>';
            $semicolon_css = '<span style="color:#808080;">;</span>';
            $str_css = '</span>' . $quote_css;
            $str_css .= $comma_css;
            $str_css .= $quote_css . '<span style="color:#FF0000;">';
            $params_str = implode($str_css, $params);
            $query = '<span style="color:#0000FF;">EXEC</span>' . "<span> $query </span>";
            $query .= $quote_css . '<span style="color:#FF0000;">' . $params_str . '</span>' . $quote_css . $semicolon_css;

            return '<div>
                        <span>SQL Debug:<span>
                        <br>
                        <pre style="display: block;color: #000;font-size: 16px;background-color: #eff0f1;">
                            <code>' . $query . '</code>
                        </pre>
                    </div>
                    <br>';
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Create a row have value default of table had returned from store procedure
     * if table have not any row
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param PDOStatement $statement an associated result set
     * @return array Row data default
     */
    protected function getDefaultValueOfColumns($statement)
    {
        try {
            $columns = [];
            for ($i = 0; $i < $statement->columnCount(); $i++) {
                $col = $statement->getColumnMeta($i);
                $columns[0][$col['name']] = $this->setDefaultByType($col['sqlsrv:decl_type']);
            }

            return $columns;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get all meta data of all column of a table had returned from store procedure
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param PDOStatement $statement an associated result set
     * @return array list meta data of all column
     */
    protected function getAllColumnMetaData($statement)
    {
        try {
            $columns = [];
            for ($i = 0; $i < $statement->columnCount(); $i++) {
                $columns[] = $statement->getColumnMeta($i);
            }

            return $columns;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Set default value (follow type of data returned in SQL Server) for data return from store procedure if store procedure not have any record
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $mssql_type Type in SQL Server of column had returned
     * @return string|null Default value. Or null if $mssql_type not match any type
     */
    private function setDefaultByType($mssql_type)
    {
        try {
            $default = null;
            switch (strtoupper($mssql_type)) {
                case 'BIT':
                    $default = '';
                    break;
                case 'TINYINT':
                case 'SMALLINT':
                case 'MEDIUMINT':
                case 'INT':
                case 'INTEGER':
                case 'BIGINT':
                    $default = '';
                    break;
                case 'FLOAT':
                case 'DOUBLE':
                case 'DECIMAL':
                    $default = '';
                    break;
                case 'CHAR':
                case 'ENUM':
                case 'SET':
                case 'VARCHAR':
                case 'NVARCHAR':
                    $default = '';
                    break;
                case 'TINYTEXT':
                case 'TEXT':
                case 'MEDIUMTEXT':
                case 'LONGTEXT':
                    $default = '';
                    break;
                case 'BINARY':
                case 'VARBINARY':
                case 'BLOB':
                case 'TINYBLOB':
                case 'MEDIUMBLOB':
                case 'LONGBLOB':
                    $default = '';
                    break;
                case 'DATE':
                case 'TIME':
                case 'DATETIME':
                case 'TIMESTAMP':
                case 'YEAR':
                    $default = '';
                    break;
                default:
                    $default = '';
                    break;
            }

            return $default;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Replace all special character of SQL Server for use operator '+' string in query
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $input String need to escape
     * @return string|null String after escape or null if input string is null
     */
    public static function sqlServerEscapeString($input)
    {
        try {
            if ($input === null) {
                $input = null;
            }
            $input = str_replace('[', '[[]', $input);
            $input = str_replace('%', '[%]', $input);
            $input = str_replace('_', '[_]', $input);
            $input = str_replace('\\', '[\\]', $input);
            $input = str_replace('\'', '\'\'', $input);

            return $input;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
