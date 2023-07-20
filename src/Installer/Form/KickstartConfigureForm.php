<?php

namespace Drupal\commerce_kickstart\Installer\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
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
    $form['#title'] = $this->t('Commerce Kickstart features');

    $form['demo'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Full store demo'),
    ];

    if ($this->moduleExtensionList->exists('commerce_demo')) {
      $form['demo']['install_demo'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Install all features with sample content.'),
        '#description' => $this->t('Great for seeing all that Drupal Commerce has to offer. Not recommended for a site you intend to take live.'),
        '#default_value' => FALSE,
      ];
    }
    else {
      $form['demo']['#description'] = $this->t('Add the Commerce Demo module to your codebase and reload this page if you want to install a complete demo store with sample content: <p><pre>composer require drupal/commerce_demo:^3.0</pre></p>');
    }

    $form['features'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Select starting features'),
      '#description' => $this->t('Features are small modules containing default configuration you can install now or at any point in the future.'),
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
      '#value' => $this->t('Continue installation'),
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
      'commerce_kickstart_physical_product' => [
        'title' => $this->t('Physical products'),
        'description' => $this->t('Sell physical products, collect shipping information, and charge shipping fees in checkout.'),
      ],
      'commerce_kickstart_search_api_catalog' => [
        'title' => $this->t('Search powered catalog'),
        'description' => $this->t('Merchandise your products in a facet based catalog with keyword search and sorting.'),
      ],
      'commerce_kickstart_media_product' => [
        'title' => $this->t('Media products'),
        'description' => $this->t('Sell digital products with access controlled downloads, optionally combined with physical variants.'),
      ],
      'commerce_kickstart_layout_builder' => [
        'title' => $this->t('Layout Builder support'),
        'description' => $this->t('Adding support for Layout Builder on products and creating Landing page content type with custom blocks.'),
      ],
      'commerce_kickstart_basic_catalog' => [
        'title' => $this->t('Basic catalog'),
        'description' => $this->t('Merchandise your products in a taxonomy based catalog with enhanced exposed filters.'),
      ],
    ];
  }

}
