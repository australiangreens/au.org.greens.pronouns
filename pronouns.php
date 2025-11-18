<?php

require_once 'pronouns.civix.php';
use CRM_Pronouns_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function pronouns_civicrm_config(&$config) {
  _pronouns_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function pronouns_civicrm_install() {
  _pronouns_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function pronouns_civicrm_enable() {
  _pronouns_civix_civicrm_enable();
}

function pronouns_civicrm_buildForm($formName, $form) {
  if ($formName != 'CRM_Contribute_Form_Contribution_Confirm' || $formName == 'CRM_Contribute_Form_Contribution_ThankYou') {
    $options = [];
    $pronounOptions = civicrm_api3('OptionValue', 'get', ['option_group_id' => 'pronouns', ['return' => ['label', 'value']]]);
    foreach ($pronounOptions['values'] as $option) {
      $options[$option['value']] = [
        'label' => $option['label'],
        'id' => $option['value'],
        'name' => $option['label'],
      ];
    }
    $options[] = ['label' => E::ts('Other'), 'id' => '', 'name' => 'other'];
    foreach ($options as $key => $option) {
      if ($option['name'] == 'other') {
        $options[$key]['id'] = $key;
      }
    }
    $customField = civicrm_api3('CustomField', 'get', ['name' => 'pronoun']);
    if ($form->elementExists('custom_' . $customField['id'])) {
      $currentClass = $form->getElement('custom_' . $customField['id'])->getAttribute('class');
      if (!empty($currentClass)) {
        $currentClass .= ' ';
      }
      $currentClass .= 'pronoun_custom_field_text_box';
      $form->getElement('custom_' . $customField['id'])->updateAttributes(['class' => $currentClass]);
      $form->add('select2', 'pronoun_options', E::ts('Pronouns'), $options, FALSE, ['placeholder' => E::ts('- select -')]);
      CRM_Core_Region::instance('form-bottom')->add(array(
        'template' => 'pronoun_options.tpl'
       ));
      CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/pronoun.js');
      CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/styleguide_contriubtion_form_fix.css');
    }
  }
}


// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *

 // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function pronouns_civicrm_navigationMenu(&$menu) {
  _pronouns_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _pronouns_civix_navigationMenu($menu);
} // */
