<?php
namespace PageToolClasses;
/**
 * Displays banners indicating that a test version is running and that inputs are not recorded in real database
 *
 * @author adam
 */
class TestVersionIndicate
{
    /** The number of times to display 'test' in the navbar */
    const NAVBARNUM = 20;

    /** The number of times to display 'test' in the footer */
    const FOOTERNUM = 12;

    /**
 * @param string $position Should be either inNavBar or inFooter to denote which settings to sue
 */
    public function __construct($position)
    {
        self::isTest($position);
    }

    /**
     * @param $position
     * @return string
     */
    public static function isTest($position)
    {
        if ((isset($_SESSION)) && ($_SESSION['test'] == true)) {
            switch ($position) {
                case 'inNavBar':
                    self::displayTEST(self::NAVBARNUM);
                    echo '<hr style="width:90%;size:20;color:#FF0000;" />';
                break;
                case 'inFooter':
                    return self::displayTEST(self::FOOTERNUM);
                break;
            }
        }
    }

    /**
     * This makes the display
     * @param int $quant Quanatity of 'test' to make
     * @return string
     */
    private static function displayTEST($quant)
    {
        $out = '<p style="color:#cc6666;weight:900;text-align:center;">';
        for ($i = 1; $i <= $quant; $i++) {
            $out .= ' TEST ';
        }
        $out .='</p>';
        return $out;
    }
}
