<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;


$this->title = 'Login';


?>

<div class="form-body">
      <div class="website-logo">
          <a href="#">
              <div class="logo">
                  <!-- <img class="logo-size" src="<?= Url::to('@web') ?>/images/logo-light.svg" alt=""> -->
              </div>
          </a>
      </div>
      <div class="row">
          <div class="img-holder">
              <div class="bg"></div>
              <div class="info-holder">
                  <img src="<?= Url::to('@web') ?>/images/billing.gif" alt="" width="100%" height="100%">
              </div>
          </div>
          <div class="form-holder">
              <div class="form-content">
                  <div class="form-items">
                      <img src="<?= Url::to('@web') ?>/images/logo_sirindit.png" alt="" width="45%">
                      <h3>PELAPORAN</h3>
                      <p>Sistem Rumah Sakit Digital Terintegrasi </p>
                      <div class="page-links">
                          <a href=" " class="active">Login</a><!-- <a href="register7.html">Register</a> -->
                      </div>
                      <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false,'class'=>"login100-form validate-form"]); ?>
                        <div class="form-group has-feedback">
                          <?= $form
                              ->field($model, 'username')
                              ->label(false)
                              ->textInput(['placeholder' => $model->getAttributeLabel('User Id'),'class'=>"form-control"]) 
                          ?>
                          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                          <?= $form
                              ->field($model, 'password')
                              ->label(false)
                              ->passwordInput(['placeholder' => $model->getAttributeLabel('password'),'class'=>"form-control"]) 
                          ?>
                          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                          <div class="col-xs-8">
                            <div class="checkbox icheck">
                              <label>
                                
                              </label>
                            </div>
                          </div>
                          <!-- /.col -->
                          <div class="col-xs-4">
                          <?= Html::submitButton('<i class="fa fa-user"></i>Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                          </div>
                          <!-- /.col -->
                        </div>
                      <?php ActiveForm::end(); ?>
                      <!-- /.social-auth-links -->
                      <div class="other-links">
                            <em style="margin-top: 13px" class="text-caption text-center">SIM<b>RS</b> ‐ Copyright © 2021 SIRINDIT</em>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>