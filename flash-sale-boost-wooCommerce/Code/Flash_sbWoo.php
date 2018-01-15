<?php

/**
**	Flash Sales Boost For WooCommerce
**	
**	====== CORE =========
**
**	Author: hdevinfo
**	
**	Powered by HDEV.INFO & NSR Systems | Neural System Reply
**/


class Flash_sbWoo {

    /**
    *
    * Core
    *
    **/

    public function __construct() {
        if ( is_admin() ) {
	    add_action( 'admin_menu', array( 'Flash_sbWoo', 'add_admin_menu' ) );
	    add_action( 'admin_init', array( 'Flash_sbWoo', 'register_settings' ) );
	}else{
	    $this->woo_fs_pro_js();
	}
	add_action( 'wp_head', array($this, 'woo_fs_pro_set_head'), 2);
	$this->woo_fs_pro_add_element();
    }


    function woo_fs_pro_add_element(){
	$position_ref = get_option( 'woofspro_options' ) ['position'];
	switch ( $position_ref ){
	    case '1':
		add_action( 'woocommerce_before_shop_loop_item_title', array($this, 'woo_fs_pro_add_c'), 1 );
		add_action( 'woocommerce_single_product_summary', array($this, 'woo_fs_pro_add_l'), 11 );
		break;
	    case '2':
		add_action( 'woocommerce_before_shop_loop_item_title', array($this, 'woo_fs_pro_add_c'), 11 );
		add_action( 'woocommerce_single_product_summary', array($this, 'woo_fs_pro_add_l'), 11 );
		break;
	    case '3':
		add_filter( 'woocommerce_sale_flash', array($this, 'woo_fs_pro_add_f_f'),11);
		break;
	    default:
		add_action( 'woocommerce_before_shop_loop_item_title', array($this, 'woo_fs_pro_add_c'), 1 );
		add_action( 'woocommerce_single_product_summary', array($this, 'woo_fs_pro_add_c'), 11 );
		break;
	}
    }


    /**
    *
    * add c 
    *
    **/
    function woo_fs_pro_add_c() {
	global $product;
        $product_id = $product->get_id();
        $_product = wc_get_product( $product_id );
        $sales_price_to = get_post_meta($product_id, '_sale_price_dates_to', true);
        $sales_price_fr = get_post_meta($product_id, '_sale_price_dates_from', true);
        $sales_price_fr = strtotime(date("Y-m-d H:i:s"));
        $ctd =  $sales_price_to - $sales_price_fr;
        if (isset($ctd)){
    	    if ( $ctd > 0 ){
    		$this->woo_fs_pro_add_sale_text_c();
    		echo '<div class="woo_flash_sales" data-id="'.$ctd.'"></div>';
    	    }
    	}
    }


    /**
    *
    * f
    *
    **/
    function woo_fs_pro_add_f() {
        global $product;
        $product_id = $product->get_id();
        if ( strlen($product_id) ){
    	    add_action( 'woocommerce_single_product_summary', array($this, 'woo_fs_pro_add_f_f'), 11 );
        }
    }


    /**
    *
    * f f 
    *
    **/
    function woo_fs_pro_add_f_f() {
        global $product;
        $product_id = $product->get_id();
        $_product = wc_get_product( $product_id );
        $sales_price_to = get_post_meta($product_id, '_sale_price_dates_to', true);
        $sales_price_fr = get_post_meta($product_id, '_sale_price_dates_from', true);
        $sales_price_fr = strtotime(date("Y-m-d H:i:s"));
        $ctd =  $sales_price_to - $sales_price_fr;
        if (isset($ctd)){
    	    if ( $ctd > 0 ){
    		echo '<div class="woo_flash_sales" data-id="'.$ctd.'"><div>'.$this->woo_fs_pro_add_sale_text_f_l().'</div></div>';
    	    }
    	}
    }


