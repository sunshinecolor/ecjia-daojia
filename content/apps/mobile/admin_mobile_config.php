<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA移动应用配置模块
 */
class admin_mobile_config extends ecjia_admin {

	public function __construct() {
		parent::__construct();
		
		Ecjia\App\Mobile\Helper::assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');
		
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Script::enqueue_script('mobile_manage', RC_App::apps_url('statics/js/mobile_manage.js', __FILE__), array(), false, 1);
		RC_Script::localize_script('mobile_manage', 'js_lang', config('app-mobile::jslang.mobile_page'));
		
		RC_Style::enqueue_style('mobile_manage', RC_App::apps_url('statics/css/mobile_manage.css', __FILE__), array(), false, false);
		
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('移动产品', 'mobile'), RC_Uri::url('mobile/admin_mobile_manage/init')));
	}
					
	
	/**
	 * 推送配置
	 */
	public function config_push() {
		$this->admin_priv('mobile_manage_update');
	
		$code = trim($this->request->input('code'));
		$app_id   = intval($this->request->input('app_id'));

		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端管理', 'mobile'), RC_Uri::url('mobile/admin_mobile_manage/client_list',array('code' => $code))));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端配置', 'mobile')));

        $app_id = RC_Hook::apply_filters('mobile_config_appid_filter', $app_id, $code, 'config_push');

		$this->assign('ur_here', __('客户端配置', 'mobile'));
		$this->assign('action_link', array('text' => __('客户端管理', 'mobile'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/client_list',array('code' => $code))));

		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_config/config_push_insert'));
		
		$this->assign('code', $code);
		$this->assign('app_id', $app_id);
		
		$data = RC_DB::table('mobile_options')->where('option_name', 'push_umeng')->where('platform', $code)->where('app_id', $app_id)->first();
		$data['option_value'] = unserialize($data['option_value']);
		$this->assign('data', $data);
				
		$this->display('mobile_config_push.dwt');
	}
	
	/**
	 * 推送配置处理
	 */
	public function config_push_insert() {
		$this->admin_priv('mobile_manage_update');

        $code = trim($this->request->input('code'));
        $app_id   = intval($this->request->input('app_id'));

		$push_umeng = $_POST['push_umeng'];
		foreach ($push_umeng as $row) {
			if (empty($row)){
				return $this->showmessage(__('配置信息不能为空', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$query = RC_DB::table('mobile_options')->where('option_name', 'push_umeng')->where('platform', $code)->where('app_id', $app_id)->count();
    	if ($query > 0) {
    		$data = array(
    			'option_value'	=> serialize($push_umeng),
    		);
    		RC_DB::table('mobile_options')->where('app_id', $app_id)->update($data);
		} else {
			$data = array(
				'platform'		=> $code,
				'app_id'		=> $app_id,
				'option_name' 	=> 'push_umeng',
				'option_type'	=> 'serialize',
				'option_value'	=> serialize($_POST['push_umeng']),
			);
			$id = RC_DB::table('mobile_options')->insertGetId($data);
		}

		return $this->showmessage(__('配置推送成功', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_config/config_push', array('app_id'=> $app_id, 'code' => $code))));
	}
	
	/**
	 * 支付配置
	 */
	public function config_pay() {
		$this->admin_priv('mobile_manage_update');
	
		$code = $_GET['code'];
		$app_id = intval($_GET['app_id']);
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端管理', 'mobile'), RC_Uri::url('mobile/admin_mobile_manage/client_list',array('code' => $code))));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端配置', 'mobile')));

        $app_id = RC_Hook::apply_filters('mobile_config_appid_filter', $app_id, $code, 'config_pay');

		$this->assign('ur_here', __('客户端配置', 'mobile'));
		$this->assign('action_link', array('text' => __('客户端管理', 'mobile'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/client_list',array('code' => $code))));
	
		$this->assign('code', $code);
		$this->assign('app_id', $app_id);
		
		$factory = new Ecjia\App\Mobile\ApplicationFactory();
		$pruduct_info = $factory->platform($code);
		$getPayments  = $pruduct_info->getPayments();

		$pay_list  = RC_Api::api('payment', 'batch_payment_info', array('code' => $getPayments));
		$this->assign('pay_list', $pay_list);
		
		$this->display('mobile_config_pay.dwt');
	}
	
	
	/**
	 * 禁用支付方式
	 */
	public function disable() {
		$this->admin_priv('mobile_manage_update');
		
		$code = trim($_GET['code']);
		$pay_code = trim($_GET['pay_code']);
		$app_id   = intval($_GET['app_id']);
		
		$data = array('enabled' => 0);
		
		RC_DB::table('payment')->where('pay_code', $pay_code)->update($data);
	
		return $this->showmessage(__('成功禁用插件', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_config/config_pay',array('code' => $code, 'app_id' => $app_id))));
	}
	
	/**
	 * 启用支付方式
	 */
	public function enable() {
		$this->admin_priv('mobile_manage_update');
		
		$code = trim($_GET['code']);
		$pay_code = trim($_GET['pay_code']);
		$app_id   = intval($_GET['app_id']);
		
		$data = array('enabled' => 1);
	
		RC_DB::table('payment')->where('pay_code', $pay_code)->update($data);

		return $this->showmessage(__('成功启用插件', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_config/config_pay',array('code' => $code, 'app_id' => $app_id))));
	}
	
}

//end