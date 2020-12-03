<?php
declare(strict_types=1);

namespace Ydin\Data;

/**
 * 2020x 年每個 state 下的 area code
 *
 * @see https://www.allareacodes.com/area_code_listings_by_state.htm
 */
class UsStateAreaCode
{

    /**
     * @param string $code
     * @return array|null
     */
    public static function getByStateCode(string $code): ?array
    {
        $rows = array_column(static::getAll(), 'code');
        $index = array_search($code, $rows);
        if (false === $index) {
            return null;
        }

        return static::getByIndex($index);
    }

    /**
     * @param int $index
     * @return array|null
     */
    public static function getByIndex(int $index): ?array
    {
        $data = static::getAll();
        if (!isset($data[$index])) {
            return null;
        }

        return $data[$index];
    }

    /**
     * State Name & State Code
     *
     * @return array
     */
    public static function getAll(): array
    {
        return static::getOriginData();
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

    /**
     * @return array
     */
    protected static function getOriginData()
    {
        return [
            ['code' => 'MA', 'name' => 'Massachusetts', 'area_code' => [339, 351, 413, 508, 617, 774, 781, 857, 978]],
            ['code' => 'RI', 'name' => 'Rhode Island', 'area_code' => [401]],
            ['code' => 'NH', 'name' => 'New Hampshire', 'area_code' => [603]],
            ['code' => 'ME', 'name' => 'Maine', 'area_code' => [207]],
            ['code' => 'VT', 'name' => 'Vermont', 'area_code' => [802]],
            ['code' => 'CT', 'name' => 'Connecticut', 'area_code' => [203, 475, 860, 959]],
            ['code' => 'NY', 'name' => 'New York', 'area_code' => [212, 315, 332, 347, 516, 518, 585, 607, 631, 646, 680, 716, 718, 838, 845, 914, 917, 929, 934]],
            ['code' => 'NJ', 'name' => 'New Jersey', 'area_code' => [201, 551, 609, 640, 732, 848, 856, 862, 908, 973]],
            ['code' => 'PA', 'name' => 'Pennsylvania', 'area_code' => [215, 223, 267, 272, 412, 445, 484, 570, 610, 717, 724, 814, 878]],
            ['code' => 'DE', 'name' => 'Delaware', 'area_code' => [302]],
            ['code' => 'DC', 'name' => 'District of Columbia', 'area_code' => [202]],
            ['code' => 'VA', 'name' => 'Virginia', 'area_code' => [276, 434, 540, 571, 703, 757, 804]],
            ['code' => 'MD', 'name' => 'Maryland', 'area_code' => [240, 301, 410, 443, 667]],
            ['code' => 'WV', 'name' => 'West Virginia', 'area_code' => [304, 681]],
            ['code' => 'NC', 'name' => 'North Carolina', 'area_code' => [252, 336, 704, 743, 828, 910, 919, 980, 984]],
            ['code' => 'SC', 'name' => 'South Carolina', 'area_code' => [803, 843, 854, 864]],
            ['code' => 'GA', 'name' => 'Georgia', 'area_code' => [229, 404, 470, 478, 678, 706, 762, 770, 912]],
            ['code' => 'FL', 'name' => 'Florida', 'area_code' => [239, 305, 321, 352, 386, 407, 561, 727, 754, 772, 786, 813, 850, 863, 904, 941, 954]],
            ['code' => 'AL', 'name' => 'Alabama', 'area_code' => [205, 251, 256, 334, 938]],
            ['code' => 'TN', 'name' => 'Tennessee', 'area_code' => [423, 615, 629, 731, 865, 901, 931]],
            ['code' => 'MS', 'name' => 'Mississippi', 'area_code' => [228, 601, 662, 769]],
            ['code' => 'KY', 'name' => 'Kentucky', 'area_code' => [270, 364, 502, 606, 859]],
            ['code' => 'OH', 'name' => 'Ohio', 'area_code' => [216, 220, 234, 330, 380, 419, 440, 513, 567, 614, 740, 937]],
            ['code' => 'IN', 'name' => 'Indiana', 'area_code' => [219, 260, 317, 463, 574, 765, 812, 930]],
            ['code' => 'MI', 'name' => 'Michigan', 'area_code' => [231, 248, 269, 313, 517, 586, 616, 734, 810, 906, 947, 989]],
            ['code' => 'IA', 'name' => 'Iowa', 'area_code' => [319, 515, 563, 641, 712]],
            ['code' => 'WI', 'name' => 'Wisconsin', 'area_code' => [262, 414, 534, 608, 715, 920]],
            ['code' => 'MN', 'name' => 'Minnesota', 'area_code' => [218, 320, 507, 612, 651, 763, 952]],
            ['code' => 'SD', 'name' => 'South Dakota', 'area_code' => [605]],
            ['code' => 'ND', 'name' => 'North Dakota', 'area_code' => [701]],
            ['code' => 'MT', 'name' => 'Montana', 'area_code' => [406]],
            ['code' => 'IL', 'name' => 'Illinois', 'area_code' => [217, 224, 309, 312, 331, 618, 630, 708, 773, 779, 815, 847, 872]],
            ['code' => 'MO', 'name' => 'Missouri', 'area_code' => [314, 417, 573, 636, 660, 816]],
            ['code' => 'KS', 'name' => 'Kansas', 'area_code' => [316, 620, 785, 913]],
            ['code' => 'NE', 'name' => 'Nebraska', 'area_code' => [308, 402, 531]],
            ['code' => 'LA', 'name' => 'Louisiana', 'area_code' => [225, 318, 337, 504, 985]],
            ['code' => 'AR', 'name' => 'Arkansas', 'area_code' => [479, 501, 870]],
            ['code' => 'OK', 'name' => 'Oklahoma', 'area_code' => [405, 539, 580, 918]],
            ['code' => 'TX', 'name' => 'Texas', 'area_code' => [210, 214, 254, 281, 325, 346, 361, 409, 430, 432, 469, 512, 682, 713, 726, 737, 806, 817, 830, 832, 903, 915, 936, 940, 956, 972, 979]],
            ['code' => 'CO', 'name' => 'Colorado', 'area_code' => [303, 719, 720, 970]],
            ['code' => 'WY', 'name' => 'Wyoming', 'area_code' => [307]],
            ['code' => 'ID', 'name' => 'Idaho', 'area_code' => [208, 986]],
            ['code' => 'UT', 'name' => 'Utah', 'area_code' => [385, 435, 801]],
            ['code' => 'AZ', 'name' => 'Arizona', 'area_code' => [480, 520, 602, 623, 928]],
            ['code' => 'NM', 'name' => 'New Mexico', 'area_code' => [505, 575]],
            ['code' => 'NV', 'name' => 'Nevada', 'area_code' => [702, 725, 775]],
            ['code' => 'CA', 'name' => 'California', 'area_code' => [209, 213, 279, 310, 323, 408, 415, 424, 442, 510, 530, 559, 562, 619, 626, 628, 650, 657, 661, 669, 707, 714, 747, 760, 805, 818, 820, 831, 858, 909, 916, 925, 949, 951]],
            ['code' => 'HI', 'name' => 'Hawaii', 'area_code' => [808]],
            ['code' => 'OR', 'name' => 'Oregon', 'area_code' => [458, 503, 541, 971]],
            ['code' => 'WA', 'name' => 'Washington', 'area_code' => [206, 253, 360, 425, 509, 564]],
            ['code' => 'AK', 'name' => 'Alaska', 'area_code' => [907]],
        ];
    }


}
