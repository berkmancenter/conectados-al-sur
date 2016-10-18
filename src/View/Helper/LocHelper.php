<?php
namespace App\View\Helper;

use Cake\View\Helper;

class LocHelper extends AppHelper
{
    public function fieldEnSuffix() { return __d('fields', '(English version)'); }
    public function fieldEsSuffix() { return __d('fields', '(Spanish version)'); }


    // FORMS
    // ////////////////////////////////////////////////////////////////////////
    public function formSubmit() { return __('Submit'); }
    public function formCancel() { return __('CANCEL'); }


    // ////////////////////////////////////////////////////////////////////////
    /////  MODELS /////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////

    // CATEGORY
    // ////////////////////////////////////////////////////////////////////////
    public function fieldCategory()       { return __d('fields', 'category');                                  }
    public function fieldCategoryNameEn() { return __d('fields', 'Category Name {0}', $this->fieldEnSuffix()); }
    public function fieldCategoryNameEs() { return __d('fields', 'Category Name {0}', $this->fieldEsSuffix()); }

    // ORGANIZATION TYPE
    // ////////////////////////////////////////////////////////////////////////
    public function fieldOrganizationType()       { return __d('fields', 'organization type');                                  }
    public function fieldOrganizationTypeNameEn() { return __d('fields', 'Organization Type Name {0}', $this->fieldEnSuffix()); }
    public function fieldOrganizationTypeNameEs() { return __d('fields', 'Organization Type Name {0}', $this->fieldEsSuffix()); }

    // INSTANCE
    // ////////////////////////////////////////////////////////////////////////
    public function fieldInstance()              { return __d('fields', 'application');                                 }
    public function fieldInstanceNameEn()        { return __d('fields', 'App Name {0}', $this->fieldEnSuffix());        }
    public function fieldInstanceNameEs()        { return __d('fields', 'App Name {0}', $this->fieldEsSuffix());        }
    public function fieldInstanceDescriptionEn() { return __d('fields', 'App Description {0}', $this->fieldEnSuffix()); }
    public function fieldInstanceDescriptionEs() { return __d('fields', 'App Description {0}', $this->fieldEsSuffix()); }
    public function fieldInstancePassphrase()    { return __d('fields', 'App Passphrase');                              }
    public function fieldInstanceNamespace()     { return __d('fields', 'App Shortname');                               }

    // PROJECT
    // ////////////////////////////////////////////////////////////////////////

    public function fieldProjectName()             { return __d('fields', 'Project Name'); }
    public function fieldProjectDescription()      { return __d('fields', 'Project Description'); }
    public function fieldProjectURL()              { return __d('fields', 'External URL'); }
    public function fieldProjectOrganizationType() { return __d('fields', 'Organization Type'); }
    public function fieldProjectCountry()          { return __d('fields', 'Main country'); }
    public function fieldProjectStage()            { return __d('fields', 'Project Stage'); }
    public function fieldProjectStartDate()        { return __d('fields', 'Start Date'); }
    public function fieldProjectFinishDate()       { return __d('fields', 'Finish Date'); }
    

    // ////////////////////////////////////////////////////////////////////////
    /////  VALIDATION//////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////

    public function validationUnique($fieldname) {
        $message = __d(
            'validation',
            'The "{0}" is already in use, please select another value.', 
            $fieldname
        );
        return ['rule' => 'validateUnique', 'provider' => 'table', 'message' => $message];
    }

    public function validationNotEmpty($fieldname) {
        return __d('validation', 'Please, complete the "{0}" field.', $fieldname);
    }

    public function validationMaxLength($fieldname, $maxLength) {
        $message = __d(
            'validation',
            'The "{0}" text is too long (max characters: {1}).', 
            [$fieldname, $maxLength]
        );
        return ['rule' => ['maxLength', $maxLength], 'message' => $message];
    }

    public function validationMinLength($fieldname, $minLength) {
        $message = __d(
            'validation',
            'The "{0}" text is too short (use at least {1} characters).', 
            [$fieldname, $minLength]
        );
        return ['rule' => ['minLength', $minLength], 'message' => $message];
    }


    // ////////////////////////////////////////////////////////////////////////
    /////  CRUD ///////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////
    public function crudAddSuccess($entity)    { return __d('crud', 'The {0} has been saved.', $entity);                          }
    public function crudEditSuccess($entity)   { return __d('crud', 'The {0} has been saved.', $entity);                          }
    public function crudDeleteSuccess($entity) { return __d('crud', 'The {0} has been deleted.', $entity);                        }
    public function crudAddError($entity)      { return __d('crud', 'The {0} could not be saved. Please, try again.', $entity);   }
    public function crudEditError($entity)     { return __d('crud', 'The {0} could not be saved. Please, try again.', $entity);   }
    public function crudDeleteError($entity)   { return __d('crud', 'The {0} could not be deleted. Please, try again.', $entity); }

}