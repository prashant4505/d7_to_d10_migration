<?php

namespace Drupal\d7_to_d11_migration\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Custom Drupal 7 article source with body field.
 *
 * @MigrateSource(
 *   id = "d7_article_with_body"
 * )
 */
class D7ArticleWithBody extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'n')
      ->fields('n', ['nid', 'vid', 'title', 'uid', 'status', 'created', 'changed'])
      ->condition('n.type', 'article');

    // Join the body field table.
    $query->leftJoin('field_data_body', 'b', 'b.entity_id = n.nid');
    $query->addField('b', 'body_value', 'body');
    $query->addField('b', 'body_format', 'body_format');

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return [
      'nid' => $this->t('Node ID'),
      'title' => $this->t('Title'),
      'uid' => $this->t('Author UID'),
      'status' => $this->t('Published status'),
      'created' => $this->t('Created timestamp'),
      'changed' => $this->t('Changed timestamp'),
      'body' => $this->t('Body content'),
      'body_format' => $this->t('Body text format'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return ['nid' => ['type' => 'integer']];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Set the body field properly formatted.
    if ($body = $row->getSourceProperty('body')) {
      $row->setSourceProperty('body', [
        'value' => $body,
        'format' => $row->getSourceProperty('body_format') ?: 'full_html',
      ]);
    }
    return parent::prepareRow($row);
  }
}
