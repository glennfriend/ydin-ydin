<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Http\Controller\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ydin\String\StringConvert;
use Ydin\ThirdParty\Laravel\Url\UrlGrammar;

/**
 * 提供 Mold package 與 laravel JsonReosrce 配合的 laravel API 格式 output
 *
 * dependency
 *      - laravel response()
 *
 * @version 0.1.0
 * @package Ydin\ThirdParty\Laravel\Http\Controller\Traits
 */
trait JsonResourceResponse
{
    /**
     * feature
     *      - 拼組 ValueObject 給予 laravel JsonResource
     *      - 拼組 array data  給予 laravel JsonResource
     *      - 提供 links 資訊
     *      - 提供 meta 資訊
     *
     * @param Request $request
     * @param array $rows
     * @param array $options
     * @return array[]|JsonResponse
     */
    public function jsonResourceResponse(Request $request, array $rows, array $options = [])
    {
        $options += [
            'totalCount' => null,
            'limit'      => 15,
            'haveLinks'  => true,
            'haveMeta'   => false,
        ];
        $put = [
            'data' => [],
        ];
        if ($options['haveLinks']) {
            $put["links"] = [];
        }
        if (!$rows || count($rows) <= 0) {
            return $put;
        }

        if (is_array($rows[0])) {
            $put['data'] = $this->_processArrayData($rows);
        } else {
            $put['data'] = $this->_processJsonResourceData($rows);
        }

        if ($options['haveLinks']) {
            $responseLinkOption = [
                'totalCount' => $options['totalCount'],
                'limit'      => $options['limit'],
            ];
            $put["links"] = UrlGrammar::buildResponseLinks($request, $responseLinkOption);
        }

        if ($options['haveMeta']) {
            $responseLinkOption = [
                'totalCount' => $options['totalCount'],
                'limit'      => $options['limit'],
            ];
            $put["meta"] = UrlGrammar::buildResponseMeta($request, $responseLinkOption);
        }

        return response()->json($put);
    }

    // --------------------------------------------------------------------------------
    //  private
    // --------------------------------------------------------------------------------

    private function _processArrayData(array $rows): array
    {
        $data = [];
        foreach ($rows as $row) {
            $data[] = $row;
        }
        return $data;
    }

    private function _processJsonResourceData(array $rows): array
    {
        // guess JsonResource name
        $namespaceName = get_class($rows[0]);
        $path = StringConvert::namespaceToPath($namespaceName);
        $valueObjectName = basename($path);
        $jsonResourcePath = dirname(dirname($path)) . '/Http/Resources';
        $jsonResourceName = StringConvert::pathToNamespace($jsonResourcePath) . '\\' . $valueObjectName . 'Resource';

        $data = [];
        foreach ($rows as $vo) {
            $data[] = new $jsonResourceName($vo);
        }

        return $data;
    }
}
