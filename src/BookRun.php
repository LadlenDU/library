<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'book_run',
   'indexes' => 
   array(
   'edition_id' => 
   array(
    'columns' => 
    array(
    0 => 'edition_id',
    ),
   ),
   'publisher_id' => 
   array(
    'columns' => 
    array(
    0 => 'publisher_id',
    ),
   ),
   ),
  ));
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'columnName' => 'id',
   'type' => 'integer',
   'nullable' => false,
   'options' => 
   array(
   'unsigned' => true,
   ),
   'id' => true,
  ));
$metadata->mapField(array(
   'fieldName' => 'image',
   'columnName' => 'image',
   'type' => 'blob',
   'nullable' => true,
   'length' => 16777215,
   'options' => 
   array(
   'fixed' => false,
   'comment' => '??????????? ???????',
   ),
  ));
$metadata->mapField(array(
   'fieldName' => 'imageThumb',
   'columnName' => 'image_thumb',
   'type' => 'blob',
   'nullable' => true,
   'length' => 16777215,
   'options' => 
   array(
   'fixed' => false,
   'comment' => '????????? ??????????? ???????',
   ),
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapOneToOne(array(
   'fieldName' => 'edition',
   'targetEntity' => 'Edition',
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
    'name' => 'edition_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));
$metadata->mapOneToOne(array(
   'fieldName' => 'publisher',
   'targetEntity' => 'Publisher',
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
    'name' => 'publisher_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));