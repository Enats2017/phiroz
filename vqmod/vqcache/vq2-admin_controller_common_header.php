<?php 
class ControllerCommonHeader extends Controller {
	protected function index() {
		$this->data['title'] = $this->document->getTitle(); 

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();	
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');

		$this->language->load('common/header');


			$this->language->load('common/footer');
			$this->data['text_footer'] = sprintf($this->language->get('text_footer'), VERSION);
			
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_attribute'] = $this->language->get('text_attribute');
		$this->data['text_attribute_group'] = $this->language->get('text_attribute_group');
		$this->data['text_backup'] = $this->language->get('text_backup');
		$this->data['text_banner'] = $this->language->get('text_banner');
		$this->data['text_catalog'] = $this->language->get('text_catalog');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_country'] = $this->language->get('text_country');
		$this->data['text_coupon'] = $this->language->get('text_coupon');
		$this->data['text_currency'] = $this->language->get('text_currency');			
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_customer_field'] = $this->language->get('text_customer_field');
		$this->data['text_customer_ban_ip'] = $this->language->get('text_customer_ban_ip');
		$this->data['text_custom_field'] = $this->language->get('text_custom_field');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_design'] = $this->language->get('text_design');
		$this->data['text_documentation'] = $this->language->get('text_documentation');
		$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_error_log'] = $this->language->get('text_error_log');
		$this->data['text_extension'] = $this->language->get('text_extension');
		$this->data['text_feed'] = $this->language->get('text_feed');
		$this->data['text_filter'] = $this->language->get('text_filter');
		$this->data['text_front'] = $this->language->get('text_front');
		$this->data['text_geo_zone'] = $this->language->get('text_geo_zone');
		$this->data['text_dashboard'] = $this->language->get('text_dashboard');
		$this->data['text_help'] = $this->language->get('text_help');
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_language'] = $this->language->get('text_language');
		$this->data['text_layout'] = $this->language->get('text_layout');
		$this->data['text_localisation'] = $this->language->get('text_localisation');
		$this->data['text_logout'] = $this->language->get('text_logout');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_manager'] = $this->language->get('text_manager');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_order_status'] = $this->language->get('text_order_status');
		$this->data['text_opencart'] = $this->language->get('text_opencart');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_product'] = $this->language->get('text_product'); 
		$this->data['text_profile'] = $this->language->get('text_profile');
		$this->data['text_reports'] = $this->language->get('text_reports');
		$this->data['text_report_sale_order'] = $this->language->get('text_report_sale_order');
		$this->data['text_report_sale_tax'] = $this->language->get('text_report_sale_tax');
		$this->data['text_report_sale_shipping'] = $this->language->get('text_report_sale_shipping');
		$this->data['text_report_sale_return'] = $this->language->get('text_report_sale_return');
		$this->data['text_report_sale_coupon'] = $this->language->get('text_report_sale_coupon');
		$this->data['text_report_product_viewed'] = $this->language->get('text_report_product_viewed');
		$this->data['text_report_product_purchased'] = $this->language->get('text_report_product_purchased');
		$this->data['text_report_customer_online'] = $this->language->get('text_report_customer_online');
		$this->data['text_report_customer_order'] = $this->language->get('text_report_customer_order');
		$this->data['text_report_customer_reward'] = $this->language->get('text_report_customer_reward');
		$this->data['text_report_customer_credit'] = $this->language->get('text_report_customer_credit');
		$this->data['text_report_affiliate_commission'] = $this->language->get('text_report_affiliate_commission');
		$this->data['text_report_sale_return'] = $this->language->get('text_report_sale_return');
		$this->data['text_report_product_viewed'] = $this->language->get('text_report_product_viewed');
		$this->data['text_report_customer_order'] = $this->language->get('text_report_customer_order');
		$this->data['text_review'] = $this->language->get('text_review');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_return_action'] = $this->language->get('text_return_action');
		$this->data['text_return_reason'] = $this->language->get('text_return_reason');
		$this->data['text_return_status'] = $this->language->get('text_return_status');
		$this->data['text_support'] = $this->language->get('text_support');
		$this->data['text_shipping'] = $this->language->get('text_shipping');
		$this->data['text_setting'] = $this->language->get('text_setting');
		$this->data['text_stock_status'] = $this->language->get('text_stock_status');
		$this->data['text_system'] = $this->language->get('text_system');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_tax_class'] = $this->language->get('text_tax_class');
		$this->data['text_tax_rate'] = $this->language->get('text_tax_rate');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_user'] = $this->language->get('text_user');
		$this->data['text_user_group'] = $this->language->get('text_user_group');
		$this->data['text_users'] = $this->language->get('text_users');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_voucher_theme'] = $this->language->get('text_voucher_theme');
		$this->data['text_weight_class'] = $this->language->get('text_weight_class');
		$this->data['text_length_class'] = $this->language->get('text_length_class');
		$this->data['text_zone'] = $this->language->get('text_zone');
		$this->data['text_openbay_extension'] = $this->language->get('text_openbay_extension');
		$this->data['text_openbay_dashboard'] = $this->language->get('text_openbay_dashboard');
		$this->data['text_openbay_orders'] = $this->language->get('text_openbay_orders');
		$this->data['text_openbay_items'] = $this->language->get('text_openbay_items');
		$this->data['text_openbay_ebay'] = $this->language->get('text_openbay_ebay');
		$this->data['text_openbay_amazon'] = $this->language->get('text_openbay_amazon');
		$this->data['text_openbay_amazonus'] = $this->language->get('text_openbay_amazonus');
		$this->data['text_openbay_settings'] = $this->language->get('text_openbay_settings');
		$this->data['text_openbay_links'] = $this->language->get('text_openbay_links');
		$this->data['text_openbay_report_price'] = $this->language->get('text_openbay_report_price');
		$this->data['text_openbay_order_import'] = $this->language->get('text_openbay_order_import');

