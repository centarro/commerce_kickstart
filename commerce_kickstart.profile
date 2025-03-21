<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Drupal\Core\Form\FormStateInterface;
use Drupal\RecipeKit\Installer\Hooks;

/**
 * Implements hook_install_tasks().
 */
function commerce_kickstart_install_tasks(): array {
  return Hooks::installTasks();
}

/**
 * Implements hook_install_tasks_alter().
 */
function commerce_kickstart_install_tasks_alter(array &$tasks, array $install_state): void {
  Hooks::installTasksAlter($tasks, $install_state);
}

/**
 * Implements hook_form_alter().
 */
function commerce_kickstart_form_alter(array &$form, FormStateInterface $form_state, string $form_id): void {
  Hooks::formAlter($form, $form_state, $form_id);
  switch ($form_id) {
    case 'installer_recipes_form':
      try {
        InstalledVersions::getInstallPath('drupal/commerce_kickstart_demo');
        $form['add_ons']['#description'] = t('Great for seeing all that Drupal Commerce has to offer. Not recommended for a site you intend to take live');
      }
      catch (\Exception $e) {
        $form['add_ons']['#access'] = FALSE;
        $form['actions']['submit']['#access'] = FALSE;
        $form['demo_info']['#markup'] = t('Add the Commerce Demo recipe to your codebase and reload this page if you want to install a complete demo store with sample content: <p><pre>composer require drupal/commerce_kickstart_demo</pre></p>');
      }
      $form['actions']['skip']['#value'] = t('Skip demo content');
      break;
    case 'installer_site_name_form':
      $form['site_name']['#attributes']['placeholder'] = t('Commerce Kickstart');
      $form['site_name']['#default_value'] = NULL;
      break;
    case 'install_configure_form':
      $form['update_notifications']['#access'] = FALSE;
      $form['update_notifications']['enable_update_status_emails']['#default_value'] = FALSE;
      break;
  }
}