    /**
    *
    * f l 
    *
    **/
    function woo_fs_pro_add_sale_text_f_l(){
	if( isset(get_option( 'woofspro_options' ) ['textsale_status']) ){
	    if ( get_option( 'woofspro_options' ) ['textsale_status'] ) {
		$obj = '<div align="center" style="border:0px solid red;font-family:'.$this->woo_fs_pro_get_sale_text_font().';color:'.$this->woo_fs_pro_get_sale_text_color().';font-size:'.$this->woo_fs_pro_get_sale_text_font_size().'px;margin-bottom:0px;border:'.$this->woo_fs_pro_get_sale_text_border().'px solid '.$this->woo_fs_pro_get_sale_text_color().';">'.get_option( 'woofspro_options' ) ['sale_text'].'</div>';
		return $obj;
	    }
	}
	return false;
    }


    /**
    *
    * left
    *
    **/
    function woo_fs_pro_add_l() {
	global $product;
        $product_id = $product->get_id();
        $_product = wc_get_product( $product_id );
        $sales_price_to = get_post_meta($product_id, '_sale_price_dates_to', true);
        $sales_price_fr = get_post_meta($product_id, '_sale_price_dates_from', true);
        $sales_price_fr = strtotime(date("Y-m-d H:i:s"));
        $ctd =  $sales_price_to - $sales_price_fr;
        if (isset($ctd)){
    	    if ( $ctd > 0 ){
    		$this->woo_fs_pro_add_sale_text_l();
    		echo '<div class="woo_flash_sales" data-id="'.$ctd.'"></div>';
    	    }
    	}
    }


    /**
    *
    * c s t
    *
    **/
    function woo_fs_pro_add_sale_text_c(){
	if( isset(get_option( 'woofspro_options' ) ['textsale_status']) ){
	    if ( get_option( 'woofspro_options' ) ['textsale_status'] ) {
		echo '<div align="center" style="font-family:'.$this->woo_fs_pro_get_sale_text_font().';color:'.$this->woo_fs_pro_get_sale_text_color().';font-size:'.$this->woo_fs_pro_get_sale_text_font_size().'px;margin-bottom:0px;border:'.$this->woo_fs_pro_get_sale_text_border().'px solid '.$this->woo_fs_pro_get_sale_text_color().';">'.get_option( 'woofspro_options' ) ['sale_text'].'</div>';
	    }
	}
    }


    /**
    *
    * l 
    *
    **/
    function woo_fs_pro_add_sale_text_l(){
	if( isset(get_option( 'woofspro_options' ) ['textsale_status']) ){
	    if ( get_option( 'woofspro_options' ) ['textsale_status'] ) {
		echo '<div align="left" style="padding-left:15px;font-family:'.$this->woo_fs_pro_get_sale_text_font().';color:'.$this->woo_fs_pro_get_sale_text_color().';font-size:'.$this->woo_fs_pro_get_sale_text_font_size().'px;margin-bottom:0px;border:'.$this->woo_fs_pro_get_sale_text_border().'px solid '.$this->woo_fs_pro_get_sale_text_color().';">'.get_option( 'woofspro_options' ) ['sale_text'].'</div>';
	    }
	}
    }


    /**
    *
    * color
    *
    **/
    function woo_fs_pro_get_sale_text_color(){
	if( isset(get_option( 'woofspro_options' ) ['sale_text_color']) ){
	    if ( strlen( get_option( 'woofspro_options' ) ['sale_text_color']) ){
		return get_option( 'woofspro_options' ) ['sale_text_color'];;
	    }
	}
    }


    /**
    *
    * c sale
    *
    **/
    function woocommerce_custom_sale_text(){
        global $product;
        $product_id = $product->get_id();
        $_product = wc_get_product( $product_id );
        $sales_price_to = get_post_meta($product_id, '_sale_price_dates_to', true);
        $sales_price_fr = get_post_meta($product_id, '_sale_price_dates_from', true);
        $sales_price_fr = strtotime(date("Y-m-d H:i:s"));
        $ctd =  $sales_price_to - $sales_price_fr;
        if (isset($ctd)){
    	    echo '<div class="woo_flash_sales" data-id="'.$ctd.'"></div>';
    	}
    }


