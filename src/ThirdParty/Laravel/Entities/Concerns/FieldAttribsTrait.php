<?php
declare(strict_types=1);

namespace Ydin\ThirdParty\Laravel\Entities\Concerns;

/**
 * table attribs field
 * access json structure
 *
 * @property string $attribs
 */
trait FieldAttribsTrait
{

    /**
     * set attrib
     *
     * @param string $key
     * @param $value
     */
    public function setAttrib(string $key, $value)
    {
        if (!$this->attribs) {
            $this->attribs = '';
        }

        $rows = json_decode($this->attribs, true);
        $rows[$key] = $value;
        $rows = array_filter($rows, function ($value, $key) {
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        $this->attribs = json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttrib(string $key, $defaultValue = null)
    {
        if (!$this->attribs) {
            $this->attribs = '';
        }

        $rows = json_decode($this->attribs, true);

        return $rows[$key] ?? $defaultValue;
    }

}
