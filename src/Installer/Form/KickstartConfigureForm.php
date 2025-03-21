<?php

namespace Drupal\commerce_kickstart\Installer\Form;

use Composer\InstalledVersions;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Recipe\Recipe;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KickstartConfigureForm extends FormBase implements ContainerInjectionInterface {

  /**
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $moduleExtensionList;

  public function __construct(ModuleExtensionList $moduleInstaller) {
    $this->moduleExtensionList = $moduleInstaller;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('extension.list.module')
    );
  }

  /**
   * @inheritDoc
   */
  public function getFormId(): string {
    return 'commerce_kickstart_install_configure_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['#title'] = $this->t('Commerce Kickstart Demo');

    $form['demo'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Full store demo'),
    ];

    try {
      $recipe = InstalledVersions::getInstallPath('drupal/commerce_kickstart_demo');
      Recipe::createFromDirectory($recipe);
      $form['demo']['install_demo'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Install all features with sample content.'),
        '#description' => $this->t('Great for seeing all that Drupal Commerce has to offer. Not recommended for a site you intend to take live.'),
        '#default_value' => FALSE,
      ];
    }
    catch (\Exception $e) {
      $form['demo']['#description'] = $this->t('Add the Commerce Demo recipe to your codebase and reload this page if you want to install a complete demo store with sample content: <p><pre>composer require drupal/commerce_kickstart_demo</pre></p>');
    }

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Continue installation'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('install_demo')) {
      \Drupal::state()->set('commerce_kickstart.install_demo', TRUE);
    }
  }

}