    /**
    *
    * date
    *
    **/
    static function get_date_on_sale_from( $context = 'view' ) {
        return $this->get_prop( 'date_on_sale_from', $context );
    }


    /**
    *
    * uri
    *
    **/
    function woo_fs_pro_set_uri(){
	return get_permalink();
    }


    /**
    *
    * pro set
    *
    **/
    public function woo_fs_pro_set_head(){
	echo '<style id="storefront-style-inline-css" type="text/css">
	    .woo_flash_sales {
		border-width: '.$this->woo_fs_pro_get_border_top().'px '.$this->woo_fs_pro_get_border_right().'px '.$this->woo_fs_pro_get_border_bottom().'px '.$this->woo_fs_pro_get_border_left().'px;
    		border-style: solid;
    		background: '.$this->woo_fs_pro_get_background().';
    		color: '.$this->woo_fs_pro_get_color().';
    		padding: 2px;
    		border-color: '.$this->woo_fs_pro_get_color().';
    		display: inline-block;
	    }
	    .woo_flash_sales span {
    		display: inline-block;
		margin-left: 5px;
    		min-width: 40px;
    		text-align: center;
		font-size: '.$this->woo_fs_pro_get_dhms().'px;
		font-weight: normal;
    	    }.woo_flash_sales span:first-child {margin-left: 0;}.woo_flash_sales span span {font-size: '.$this->woo_fs_pro_get_font_size().'px;display: block;}</style>';
    }


    /**
    *
    * text
    *
    **/
    public function woo_fs_pro_get_sale_text(){
    	if (isset(get_option( 'woofspro_options' ) ['sale_text'])){
    	    return get_option( 'woofspro_options' ) ['sale_text'];
    	}
    }


    /**
    *
    * text
    *
    **/
    public function woo_fs_pro_get_dhms(){
    	if (isset(get_option( 'woofspro_options' ) ['dhms'])){
    	    return get_option( 'woofspro_options' ) ['dhms'];
    	}
    }


    /**
    *
    * text border
    *
    **/
    public function woo_fs_pro_get_sale_text_border(){
    	if (isset(get_option( 'woofspro_options' ) ['sale_text_border'])){
    	    return get_option( 'woofspro_options' ) ['sale_text_border'];
    	}
    }


    /**
    *
    * sale text size
    *
    **/
    public function woo_fs_pro_get_sale_text_font_size(){
    	if (isset(get_option( 'woofspro_options' ) ['sale_text_font_size'])){
    	    return get_option( 'woofspro_options' ) ['sale_text_font_size'];
    	}
    }


    /**
    *
    * text font
    *
    **/
    public function woo_fs_pro_get_sale_text_font(){
    	if (isset(get_option( 'woofspro_options' ) ['sale_text_font'])){
    	    return get_option( 'woofspro_options' ) ['sale_text_font'];
    	}
    }


    /**
    *
    * left
    *
    **/
    public function woo_fs_pro_get_border_left(){
    	if (isset(get_option( 'woofspro_options' ) ['borderleft'])){
    	    return get_option( 'woofspro_options' ) ['borderleft'];
    	}
    }


    /**
    *
    * font
    *
    **/
    public function woo_fs_pro_get_font_size(){
    	if(isset(get_option( 'woofspro_options' ) ['fontsize'])){
    	    return get_option( 'woofspro_options' ) ['fontsize'];
    	}
    }


    /**
    *
    * top
    *
    **/
    public function woo_fs_pro_get_border_top(){
    	if( isset(get_option( 'woofspro_options' ) ['bordertop']) ){
    	    return get_option( 'woofspro_options' ) ['bordertop'];
    	}
    }


    /**
    *
    * right
    *
    **/
    public function woo_fs_pro_get_border_right(){
	if( isset(get_option( 'woofspro_options' ) ['borderright']) ){
    	    return get_option( 'woofspro_options' ) ['borderright'];
    	}
    }


    /**
    *
    * bottom
    *
    **/
    public function woo_fs_pro_get_border_bottom(){
    	if( isset(get_option( 'woofspro_options' ) ['borderbottom'])){
    	    return get_option( 'woofspro_options' ) ['borderbottom'];
	}
    }

