<?php

namespace Drupal\click_to_see_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterPluginManager;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\RendererInterface;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseClickToSeeFormatter extends FormatterBase
{
  private RendererInterface $renderer;
  private FormatterPluginManager $formatterPluginManager;

  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, RendererInterface $renderer, FormatterPluginManager $formatterPluginManager)
  {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->renderer = $renderer;
    $this->formatterPluginManager = $formatterPluginManager;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $container,
      $configuration,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('renderer'),
      $container->get('plugin.manager.field.formatter')
    );
  }

  abstract function getSupportedPreFormatterKeys(): array;

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array
  {
    return [$this->t('Possible to use some formatter to preformat the value.')];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array
  {
    return [
        'pre_type' => '',
      ] + parent::defaultSettings();
  }

  public function settingsForm(array $form, FormStateInterface $form_state): array
  {
    $form = parent::settingsForm($form, $form_state);

    $field_definition = $this->fieldDefinition;
    $formatters = $this->formatterPluginManager->getOptions($field_definition->getType());

    foreach ($this->getSupportedPreFormatterKeys() as $key) {
      if (!isset($supported_formatters[$key])) {
        unset($formatters[$key]);
      }
    }

    /**
     * TODO:
     * The missing part is to load the pre_formatter's settingsForm. (For example: TextTrimmedFormatter)
     */
    $form['pre_formatter'] = [
      '#type' => 'select',
      '#title' => $this->t('Pre-formatter'),
      '#options' => $formatters,
      '#default_value' => $this->getSetting('pre_formatter'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   * @throws Exception
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array
  {
    $element = [];

    foreach ($items as $delta => $item) {
      $pre_formatter = $this->getSetting('pre_type');

      $content = $this->renderer->render($item->view(array('type' => $pre_formatter)));

      $element[$delta] = [
        '#theme' => 'click_to_see',
        '#content' => $content,
        '#attached' => [
          'library' => [
            'click_to_see_formatter/click-to-see'
          ]
        ]
      ];
    }
    return $element;
  }

}
