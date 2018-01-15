<?php

/**
*
* Plugin Name: Flash Sale Boost for WooCommerce
* Plugin URI: http://flashsaleboost.hdev.info
* Description: The Flash Sale Boost for WooCommerce plugin, offers features that give a boost to the sale of your woocommerce website products.
* Version: 1.0
* Author: hdevinfo
* Author URI: http://flashsaleboost.hdev.info
* Text Domain: flash-sale-boost-woocommerce
* License: GPLv2
* Flash Sale Pro for WooCommerce
* Powered by HDEV.INFO & NSR Systems | Neural System Reply
*
*
* Copyright (C) 2008-2018, hdevinfo - support@hdev.info
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
**/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'FLASH_SALE_BOOST_WOOCOMMERCE_SRC' ) ) {
    define( 'FLASH_SALE_BOOST_WOOCOMMERCE_SRC', "/".basename(WP_CONTENT_DIR)."/".basename(WP_PLUGIN_DIR)."/".basename(dirname(__FILE__)) );
}

if ( ! class_exists( 'Flash_sbWoo' ) ) {
    require_once dirname(__FILE__). "/Code/Flash_sbWoo.php";
}

register_uninstall_hook  ( __FILE__  , 'flash_sbWoo_Unstall' );

function flash_sbWoo_Unstall() {
    require_once  ( dirname(__FILE__) ."/Code/Flash_sbWooUnstall.php");
}


$init = new Flash_sbWoo();