    /**
    *
    * color
    *
    **/
    public function woo_fs_pro_get_border_color(){
    	if (isset(get_option( 'woofspro_options' ) ['bordercolor'])){
    	    return get_option( 'woofspro_options' ) ['bordercolor'];
	}
    }


    /**
    *
    * bkck
    *
    **/
    public function woo_fs_pro_get_background(){
    	if (isset(get_option( 'woofspro_options' ) ['background'])){
    	    return get_option( 'woofspro_options' ) ['background'];
    	}
    }


    /**
    *
    * color
    *
    **/
    public function woo_fs_pro_get_color(){
    	if (isset(get_option( 'woofspro_options' ) ['color'])){
    	    return get_option( 'woofspro_options' ) ['color'];
	}
    }


    /**
    *
    * pro set
    *
    **/
    public function woo_fs_set_flash(){
    }


    /**
    *
    * get p i 
    *
    **/
    public function woo_fs_pro_get_p_i(){
	$object = wc_get_product( $this->id );
	$pitem  = $object->get_price();
	return $pitem;
    }


    /**
    *
    * get i c 
    *
    **/
    public function woo_fs_pro_get_i_c(){
	$object = get_woocommerce_currency();
	return $object;
    }


    /**
    *
    * hostname
    *
    **/
    public function woo_fs_pro_host_name(){
	return $_SERVER['SERVER_NAME'];
    }


    /**
    *
    * link
    *
    **/
    public function woo_fs_pro_the_link(){
	return get_permalink();
    }


    /**
    *
    * the title
    *
    **/
    public function woo_fs_pro_get_the_title(){
	return get_the_title();
    }


    /**
    *
    * thumb
    *
    **/
    public function wpp_the_thumbnail(){
	return get_the_post_thumbnail_url();
    }


    /**
    *
    * theme option
    *
    **/
    public static function get_theme_options() {
        return get_option( 'woofspro_options' );
    }


    /**
    *
    * theme option
    *
    **/
    public static function get_theme_option( $id ) {
        $options = self::get_theme_options();
        if ( isset( $options[$id] ) ) {
	    return $options[$id];
        }
    }


    /**
    *
    * admin menu
    *
    **/
    public static function add_admin_menu() {
	if ( !strlen(get_option( 'woofspro_options' )['fontsize'] ) ){
	    $n = '<span class="update-plugins"><span class="plugin-count" aria-hidden="true"><i class="fa fa-bell faa-ring animated fa-2x" aria-hidden="true"></i></span></span>';
	}else{
	    $n = '';
	}
	add_menu_page(
	    esc_html__( 'FS Boost ', 'woofspro' ),
	    esc_html__( 'FS Boost ', 'woofspro' ).$n,
	    'manage_options',
	    'woo-fs-pro',
	    array( 'Flash_sbWoo', 'woo_fs_pro_admin_area' ),
	    'dashicons-calendar-alt'
	);
    }


    /**
    *
    * settings
    *
    **/
    public static function register_settings() {
        register_setting( 'woofspro_options', 'woofspro_options', array( 'Flash_sbWoo', 'sanitize' ) );
    }


    /**
    *
    * sanitize
    *
    **/
    public static function sanitize( $options ) {
        if ( $options ) {
	    if ( ! empty( $options['checkbox'] ) ) {
	        $options['checkbox'] = 'on';
	    } else {
	        unset( $options['checkbox'] );
	    }
	    if ( ! empty( $options['input_example'] ) ) {
	        $options['input_example'] = sanitize_text_field( $options['input_example'] );
	    } else {
	        unset( $options['input_example'] );
	    }
	    if ( ! empty( $options['select_size'] ) ) {
		$options['select_example'] = sanitize_text_field( $options['select_size'] );
	    }
	}
    return $options;
    }


    /**
    *
    * connect
    *
    **/
    public function woo_fs_pro_connect(){
        if(!$this->cflag){
    	    $connect_string = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    	    if($connect_string) {
    		$this->cflag = true;
    		$this->conn  = $connect_string;
    		return true;
    	    } else {
    		$this->cflag = false;
    		return false;
    	    }
	}
    }


