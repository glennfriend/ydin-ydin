<?php
declare(strict_types=1);
namespace Ydin\ThirdParty\Laravel\Http;

use Exception;
use Illuminate\Http\Request;

/**
 * parser query order
 *      - 可以指定要 parser 欄位的名稱
 *      - 預設的 parser field 為 'order'
 *      - 輸出的 sorting type 為大寫 'ASC' or 'DESC'
 *      - 輸出的 sorting type 有可能是   null
 *
 * param "order[]" (string)
 *      - 欄位名稱與排序方法 ASC/DESC
 *      - "field_name:sorting_type"
 *
 * Url query example
 *      ?page=1
 *      &order[]="age:ASC"
 *      &order[]="first_name:DESC"
 *
 * output example
 *      [
 *          [
 *              'name' => 'field_1',
 *              'type' => 'ASC',
 *          ],
 *          [
 *              'name' => 'field_2',
 *              'type' => null,
 *          ]
 *      ]
 * 
 * @version 0.1.0
 * @package Ydin\ThirdParty\Laravel\Http\RequestQueryOrderParser
 */
class RequestQueryOrderParser
{
    /**
     * 排序欄位名稱
     * @var string
     */
    protected $parserField = 'order';

    /**
     * sort string format
     * @var array
     */
    protected $sort;

    /**
     * @var string
     */
    const SortTypeAsc = 'ASC';

    /**
     * @var string
     */
    const SortTypeDesc = 'DESC';

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->parserByField($this->parserField, $request);
    }

    /**
     * @param string $fieldName
     * @param Request $request
     */
    public function parserByField(string $fieldName, Request $request)
    {
        $this->reset();
        $sorts = $this->getRequestSorts($request, $fieldName);
        $this->sort = $this->sortsFormat($sorts);
    }

    /**
     * 只取得第一個搜尋條件 的 欄位名稱
     * first field name
     *
     * @return null|string
     */
    public function name(): ?string
    {
        if (isset($this->sort[0])) {
            return $this->sort[0]['name'];
        } else {
            return null;
        }
    }

    /**
     * 只取得第一個搜尋條件 的 排序方式
     * first field name sort type
     *
     * @return null|string
     */
    public function type(): ?string
    {
        if (isset($this->sort[0])) {
            return $this->sort[0]['type'];
        } else {
            return null;
        }
    }

    /**
     * get reorganize sort string
     *
     * @return array
     */
    public function getSorts(): array
    {
        return $this->sort;
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * output e.g.
     *      [
     *          0 => "age:asc",
     *          1 => "created_at:desc",
     *      ]
     *
     * @param Request $reqeust
     * @param string $fieldName
     * @return array
     * @throws Exception
     */
    protected function getRequestSorts(Request $reqeust, string $fieldName): array
    {
        $sorts = $reqeust->get($fieldName);
        if (!is_array($sorts)) {
            throw new Exception('[RequestQueryOrderParser] order field must be an array');
        }

        return $sorts;
    }

    /**
     * output e.g.
     *  [
     *      [
     *          'name' => 'field_1',
     *          'type' => 'ASC',
     *      ],
     *      [
     *          'name' => 'field_2',
     *          'type' => null,
     *      ]
     *  ]
     *
     * @param null|string $sortString
     * @return array
     */
    protected function sortsFormat(array $sorts): array
    {
        $format = [];
        foreach ($sorts as $sortString) {

            $temp = explode(':', trim($sortString));
            $field = null;
            $sortType = null;
            if (isset($temp[0])) {
                $field = $temp[0];
            }
            if (isset($temp[1])) {
                $sortType = $temp[1];
            }

            $field = trim($field);
            if (!$field) {
                continue;
            }

            $sortType = strtoupper(trim($sortType));
            if ($sortType === static::SortTypeAsc) {
                $sortType = static::SortTypeAsc;
            } elseif ($sortType === static::SortTypeDesc) {
                $sortType = static::SortTypeDesc;
            } else {
                $sortType = null;
            }

            $format[] = [
                'name' => $field,
                'type' => $sortType,
            ];
        }

        return $format;
    }

    /**
     *
     */
    protected function reset()
    {
        $this->parserField = 'order';
        $this->sort = [];
    }
}

/*
## Url query criterion
```
RequestQueryFilterParser

filter (array)  過濾方式

Filter criterion part example
    lte  (<)  less than
    le   (<=) less than or equal to
    eq   (==) equal to
    neq  (!=) not equal to
    gte  (>=) greater than or equal to
    gt   (>)  greater than

Url query example
    ?page=1
    &filter[status]=enable
    &filter[age]=gte:18

Description
    - 準則可以不實作, 如果要實作就必須符合規範
    - 可以超出規範, 但不能相抵制
    - 不會規範預設值, 依照商業邏輯在 controller 裡面決定自己的預設值
    - 因為相容性的問題, 可以用 order 取代 sort 名稱
    - filter criterion from https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/Database/ExpressionBuilder/Index.html
```
*/
