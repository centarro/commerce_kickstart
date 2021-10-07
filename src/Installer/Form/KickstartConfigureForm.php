<?php

namespace Drupal\commerce_kickstart\Installer\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
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
    $form['#title'] = $this->t('Commerce Kickstart Features');

    if($this->moduleExtensionList->exists('commerce_demo')) {
      $form['demo'] = [
        '#type' => 'fieldset',
        '#title' => t('Commerce Kickstart Demo'),
      ];

      $form['demo']['install_demo'] = [
        '#type' => 'checkbox',
        '#title' => t('Do you want to install the demo store?'),
        '#description' => t('Shows you everything Commerce Kickstart can do. Includes a custom theme, sample content and products.'),
        '#default_value' => FALSE,
      ];
    }

    $form['features'] = [
      '#type' => 'fieldset',
      '#title' => t('Commerce Kickstart Features'),
      '#description' => t('All features can also be installed at a later time'),
      '#states' => [
        'visible' => [
          ':input[name="install_demo"]' => ['checked' => FALSE],
        ],
      ],
    ];

    foreach ($this->getFeatures() as $key => $details) {
      $form['features'][$key] = [
        '#type' => 'checkbox',
        '#title' => $details['title'],
        '#description' => $details['description'],
        '#default_value' => FALSE,
      ];
    }

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save and continue'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('install_demo')) {
      \Drupal::state()->set('commerce_kickstart.install_demo', TRUE);
    }
    else {
      $install_modules = [];
      foreach ($this->getFeatures() as $key => $details) {
        if ($form_state->getValue($key)) {
          $install_modules[] = $key;
        }
      }
      \Drupal::state()->set('commerce_kickstart.install_modules', $install_modules);
    }
  }

  /**
   * @return array[]
   */
  private function getFeatures(): array {
    return [
      'commerce_kickstart_physical' => [
        'title' => t('Physical'),
        'description' => t('Do you have physical products that you ship?'),
      ],
      'commerce_kickstart_media' => [
        'title' => t('Media'),
        'description' => t('Do you have multi-format media products that you ship or are available for download?'),
      ],
      'commerce_kickstart_basic_catalog' => [
        'title' => t('Media'),
        'description' => t('Enable a basic catalog listing page for your products.'),
      ],
      'commerce_kickstart_content' => [
        'title' => t('Content'),
        'description' => t('Create static content pages'),
      ]
    ];
  }

}