    /**
    *
    * nsql
    *
    **/
    public function wpp_the_nsql(){
	$nsql = $this->squery;
	mysqli_query($this->conn,$nsql);
    }


    /**
    *
    * id 
    *
    **/
    public function woo_fs_pro_get_the_id(){
	$id = get_the_ID();
	return $id;
    }


    /**
    *
    * result
    *
    **/
    public function result(){
	return $this->result;
    }


    /**
    *
    * numR
    *
    **/
    public function wpp_the_numRows(){
        $this->wpp_the_connect();
        $qs   = 'select id from '. $this->table . ' where eid="' . esc_sql($this->pid) .'"';
        $query= mysqli_query($this->conn, $qs);
        if($this->cflag){
	    $Rows = mysqli_num_rows($query);
	    return $Rows;
	}
    }


    /**
    *
    * escape
    *
    **/
    public function escapeString($data){
        return mysql_real_escape_string($data);
    }


    /**
    *
    * close
    *
    **/
    public function woo_fs_pro_close(){
	if( $this->cflag ){
	    mysqli_close($this->conn);
	}
    }


    /**
    *
    * a area
    *
    **/
    public static function woo_fs_pro_admin_area() {
	$admin = new Flash_sbWoo();
	if( isset( $_GET['p'] ) ){
	    $apage = filter_var( sanitize_text_field($_GET['p']), FILTER_SANITIZE_NUMBER_INT );
	}else{
	    $apage = 1;
	}
	?>
	    <div class="wrap">
	    	    <h2>Flash Sale Boost for WooCommerce</h2><hr/>
		    <?php
			settings_errors();
			switch($apage){
			    case 1:
				echo '
				<ul class="wp-tab-bar">
				    <li class="wp-tab-active"><a href="?page=woo-fs-pro&p=1">Settings</a></li>
				    <li><a href="?page=woo-fs-pro&p=2">About</a></li>
				    <li><a href="?page=woo-fs-pro&p=3">Tutorial</a></li>
			        </ul>';
				echo '<div>'. $admin->woo_fs_pro_settings() . '</div>';
				break;
			    case 2:
				echo '
				<ul class="wp-tab-bar">
				    <li><a href="?page=woo-fs-pro&p=1">Settings</a></li>
				    <li class="wp-tab-active"><a href="?page=woo-fs-pro&p=2">About</a></li>
				    <li><a href="?page=woo-fs-pro&p=3">Tutorial</a></li>
			        </ul>';
				echo '<div>'. $admin->woo_fs_pro_about() . '</div>';
				break;
			    case 3:
				echo '
				<ul class="wp-tab-bar">
				    <li><a href="?page=woo-fs-pro&p=1">Settings</a></li>
				    <li><a href="?page=woo-fs-pro&p=2">About</a></li>
				    <li class="wp-tab-active"><a href="?page=woo-fs-pro&p=3">Tutorial</a></li>
			        </ul>';
				echo '<div>'. $admin->woo_fs_pro_tutorial() . '</div>';
				break;
			}
		    ?>
    	    </div>
	<?php
    }


