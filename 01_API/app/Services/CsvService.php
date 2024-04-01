<?php

namespace App\Services;

class CsvService
{
    // CSV_EXPORT_PATH : Directory for CSV,Excel data Export
    public const CSV_EXPORT_PATH = '/export/csv/';

    // CSV_BACKUP_PATH : Backup file directory for CSV data import
    public const CSV_BACKUP_PATH = '/backup/csv/';

    public function __construct()
    {
    }

    /**
     * Read data in CSV file
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $csvfile Path to csv file
     * @param int $enctype endcode to SJIS or not ($enctype = 1 for will endcode)
     * @return array Data in CSV file
     */
    public static function readCSV($csvfile, $enctype = 0)
    {
        if (file_exists($csvfile)) {
            setlocale(LC_ALL, 'ja_JP.UTF-8');
            $fp = fopen($csvfile, 'r');
            $headers = fgetcsv($fp); // Get column headers
            $headers[0] = preg_replace('/\x{FEFF}/u', '', $headers[0]);
            $data = [];
            $dataError = [];
            $idx = 1;
            while (($row = fgetcsv($fp)) !== false) {
                if (count($headers) == count($row)) {
                    $data[] = array_combine($headers, $row);
                } else {
                    $dataError[] = $idx;
                }
                $idx++;
            }
            fclose($fp);
            if (count($dataError) > 0) {
                return [
                    'error' => true,
                    'data' => $dataError,
                ];
            }

            return $data;
        }
    }

    /**
     * Read data in a line of CSV file
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $string line in CSV file
     * @param string $separator split each column in line, default is ","
     * @return array Data of line
     */
    public static function getCSVValues($string, $separator = ',')
    {
        $elements = explode($separator, $string);
        for ($i = 0; $i < count($elements); $i++) {
            $nquotes = substr_count($elements[$i], '"');
            if ($nquotes % 2 == 1) {
                for ($j = $i + 1; $j < count($elements); $j++) {
                    if (substr_count($elements[$j], '"') % 2 == 1) {
                        // Look for an odd-number of quotes
                        // Put the quoted string's pieces back together again
                        array_splice($elements, $i, $j - $i + 1,
                            implode($separator, array_slice($elements, $i, $j - $i + 1)));

                        break;
                    }
                }
            }
            if ($nquotes > 0) {
                // Remove first and last quotes, then merge pairs of quotes
                $qstr = & $elements[$i];
                $qstr = substr_replace($qstr, '', strpos($qstr, '"'), 1);
                $qstr = substr_replace($qstr, '', strrpos($qstr, '"'), 1);
                $qstr = str_replace('""', '"', $qstr);
            }
        }

        return $elements;
    }

    /**
     * Create a CSV file from array data
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $content data will write to file
     * @param string $title title of each column
     * @param string $folder folder to save file
     * @param string $fileName name of file will save
     * @param string $save save file to disk or not
     * @param string $delimiter character split each column
     * @param string $enclosure enclosure for data in each column
     * @return string|bool false if not export, if export success will return path of file of data file
     */
    public static function writeCsv($content = [], $title = [], $folder = '', $fileName = '', $save = true, $delimiter = ',', $enclosure = '')
    {
        $path = storage_path() . self::CSV_EXPORT_PATH;
        if ($folder != '') {
            $path = $path . $folder . '/';
        }
        //$path        = mb_convert_encoding($path, 'CP932', 'UTF-8');
        $folderTemp = $path . 'temp/';
        $tempPathFile = $folderTemp . $fileName;
        //Convert array content to string
        $content = self::arrayToCsv($content, $delimiter, $enclosure);
        $temp = '';
        if (!empty($title)) {
            $dataTitle = '';
            foreach ($title as $value) {
                $dataTitle .= $enclosure . $value . $enclosure . $delimiter;
                // Encoding to SJIS
                // $dataTitle .= $enclosure . mb_convert_encoding($value, "SJIS-win", "auto") . $enclosure . $delimiter;
            }
            $dataTitle = substr($dataTitle, 0, -1);
            $temp = chr(0xEF) . chr(0xBB) . chr(0xBF);
            $temp .= $dataTitle . PHP_EOL;
        } else {
            $temp = chr(0xEF) . chr(0xBB) . chr(0xBF);
        }
        $temp .= $content;
        //Check folder exists
        if (!file_exists($folderTemp)) {
            mkdir($folderTemp, 0777, true);
        }
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if (file_exists($tempPathFile)) {
            unlink($tempPathFile);
        }
        //Create and Open file
        $file = fopen($tempPathFile, 'w');
        fwrite($file, $temp);
        fclose($file);
        //Convert file name UTF-8 to Japanese (CP932)
        // $pathFile     = $path.mb_convert_encoding($fileName, 'CP932', 'UTF-8');
        $pathFile = $path . $fileName;
        //Copy file temp to destination path
        $copy = \File::copy($tempPathFile, $pathFile);
        if ($copy == true) {
            if ($save == false) {
                return response()->download($tempPathFile)->deleteFileAfterSend(true);
            } else {
                unlink($tempPathFile);

                //$pathFile     = mb_convert_encoding($pathFile, 'UTF-8','CP932');
                return $pathFile;
            }
        } else {
            return false;
        }
    }

    /**
     * Create content of csv file from aray content
     * Created      : 2024/01/06
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @param string $content data will write to file
     * @param string $delimiter character split each column
     * @param string $enclosure enclosure for data in each column
     * @return string|bool false if not export, if export success will return path of file of data file
     */
    public static function arrayToCsv(array &$contents, $delimiter = ',', $enclosure = '"')
    {
        try {
            $data = '';
            $numItems = count($contents);
            $i = 0;
            foreach ($contents as $key => $value) {
                foreach ($value as $k => $v) {
                    $data .= $enclosure . strval($v) . $enclosure . $delimiter;
                    // Encoding to SJIS
                    // $data .= $enclosure . mb_convert_encoding($v, "SJIS-win", "auto") . $enclosure . $delimiter;
                }
                $data = substr($data, 0, -1);
                if (++$i < $numItems) {
                    $data .= PHP_EOL;
                }
            }

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }
}
