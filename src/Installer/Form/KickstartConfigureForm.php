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
    $form['#title'] = $this->t('Commerce Kickstart features');

    $form['demo'] = [
      '#type' => 'fieldset',
      '#title' => t('Complete store demo'),
    ];

    if ($this->moduleExtensionList->exists('commerce_demo')) {
      $form['demo']['install_demo'] = [
        '#type' => 'checkbox',
        '#title' => t('Install all features with sample content.'),
        '#description' => t('Great for seeing all that Drupal Commerce has to offer. Not recommended for a site you intend to take live.'),
        '#default_value' => FALSE,
      ];
    }
    else {
      $form['demo']['#description'] = t('Add the Commerce Demo module to your codebase and reload this page if you want to install a complete demo store with sample content: <p><pre>composer require drupal/commerce_demo:^3.0</pre></p>');
    }

    $form['features'] = [
      '#type' => 'fieldset',
      '#title' => t('Select starting features'),
      '#description' => t('Features are small modules containing default configuration you can install now or at any point in the future.'),
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
        'title' => t('Physical products'),
        'description' => t('Sell physical products, collect shipping information, and charge shipping fees in checkout.'),
      ],
      'commerce_kickstart_basic_catalog' => [
        'title' => t('Basic catalog'),
        'description' => t('Merchandise your products in a taxonomy based catalog with enhanced exposed filters.'),
      ],
      'commerce_kickstart_media_product' => [
        'title' => t('Media products'),
        'description' => t('Sell digital products with access controlled downloads, optionally combined with physical variants.'),
      ],
      'commerce_kickstart_membership_subscription' => [
        'title' => t('Membership subscriptions'),
        'description' => t('Sell site or organization memberships with role based subscriptions and recurring billing.'),
      ],
      'commerce_kickstart_layout_builder' => [
        'title' => t('Layout Builder support'),
        'description' => t('Adding support for Layout Builder on products and creating Landing page content type with custom blocks.'),
      ],
      'commerce_kickstart_search_api_catalog' => [
        'title' => t('Commerce Kickstart Search API Catalog'),
        'description' => t('Search API based Product Catalog search with facets, DB server and Products Index.'),
      ],
    ];
  }

}
