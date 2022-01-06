<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Url;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * @version 0.1.0
 * @package Ydin\ThirdParty\Laravel\Url
 */
class UrlGrammar
{

    /**
     * feature
     *      - 產生 laravel links format
     *      - 可以不代入 $page, 由 Request 自動取得 'page' 參數
     *      - 可以不代入 $totalCount, 但是就不會產生 `last`, 並且 `next` 會無止境的產生
     *
     * example:
     *  {
     *      first: "http://127.0.0.1:8008/api/module/action-name?page=1",
     *      last: null,
     *      prev: null,
     *      next: "http://127.0.0.1:8008/api/module/action-name?page=2"
     *  }
     *
     * @param Request $request
     * @param array $options
     * @return array
     */
    public static function buildResponseLinks(Request $request, array $options): array
    {
        if (!$request instanceof Request) {
            return [];
        }

        $options += [
            'limit'      => 15,
            'page'       => null,
            'totalCount' => null,
        ];
        $options = self::processOptions($options, $request);
        $actionInfo = $options['actionInfo'];
        $urlInfo = $options['urlInfo'];
        $page = $options['page'];
        $lastPage = $options['lastPage'];

        //
        $urlInfo['page'] = 1;
        $first = action($actionInfo, $urlInfo);

        //
        $prev = null;
        if ($page > 1) {
            $urlInfo['page'] = $page - 1;
            $prev = action($actionInfo, $urlInfo);
        }

        //
        if ($lastPage) {
            if ($page >= $lastPage) {
                $urlInfo['page'] = $page;
                $next = null;
            } else {
                $urlInfo['page'] = $page + 1;
                $next = action($actionInfo, $urlInfo);
            }
        } else {
            $urlInfo['page'] = $page + 1;
            $next = action($actionInfo, $urlInfo);
        }


        //
        $last = null;
        if ($lastPage) {
            $urlInfo['page'] = $lastPage;
            $last = action($actionInfo, $urlInfo);
        }

        return [
            "first" => $first,
            "last"  => $last,
            "prev"  => $prev,
            "next"  => $next
        ];
    }

    /**
     * feature
     *      - 產生 laravel meta format, 但是這裡以 駝峰 方式顯示
     *      - 可以不代入 $page, 由 Request 自動取得 'page' 參數
     *      - 可以不代入 $totalCount, 但是就不會產生 `last`, 並且 `next` 會無止境的產生
     *
     * example:
     *  {
     *      path:           "http://example.com/pagination",
     *      currentPage:    1,
     *      lastPage:       1,
     *      perPage:        15,
     *      from:           1,
     *      to:             10,
     *      total:          10
     *  }
     *
     * @param Request $request
     * @param array $options
     * @return array
     */
    public static function buildResponseMeta(Request $request, array $options): array
    {
        if (!$request instanceof Request) {
            return [];
        }

        $options += [
            'limit'      => 15,
            'page'       => null,
            'totalCount' => null,
        ];
        $options = self::processOptions($options, $request);
        $actionInfo = $options['actionInfo'];
        $urlInfo = $options['urlInfo'];
        $limit = $options['limit'];
        $page = $options['page'];
        $totalCount = $options['totalCount'];
        $lastPage = $options['lastPage'];

        //
        $urlInfo['page'] = $page;
        $currentPath = action($actionInfo, $urlInfo);

        //
        return [
            "path"        => $currentPath,
            "currentPage" => $page,
            "lastPage"    => $lastPage,
            "perPage"     => $limit,
            // "from"        => null,
            // "to"          => null,
            "total"       => $totalCount,
        ];
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    /**
     * @param array $opt
     * @param Request $request
     * @return array
     */
    private static function processOptions(array $opt, Request $request): array
    {
        $opt['limit'] = (int)$opt['limit'];
        $opt['page'] = (int)$opt['page'];
        $opt['lastPage'] = null;
        if ($opt['totalCount']) {
            $opt['lastPage'] = (int)ceil($opt['totalCount'] / $opt['limit']);
        }

        [$controllerName, $method] = explode('@', Route::currentRouteAction());
        if (!$opt['page']) {
            $opt['page'] = (int)$request->input('page') ?? 1;
        }
        if ($opt['page'] < 1) {
            $opt['page'] = 1;
        }

        //
        $opt['urlInfo'] = self::queryParseByUrl($request->getRequestUri());
        $opt['actionInfo'] = [$controllerName, $method];
        return $opt;
    }

    /**
     * example
     *      "/api/module/action-name?page=1"
     *      =>
     *      [
     *          "page" => "1"
     *      ]
     *
     * @param string $url
     * @return array
     */
    private static function queryParseByUrl(string $url): array
    {
        $urlQuery = parse_url($url, PHP_URL_QUERY);
        parse_str($urlQuery, $urlInfo);
        return $urlInfo;
    }

}
