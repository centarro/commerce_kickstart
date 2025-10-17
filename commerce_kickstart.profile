<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Drupal\Core\Form\FormStateInterface;
use Drupal\RecipeKit\Installer\Hooks;

/**
 * Implements hook_install_tasks().
 */
function commerce_kickstart_install_tasks(array &$install_state): array {
  return Hooks::installTasks($install_state);
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
}

/**
 * Implements hook_form_alter() for install_configure_form.
 */
function commerce_kickstart_form_install_configure_form_alter(array &$form): void {
  // We always install Automatic Updates, so we don't need to expose the update
  // notification settings.
  $form['update_notifications']['#access'] = FALSE;
}
