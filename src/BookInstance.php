<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'book_instance',
   'indexes' => 
   array(
   'book_run_id' => 
   array(
    'columns' => 
    array(
    0 => 'book_run_id',
    ),
   ),
   ),
  ));
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'columnName' => 'id',
   'type' => 'string',
   'nullable' => false,
   'length' => 20,
   'options' => 
   array(
   'fixed' => false,
   'comment' => '???????????? ?????????????',
   ),
   'id' => true,
  ));
$metadata->mapField(array(
   'fieldName' => 'modified',
   'columnName' => 'modified',
   'type' => 'datetime',
   'nullable' => true,
  ));
$metadata->mapField(array(
   'fieldName' => 'deleted',
   'columnName' => 'deleted',
   'type' => 'datetime',
   'nullable' => true,
   'options' => 
   array(
   'comment' => '????? ???????',
   ),
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapOneToOne(array(
   'fieldName' => 'bookRun',
   'targetEntity' => 'BookRun',
   'cascade' => 
   array(
   ),
   'fetch' => 2,
   'mappedBy' => NULL,
   'inversedBy' => NULL,
   'joinColumns' => 
   array(
   0 => 
   array(
    'name' => 'book_run_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));