		$this->data['text_paypal_express'] = $this->language->get('text_paypal_manage');
		$this->data['text_paypal_express_search'] = $this->language->get('text_paypal_search');
		$this->data['text_recurring_profile'] = $this->language->get('text_recurring_profile');

		//language variable for HMS
		
		$this->data['text_master'] = $this->language->get('text_master');
		$this->data['text_horse']  = $this->language->get('text_horse');
		$this->data['text_owner']  = $this->language->get('text_owner');
		$this->data['text_trainer'] = $this->language->get('text_trainer');
		$this->data['text_medicine'] = $this->language->get('text_medicine');

		$this->data['text_transaction'] = $this->language->get('text_transaction');
		$this->data['text_horse_wise_tr'] = $this->language->get('text_horse_wise_tr');
		$this->data['text_medicine_wise_tr'] = $this->language->get('text_medicine_wise_tr');

		$this->data['text_treated_horse'] = $this->language->get('text_treated_horse');

		$this->data['text_bills'] = $this->language->get('text_bills');
		$this->data['text_print_inv'] = $this->language->get('text_print_inv');
		$this->data['text_print_rec'] = $this->language->get('text_print_rec');

		$this->data['text_report'] = $this->language->get('text_report');
		$this->data['text_horse_wise_report'] = $this->language->get('text_horse_wise_report');
		$this->data['text_medicine_report'] = $this->language->get('Medicine Report');
		$this->data['text_horse_wise_daily_report'] = $this->language->get('text_horse_wise_daily_report');
		$this->data['text_horse_wise_15_report'] = $this->language->get('text_horse_wise_15_report');
		$this->data['text_trainer_wise_report'] = $this->language->get('text_trainer_wise_report');
		$this->data['text_owner_wise_report'] = $this->language->get('text_owner_wise_report');
		$this->data['text_pending_wise_report'] = $this->language->get('text_pending_wise_report');
		$this->data['text_paid_wise_report'] = $this->language->get('text_paid_wise_report');

		$this->data['text_trainer_wise_statement'] = $this->language->get('text_trainer_wise_statement');
		$this->data['text_trainer_wise_log_report'] = $this->language->get('text_trainer_wise_log_report');
		$this->data['text_owner_wise_statement'] = $this->language->get('text_owner_wise_statement');
		$this->data['text_bill_history'] = $this->language->get('text_bill_history');



