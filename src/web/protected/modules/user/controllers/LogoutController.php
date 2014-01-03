<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
                Yii::import('webroot.protected.controllers.LogController');
                /* DATOS DEL LOG */
                LogController::RegistrarLog(7);
		Yii::app()->user->logout();
		//$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
                $this->redirect(Yii::app()->createAbsoluteUrl('/'));
	}

}