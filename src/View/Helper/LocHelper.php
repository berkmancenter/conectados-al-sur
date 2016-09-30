<?php
namespace App\View\Helper;

use Cake\View\Helper;

class LocHelper extends AppHelper
{
    public function fieldEnSuffix() {
        return __d('fields', '(English version)');
    }
    public function fieldEsSuffix() {
        return __d('fields', '(Spanish version)');
    }


    // FORMS
    // ////////////////////////////////////////////////////////////////////////
    public function formSubmit() { return __('Submit'); }
    public function formCancel() { return __('CANCEL'); }


    // ////////////////////////////////////////////////////////////////////////
    /////  MODELS /////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////

    // CATEGORY
    // ////////////////////////////////////////////////////////////////////////
    public function fieldCategory() {
        return __d('fields', 'category');
    }
    public function fieldCategoryNameEn() {
        return __d('fields', 'Category Name {0}', $this->fieldEnSuffix());
    }
    public function fieldCategoryNameEs() {
        return __d('fields', 'Category Name {0}', $this->fieldEsSuffix());
    }

    // ORGANIZATION TYPE
    // ////////////////////////////////////////////////////////////////////////
    public function fieldOrganizationType() {
        return __d('fields', 'organization type');
    }

    public function fieldOrganizationTypeNameEn() {
        return __d('fields', 'Organization Type Name {0}', $this->fieldEnSuffix());
    }

    public function fieldOrganizationTypeNameEs() {
        return __d('fields', 'Organization Type Name {0}', $this->fieldEsSuffix());
    }


    // ////////////////////////////////////////////////////////////////////////
    /////  VALIDATION//////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////

    public function validationNotEmpty($fieldname) {
        return __d('validation', 'Please, complete the "{0}" field.', $fieldname);
    }

    public function validationMaxLength($fieldname, $maxLength) {
        return __d('validation',
            'The "{0}" text is too long (max characters: {1}).', 
            [$fieldname, $maxLength]
        );
    }

    public function validationMinLength($fieldname, $minLength) {
        return __d('validation',
            'The "{0}" text is too short (use at least {1} characters).', 
            [$fieldname, $minLength]
        );
    }


    // ////////////////////////////////////////////////////////////////////////
    /////  CRUD ///////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////
    public function crudAddSuccess($entity) {
        return __d('crud', 'The {0} has been saved.', $entity);
    }
    public function crudEditSuccess($entity) {
        return __d('crud', 'The {0} has been saved.', $entity);
    }
    public function crudDeleteSuccess($entity) {
        return __d('crud', 'The {0} has been deleted.', $entity);
    }
    public function crudAddError($entity) { 
        return __d('crud', 'The {0} could not be saved. Please, try again.', $entity);
    }
    public function crudEditError($entity) { 
        return __d('crud', 'The {0} could not be saved. Please, try again.', $entity);
    }
    public function crudDeleteError($entity) {
        return __d('crud', 'The {0} could not be deleted. Please, try again.', $entity);
    }
}