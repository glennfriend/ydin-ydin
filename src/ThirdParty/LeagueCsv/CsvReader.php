<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\LeagueCsv;

use Generator;
use League\Csv\Reader;
use League\Csv\Statement;

/**
 * csv reader wrap
 *
 * @composer require "league/csv:^9.1.4"
 *
 */
class CsvReader
{
    /**
     * @var null
     */
    protected $csv = null;

    /**
     * @var array
     */
    protected $hooks = [];

    /**
     * CsvReader constructor.
     * @param $file
     * @throws \League\Csv\Exception
     */
    public function __construct($file)
    {
        $this->csv = Reader::createFromPath($file, 'r');
        $this->csv->setHeaderOffset(0);
    }

    public function addHook($func)
    {
        if ($func instanceof \Closure) {
            $this->hooks[] = $func;
        }
    }

    /**
     * @return Generator
     * @throws \League\Csv\Exception
     */
    public function each(): Generator
    {
        $header = $this->getNewHeader();
        // echo "test, trigger only one time.\n";

        $isCallHooks = false;
        if ($this->hooks) {
            $isCallHooks = true;
        }

        //
        $offset = 0;
        $limit = 10000;
        do {
            $stmt = (new Statement())
                ->offset($offset)
                ->limit($limit);

            $resultSet = $stmt->process($this->csv, $header);

            if ($resultSet->count() <= 0) {
                break;
            }

            foreach ($resultSet as $row) {
                $row = array_combine($header, array_values($row));
                $row = $this->unusedCodeFilter($row);
                if ($isCallHooks) {
                    foreach ($this->hooks as $hookFunction) {
                        $row = $hookFunction($row);
                    }
                }

                yield $row;
            }

            // 每次只從 csv file 取出一定數量的資料
            $offset += $limit;

        } while (true);

    }

    // --------------------------------------------------------------------------------
    //  for header
    // --------------------------------------------------------------------------------

    /**
     * @return array
     */
    protected function getNewHeader(): array
    {
        $header = [];
        $originHeader = $this->csv->getHeader(); // return the CSV header record
        foreach ($originHeader as $key) {
            $header[] = $this->headerConvert($key);
        }
        unset($originHeader);
        $header = $this->fixDuplicatedName($header);

        return $header;
    }

    /**
     * 將 header name 轉為乾淨的字串
     *
     * e.g.
     *      "Current Date"  => "current_date"
     *      "Current-Date"  => "current_date"
     *      "___a___b___"   => "a_b"
     *      " # HTML 標題:"  => "html"
     *      ""              => ""
     *
     * @param $value
     * @return string
     */
    protected function headerConvert($value): string
    {
        $value = str_replace(['-', ' ', '&'], '_', $value);
        $value = preg_replace("/[^a-zA-Z0-9_]+/", '', $value);
        $value = preg_replace('/_+/', '_', $value);

        // last modify
        $value = trim($value, '_');
        $value = strtolower(trim($value));
        return $value;
    }

    /**
     * 處理重覆的 (欄位) 名稱
     * 欄位後方加上 _duplicated_2
     *
     * @param array $originRow
     * @return array
     */
    protected function fixDuplicatedName(array $originRow): array
    {
        $modifyName = function ($names, $currentName) {
            $index = 2;
            do {
                $name = $currentName . '_duplicated_' . $index;
                if (!in_array($name, $names)) {
                    return $name;
                }
                $index++;
                if ($index > 100) {
                    break;
                }
            } while (true);

            return $currentName;
        };

        $row = [];
        foreach ($originRow as $name) {
            if (!in_array($name, $row)) {
                $row[] = $name;
            } else {
                $row[] = $modifyName($row, $name);
            }
        }

        return $row;
    }

    // --------------------------------------------------------------------------------
    //  for values
    // --------------------------------------------------------------------------------

    /**
     *  Clean invisible control characters and unused code points
     *
     *  \p{C} or \p{Other}: invisible control characters and unused code points.
     *      \p{Cc} or \p{Control}: an ASCII 0x00–0x1F or Latin-1 0x80–0x9F control character.
     *      \p{Cf} or \p{Format}: invisible formatting indicator.
     *      \p{Co} or \p{Private_Use}: any code point reserved for private use.
     *      \p{Cs} or \p{Surrogate}: one half of a surrogate pair in UTF-16 encoding.
     *      \p{Cn} or \p{Unassigned}: any code point to which no character has been assigned.
     *
     *  feature
     *      - 該程式可以清除 RIGHT-TO-LEFT MARK (200F)
     *      - 資料針對 "值", 所以提供 array 的輸入輸出
     *
     * @see http://www.regular-expressions.info/unicode.html
     *
     * @param array $row
     * @return array
     */
    protected function unusedCodeFilter(array $row): array
    {
        foreach ($row as $key => $value) {
            $row[$key] = preg_replace('/\p{C}+/u', "", $value);
        }
        return $row;
    }

}
