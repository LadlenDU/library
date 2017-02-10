<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'author',
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
   'fieldName' => 'firstName',
   'columnName' => 'first_name',
   'type' => 'string',
   'nullable' => true,
   'length' => 255,
   'options' => 
   array(
   'fixed' => false,
   ),
  ));
$metadata->mapField(array(
   'fieldName' => 'lastName',
   'columnName' => 'last_name',
   'type' => 'string',
   'nullable' => true,
   'length' => 255,
   'options' => 
   array(
   'fixed' => false,
   ),
  ));
$metadata->mapField(array(
   'fieldName' => 'birthday',
   'columnName' => 'birthday',
   'type' => 'date',
   'nullable' => true,
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
   'comment' => '??????????? ? ??????? (????. ????)',
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
   'comment' => '????????? ??????????? ? ???????',
   ),
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapManyToMany(array(
   'fieldName' => 'book',
   'targetEntity' => 'Book',
   'cascade' => 
   array(
   ),
   'fetch' => 2,
   'joinTable' => 
   array(
   'name' => 'author_book',
   'joinColumns' => 
   array(
    0 => 
    array(
    'name' => 'author_id',
    'referencedColumnName' => 'id',
    ),
   ),
   'inverseJoinColumns' => 
   array(
    0 => 
    array(
    'name' => 'book_id',
    'referencedColumnName' => 'id',
    ),
   ),
   ),
  ));