		$this->data['text_utility'] = $this->language->get('text_utility');
		$this->data['text_payment_tracking'] = $this->language->get('text_payment_tracking');
		$this->data['text_change_invoice_treatment'] = $this->language->get('text_change_invoice_treatment');
		$this->data['text_send_invoice_by_email'] = $this->language->get('text_send_invoice_by_email');
		$this->data['text_cancel_bill'] = $this->language->get('text_cancel_bill');


		if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = '';

			$this->data['home'] = $this->url->link('common/login', '', 'SSL');
		} else {
			
			$this->data['logged'] = sprintf($this->language->get('text_logged'), ": <img src='view/image/admin_theme/base5builder_impulsepro/icon-admin-user.png' /> " . $this->user->getUserName());
			
			$this->data['pp_express_status'] = $this->config->get('pp_express_status');

			$this->data['home'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['affiliate'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute_group'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['backup'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['banner'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['category'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['country'] = $this->url->link('localisation/country', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['coupon'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['currency'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_fields'] = $this->url->link('sale/customer_field', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_group'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_ban_ip'] = $this->url->link('sale/customer_ban_ip', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['custom_field'] = $this->url->link('design/custom_field', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['download'] = $this->url->link('catalog/download', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['feed'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['filter'] = $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['geo_zone'] = $this->url->link('localisation/geo_zone', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['information'] = $this->url->link('catalog/information', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['language'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['layout'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['contact'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['manager'] = $this->url->link('extension/manager', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['manufacturer'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['module'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['option'] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order_status'] = $this->url->link('localisation/order_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['payment'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['profile'] = $this->url->link('catalog/profile', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_order'] = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_tax'] = $this->url->link('report/sale_tax', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_shipping'] = $this->url->link('report/sale_shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_return'] = $this->url->link('report/sale_return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_coupon'] = $this->url->link('report/sale_coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_viewed'] = $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_purchased'] = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_order'] = $this->url->link('report/customer_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_reward'] = $this->url->link('report/customer_reward', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_credit'] = $this->url->link('report/customer_credit', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_affiliate_commission'] = $this->url->link('report/affiliate_commission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_action'] = $this->url->link('localisation/return_action', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_reason'] = $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_status'] = $this->url->link('localisation/return_status', 'token=' . $this->session->data['token'], 'SSL');			
			$this->data['shipping'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['store'] = HTTP_CATALOG;
			$this->data['stock_status'] = $this->url->link('localisation/stock_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_class'] = $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_rate'] = $this->url->link('localisation/tax_rate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['total'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher_theme'] = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['weight_class'] = $this->url->link('localisation/weight_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['length_class'] = $this->url->link('localisation/length_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['zone'] = $this->url->link('localisation/zone', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['openbay_show_menu'] = $this->config->get('openbaymanager_show_menu');

			$this->data['openbay_link_extension'] = $this->url->link('extension/openbay', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_orders'] = $this->url->link('extension/openbay/orderList', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_items'] = $this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay'] = $this->url->link('openbay/openbay', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_settings'] = $this->url->link('openbay/openbay/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_links'] = $this->url->link('openbay/openbay/viewItemLinks', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_ebay_orderimport'] = $this->url->link('openbay/openbay/viewOrderImport', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon'] = $this->url->link('openbay/amazon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon_settings'] = $this->url->link('openbay/amazon/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazon_links'] = $this->url->link('openbay/amazon/itemLinks', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus'] = $this->url->link('openbay/amazonus', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus_settings'] = $this->url->link('openbay/amazonus/settings', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['openbay_link_amazonus_links'] = $this->url->link('openbay/amazonus/itemLinks', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['openbay_markets'] = array(
				'ebay' => $this->config->get('openbay_status'),
				'amazon' => $this->config->get('amazon_status'),
				'amazonus' => $this->config->get('amazonus_status'),
			);

			$this->data['paypal_express'] = $this->url->link('payment/pp_express', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['paypal_express_search'] = $this->url->link('payment/pp_express/search', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['recurring_profile'] = $this->url->link('sale/recurring', 'token=' . $this->session->data['token'], 'SSL');

			
			$this->data['employee']  = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['company']  = $this->url->link('catalog/company', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['location']  = $this->url->link('catalog/location', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['category']  = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['department']  = $this->url->link('catalog/department', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['shift']  = $this->url->link('catalog/shift', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['trainer'] = $this->url->link('catalog/trainer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['medicine'] = $this->url->link('catalog/medicine', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['transaction'] = $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attendance_report'] = $this->url->link('report/attendance', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['today_report'] = $this->url->link('report/today', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['dailyattendance_report'] = $this->url->link('report/dailyattendance', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->data['dailysummary_report'] = $this->url->link('report/dailysummary', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->data['medicine_wise_tr'] = $this->url->link('transaction/medicine_wise', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['treated_horse'] = $this->url->link('transaction/horse_noowner', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['print_inv'] = $this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['print_rec'] = $this->url->link('bill/print_receipt', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['bill_history'] = $this->url->link('bill/bill_history', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['horse_wise_report'] = $this->url->link('report/horse_wise', 'token=' . $this->session->data['token'], 'SSL');

			$url = '';
			$url .= '&filter_date_start=' . date('Y-m-d');
			$url .= '&filter_date_end=' . date('Y-m-d');
			$url .= '&out_status=1';
			$this->data['horse_wise_daily_report'] = $this->url->link('report/horse_wise', 'token=' . $this->session->data['token'].$url, 'SSL');
			
			$url = '';
			$from = date('Y-m-d');
			$datefrom = date('Y-m-d', strtotime($from . "-15 day"));
			$url .= '&filter_date_start=' . $datefrom;
			$url .= '&filter_date_end=' . date('Y-m-d');
			$url .= '&out_status=1';
			$this->data['horse_wise_15_report'] = $this->url->link('report/horse_wise_fifteen', 'token=' . $this->session->data['token'].$url, 'SSL');
			$this->data['trainer_wise_report'] = $this->url->link('report/trainer_wise', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['owner_wise_report'] = $this->url->link('report/owner_wise', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['pending_wise_report'] = $this->url->link('report/pending_bills', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['paid_wise_report'] = $this->url->link('report/paid_bills', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['medicine_report'] = $this->url->link('report/medicine', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->data['payment_tracking'] = $this->url->link('tool/payment_tracking', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['change_invoice_treatment'] = $this->url->link('tool/invoice_treatment', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['send_invoice_by_email'] = $this->url->link('tool/invoice_mail', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['owner_wise_statement'] = $this->url->link('report/owner_wise_statement', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['trainer_wise_statement'] = $this->url->link('report/trainer_wise_statement', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['trainer_wise_log_report'] = $this->url->link('report/trainer_wise_log', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['cancel_bill'] = $this->url->link('tool/cancel_bill', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->data['import_employee'] = $this->url->link('snippets/snippet', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['day_process'] = $this->url->link('transaction/dayprocess', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['leave_process'] = $this->url->link('transaction/leaveprocess', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['complimentary'] = $this->url->link('catalog/complimentary', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['holiday'] = $this->url->link('catalog/holiday', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['location'] = $this->url->link('catalog/location', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->data['week'] = $this->url->link('catalog/week', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['leave'] = $this->url->link('catalog/leave', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['shift_schedule'] = $this->url->link('catalog/shift_schedule', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['proc_next_month'] = $this->url->link('transaction/proc_next_month', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['performance_report'] = $this->url->link('report/performance', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['deficit_report'] = $this->url->link('report/deficit', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['manualpunch'] = $this->url->link('transaction/manualpunch', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['halfday'] = $this->url->link('catalog/halfday', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tr_atten'] = $this->url->link('transaction/attendance', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['muster'] = $this->url->link('report/muster', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['leave_led'] = $this->url->link('report/leave_register', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['lta'] = $this->url->link('report/lta', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['reset_shift_schedule'] = $this->url->link('transaction/proc_next_month1', 'token=' . $this->session->data['token'], 'SSL');

			if(isset($this->session->data['is_dept']) && $this->session->data['is_dept'] == '1'){
				$user_dept = 1;
				$is_dept = 1;
				$is_super = 0;
				$is_super1 = 0;
			} elseif(isset($this->session->data['is_user'])){
				$user_dept = 1;
				$is_dept = 0;
				$is_super = 0;
				$is_super1 = 0;
			} elseif(isset($this->session->data['is_super'])){
				$user_dept = 1;
				$is_dept = 0;
				$is_super = 1;
				$is_super1 = 0;
			} elseif(isset($this->session->data['is_super1'])){
				$user_dept = 1;
				$is_dept = 0;
				$is_super = 0;
				$is_super1 = 1;
			} else {
				$user_dept = 0;
				$is_dept = 0;
				$is_super = 0;
				$is_super1 = 0;
			}
			$this->data['user_dept'] = $user_dept;
			$this->data['is_dept'] = $is_dept;
			$this->data['is_super'] = $is_super;
			$this->data['is_super1'] = $is_super1;

			

			if(isset($this->session->data['is_dept']) && $this->session->data['is_dept'] == '1'){
				$this->data['leave_transaction'] = $this->url->link('transaction/leave_ess', 'token=' . $this->session->data['token'], 'SSL');
				$this->data['leave_transaction_dept'] = $this->url->link('transaction/leave_ess_dept', 'token=' . $this->session->data['token'], 'SSL');
			} elseif(isset($this->session->data['is_user'])){
				$this->data['leave_transaction_super'] = $this->url->link('transaction/leave_ess_dept', 'token=' . $this->session->data['token'], 'SSL');
				$this->data['leave_transaction'] = $this->url->link('transaction/leave_ess', 'token=' . $this->session->data['token'], 'SSL');
			} elseif(isset($this->session->data['is_super'])){
				$this->data['leave_transaction'] = $this->url->link('transaction/leave_ess', 'token=' . $this->session->data['token'], 'SSL');
				$this->data['leave_transaction_super'] = $this->url->link('transaction/leave_ess_dept', 'token=' . $this->session->data['token'], 'SSL');
			} elseif(isset($this->session->data['is_super1'])){
				$this->data['leave_transaction_super'] = $this->url->link('transaction/leave_ess_dept', 'token=' . $this->session->data['token'], 'SSL');
			} else {
				$this->data['leave_transaction'] = $this->url->link('transaction/leave', 'token=' . $this->session->data['token'], 'SSL');
			}

			$this->data['requestform'] = $this->url->link('transaction/requestform', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['requestformdept'] = $this->url->link('transaction/requestformdept', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['requestformunit'] = $this->url->link('transaction/requestformunit', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->data['department'] = $this->url->link('catalog/department', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['designation'] = $this->url->link('catalog/designation', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['grade'] = $this->url->link('catalog/grade', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['password_change'] = $this->url->link('user/password_change', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['import_attendance_muster'] = $this->url->link('snippets/dataprocess', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['import_attendance_daily'] = $this->url->link('snippets/dataprocess_daily', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['dataprocess_empty'] = $this->url->link('snippets/dataprocess_empty', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['manualpunch_daily'] = $this->url->link('report/manualdaily', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['wages_report'] = $this->url->link('report/wages', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['wages_report_muster'] = $this->url->link('report/wagesmuster', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['slipdaily'] = $this->url->link('report/slipdaily', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['slipmuster'] = $this->url->link('report/slipmuster', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->data['leave_report_perday'] = $this->url->link('report/leave_report_perday', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['leave_report_muster'] = $this->url->link('report/leave_report_muster', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['bonus_report_perday'] = $this->url->link('report/bonus_report_perday', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['bonus_report_muster'] = $this->url->link('report/bonus_report_muster', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['category_two']  = $this->url->link('catalog/category_two', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['category_three']  = $this->url->link('catalog/category_three', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['stores'] = array();

			$this->load->model('setting/store');

			$results = $this->model_setting_store->getStores();

			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}			
		}
		
			$this->template = 'admin_theme/base5builder_impulsepro/common/header.tpl';
			

		$this->render();
	}
}
?>