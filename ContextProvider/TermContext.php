<?php

#namespace Drupal\taxonomy\ContextProvider;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Plugin\Context\ContextProviderInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Sets the taxonomy term as a context.
 */
class TermContext implements ContextProviderInterface {

  use StringTranslationTrait;

  /**
   * The term storage.
   *
   * @var \Drupal\taxonomy\TermStorageInterface
   */
  protected $termStorage;

  /**
   * The route match object.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Constructs a new TermContext.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity type manager.
   */
  public function __construct(RouteMatchInterface $route_match, EntityTypeManagerInterface $entity_manager) {
    $this->routerMatch = $route_match;
    $this->termStorage = $entity_manager->getStorage('taxonomy_term');
  }

  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids) {
    if ($route_object = $this->routeMatch->getRouteObject()) && ($route_contexts = $route_object->getOption('parameters')) {
 
      // @TODO: Need to check how router obect constitute the URL structure for taxonomy,
      // then we can take the current term id and use it in storage.
      //$term = $this->termStorage->load();
    }

    $context = new Context(new ContextDefinition('entity:taxonomy_term', $this->t('Current Taxonomy Term')), $term);
    $cacheability = new CacheableMetadata();
    $cacheability->setCacheContexts(['taxonomy_term']);
    $context->addCacheableDependency($cacheability);

    $result = [
      'taxonomy_term' => $context,
    ];

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailableContexts() {
    return $this->getRuntimeContexts([]);
  }

}