    /**
    *
    * a settings
    *
    **/
    public static function woo_fs_pro_settings() {
	?>
	<div class="wp-tab-panel" style="min-height:730px;">
	    <h1><?php esc_html_e( 'Settings', 'woofspro' ); ?></h1><hr />
	    <?php
	    if ( !strlen(get_option( 'woofspro_options' )['fontsize'] ) ){
		echo '<div class="error notice is-dismissible"><p style="color:#ff0000;"><strong>Recommendation:</strong> Choose the value for your countdown and sale text. See the picture from tutorial for references. </p></div>';
	    }
	    ?>
	    <form method="post" action="options.php">
	    <?php settings_fields( 'woofspro_options' ); ?>
	    <table class="form-table FSPro-custom-admin-login-table">
		<tr>
		    <th scope="row"><?php esc_html_e( 'Counter Font Size', 'woofspro' ); ?></th>
		    <td>
			<?php $value = self::get_theme_option( 'fontsize' ); ?>
			    <select name="woofspro_options[fontsize]">
			    <?php
			        $size_options = array(
			    	'7'  => esc_html__( '7px', 'woofspro' ),
			    	'8'  => esc_html__( '8px', 'woofspro' ),
			    	'9'  => esc_html__( '9px', 'woofspro' ),
			        '10' => esc_html__( '10px', 'woofspro' ),
			        '11' => esc_html__( '11px', 'woofspro' ),
			    	'12' => esc_html__( '12px', 'woofspro' ),
			        '13' => esc_html__( '13px', 'woofspro' ),
			        '14' => esc_html__( '14px', 'woofspro' ),
			        '15' => esc_html__( '15px', 'woofspro' ),
			        '16' => esc_html__( '16px', 'woofspro' ),
			        '17' => esc_html__( '17px', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
		    </td>
		    <th scope="row"><?php esc_html_e( 'Day,Hours... Font Size', 'woofspro' ); ?></th>
		    <td>
			<?php $value = self::get_theme_option( 'dhms' ); ?>
			    <select name="woofspro_options[dhms]">
			    <?php
			        $size_options = array(
			    	'7'  => esc_html__( '7px', 'woofspro' ),
			    	'8'  => esc_html__( '8px', 'woofspro' ),
			    	'9'  => esc_html__( '9px', 'woofspro' ),
			        '10' => esc_html__( '10px', 'woofspro' ),
			        '11' => esc_html__( '11px', 'woofspro' ),
			    	'12' => esc_html__( '12px', 'woofspro' ),
			        '13' => esc_html__( '13px', 'woofspro' ),
			        '14' => esc_html__( '14px', 'woofspro' ),
			        '15' => esc_html__( '15px', 'woofspro' ),
			        '16' => esc_html__( '16px', 'woofspro' ),
			        '17' => esc_html__( '17px', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
		    </td>
		</tr>
		<tr valign="top">
		    <th scope="row"><?php esc_html_e( 'Border left', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'borderleft' ); ?>
			    <select name="woofspro_options[borderleft]">
			    <?php
			        $size_options = array(
			    	'0' => esc_html__( 'None: Border = 0', 'woofspro' ),
			        '1' => esc_html__( 'Fine: Border = 1', 'woofspro' ),
			        '2' => esc_html__( 'Larg: Border = 2', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
			</td>
		    </th>
		    <th scope="row"><?php esc_html_e( 'Border top', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'bordertop' ); ?>
			    <select name="woofspro_options[bordertop]">
			    <?php
			        $size_options = array(
			    	'0' => esc_html__( 'None: Border = 0', 'woofspro' ),
			        '1' => esc_html__( 'Fine: Border = 1', 'woofspro' ),
			        '2' => esc_html__( 'Larg: Border = 2', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
			</td>
		    </th>
		</tr>
		<tr valign="top">
		    <th scope="row"><?php esc_html_e( 'Border right', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'borderright' ); ?>
			    <select name="woofspro_options[borderright]">
			    <?php
			        $size_options = array(
			    	'0' => esc_html__( 'None: Border = 0', 'woofspro' ),
			        '1' => esc_html__( 'Fine: Border = 1', 'woofspro' ),
			        '2' => esc_html__( 'Larg: Border = 2', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
			</td>
		    </th>
		    <th scope="row"><?php esc_html_e( 'Border bottom', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'borderbottom' ); ?>
			    <select name="woofspro_options[borderbottom]">
			    <?php
			        $size_options = array(
			    	'0' => esc_html__( 'None: Border = 0', 'woofspro' ),
			        '1' => esc_html__( 'Fine: Border = 1', 'woofspro' ),
			        '2' => esc_html__( 'Larg: Border = 2', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
			</td>
		    </th>
		</tr>
		<tr>
		    <th scope="row"><?php esc_html_e( 'Border Color', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'bordercolor' ); ?>
			    <input type="text" name="woofspro_options[bordercolor]" value="<?php echo esc_attr( $value ); ?>">
			    
			</td>
		    </th>
		</tr>
		<tr>
		    <th scope="row"><?php esc_html_e( 'Background Color', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'background' ); ?>
			    <input type="text" name="woofspro_options[background]" value="<?php echo esc_attr( $value ); ?>">
			</td>
		    </th>
		    <th scope="row"><?php esc_html_e( 'Color', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'color' ); ?>
			    <input type="text" name="woofspro_options[color]" value="<?php echo esc_attr( $value ); ?>">
			</td>
		    </th>
		</tr>
	    </table><hr />
	    <table class="form-table FSPro-custom-admin-login-table">
		<tr>
		    <th scope="row"><?php esc_html_e( 'Sale Text Status', 'woofspro' ); ?></th>
		    <td>
		    <?php $value = self::get_theme_option( 'textsale_status' ); ?>
			<select name="woofspro_options[textsale_status]">
			    <?php
			        $size_options = array(
			    	'0' => esc_html__( 'Inactive', 'woofspro' ),
			        '1' => esc_html__( 'Active', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
		    </td>
		    <th scope="row"><?php esc_html_e( 'Sale Text Font Size', 'woofspro' ); ?></th>
		    <td>
			<?php $value = self::get_theme_option( 'sale_text_font_size' ); ?>
			    <select name="woofspro_options[sale_text_font_size]">
			    <?php
			        $size_options = array(
			    	'12' => esc_html__( '12px', 'woofspro' ),
			        '13' => esc_html__( '13px', 'woofspro' ),
			        '14' => esc_html__( '14px', 'woofspro' ),
			        '15' => esc_html__( '15px', 'woofspro' ),
			        '16' => esc_html__( '16px', 'woofspro' ),
			        '17' => esc_html__( '17px', 'woofspro' ),
			        '18' => esc_html__( '18px', 'woofspro' ),
			        '19' => esc_html__( '19px', 'woofspro' ),
			        '20' => esc_html__( '20px', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
		    </td>
		</tr>
		<tr>
		    <th scope="row"><?php esc_html_e( 'Sale text', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'sale_text' ); ?>
			    <input type="text" name="woofspro_options[sale_text]" value="<?php echo esc_attr( $value ); ?>" placeholder="">
			</td>
		    </th>
		    <th scope="row"><?php esc_html_e( 'Sale Text Color', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'sale_text_color' ); ?>
			    <input type="text" name="woofspro_options[sale_text_color]" value="<?php echo esc_attr( $value ); ?>">
			</td>
		    </th>
		</tr>
		<tr>
		    <th scope="row"><?php esc_html_e( 'Sale text border', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'sale_text_border' ); ?>
			    <input type="text" name="woofspro_options[sale_text_border]" value="<?php echo esc_attr( $value ); ?>">
			</td>
		    </th>
		    <th scope="row"><?php esc_html_e( 'Sale Text Font', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'sale_text_font' ); ?>
			    <select name="woofspro_options[sale_text_font]">
			    <?php
			        $size_options = array(
			    	'Arial' => esc_html__( 'Arial', 'woofspro' ),
			        'Helvetica' => esc_html__( 'Helvetica', 'woofspro' ),
			        'Times New Roman' => esc_html__( 'Times New Roman', 'woofspro' ),
			        'Sans Serif' => esc_html__( 'Sans Serif', 'woofspro' ),
			        'Comic Sans MS' => esc_html__( 'Comic Sans MS', 'woofspro' ),
			        'Cursive' => esc_html__( 'Cursive', 'woofspro' ),
			        'Impact' => esc_html__( 'Impact', 'woofspro' ),
			        'Impact' => esc_html__( 'Impact', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
			</td>
		    </th>
		</tr>
		<tr><th><td>&nbsp;</td></th></tr>
		<tr valign="top" class="FSPro-custom-admin-screen-background-section">
		    <th scope="row"><?php esc_html_e( 'Position:', 'woofspro' ); ?></th>
			<td>
			    <?php $value = self::get_theme_option( 'position' ); ?>
			    <select name="woofspro_options[position]">
			    <?php
			        $size_options = array(
			    	'1' => esc_html__( 'Above product image', 'woofspro' ),
			        '2' => esc_html__( 'Under product image', 'woofspro' ),
			        '3' => esc_html__( 'Replace "Sale!" button', 'woofspro' ),
				);
				foreach ( $size_options as $ids => $label ) { ?>
				<option value="<?php echo esc_attr( $ids ); ?>" <?php selected( $value, $ids, true ); ?>>
				    <?php echo strip_tags( $label ); ?>
				</option>
			    <?php } ?>
			    </select>
			</td>
		    </th>
		</tr>
	    </td>
	</tr></table>
	<?php submit_button(); ?>
	</form>
    </div>
    <?php
    }


    /**
    *
    * about
    *
    **/
    public static function woo_fs_pro_about() {
	?>
	<div class="wp-tab-panel">
	<h1><?php esc_html_e( 'About Flash Sale Boost for WooCommerce', 'woofspro' ); ?></h1><hr />
	<div><br />
	<h3>Flash Sale Boost for WooCommerce is a free plugin that dramatically boost your sales.</h3>
	<br />
	<h2>This plugin is dedicated to Vic & Roxi.</h2>
	<br />
	<h2><a href="http://flashsaleboost.hdev.info" target="_blank">Flash Sale Boost Webpage!</h3></a>
	</div>
	</div>
	<?php
    }


    /**
    *
    * tut
    *
    **/
    public static function woo_fs_pro_tutorial() {
	?>
	<div class="wp-tab-panel">
	<h1><?php esc_html_e( 'Flash Sale Boost Capture', 'woofspro' ); ?></h1><hr />
	<h2>Shop capture of Flash Sale Pro for WooCommerce</h2>
	<img src="<?php echo FLASH_SALE_BOOST_WOOCOMMERCE_SRC.'/images/shop.jpg';?>">
	<h2>Product page capture of Flash Sale Pro for WooCommerce</h2>
	<img src="<?php echo FLASH_SALE_BOOST_WOOCOMMERCE_SRC.'/images/product.jpg';?>">
	<img src="">
	</div>
	<?php
    }


    /**
    *
    * table
    *
    **/
    public function wpp_the_table($table){
	$this->table = $table."wpvs_pro";
    }


    /**
    *
    * get table
    *
    **/
    public function wpp_the_get_table(){
	return $this->table;
    }


    /**
    *
    * admin css
    *
    **/
    public function woo_fs_pro_css(){
	add_action( 'admin_enqueue_scripts', array($this, 'woo_fs_pro_style_cs' ), 99);
    }


    /**
    *
    *  css
    *
    **/
    public function woo_fs_pro_style_cs(){
        wp_register_style ( 'wpstyle' , plugins_url (FLASH_SALE_BOOST_WOOCOMMERCE_SRC.'/css/woofspro.min.css' ) );
	wp_enqueue_style  ( 'wpstyle' );
    }


    /**
    *
    *  js
    *
    **/
    public function woo_fs_pro_js(){
	add_action( 'wp_enqueue_scripts', array($this, 'woo_fs_pro_js_tr' ), 99);
    }


    /**
    *
    * js tr
    *
    **/
    public function woo_fs_pro_js_tr(){
	wp_register_script( 'woofsjs', FLASH_SALE_BOOST_WOOCOMMERCE_SRC.'/js/flashsaleboost.min.js' );
	$woofstr = array(
	    'fsobjd'		=> __( 'Days','woofspro' ),
	    'fsobjh'		=> __( 'Hours','woofspro' ),
	    'fsobjm'		=> __( 'Minutes','woofspro' ),
	    'fsobjs'  		=> __( 'Seconds', 'woofspro' ),
	);
	wp_localize_script( 'woofsjs', 'woomes', $woofstr );
	wp_enqueue_script ( 'woofsjs', '','','', true);
    }

}



/**
**	Flash Sale Boost For WooCommerce
**	
**	====== CORE =========
**
**	
**	
**	Author: hdevinfo
**	
**	Powered by HDEV.INFO & NSR Systems | Neural System Reply
**/
