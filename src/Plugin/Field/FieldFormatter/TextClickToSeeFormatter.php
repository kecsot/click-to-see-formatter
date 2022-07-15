<?php

namespace Drupal\click_to_see_formatter\Plugin\Field\FieldFormatter;

/**
 *
 * @FieldFormatter(
 *   id = "click_to_see_text_formatter",
 *   label = @Translation("Click to see (Text)"),
 *   field_types = {
 *     "string",
 *     "string_long",
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class TextClickToSeeFormatter extends BaseClickToSeeFormatter
{
  public function getSupportedPreFormatterKeys(): array
  {
    return ['string', 'text_default'];
  }
}
