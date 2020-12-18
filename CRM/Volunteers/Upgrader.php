<?php

use CRM_Volunteers_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Volunteers_Upgrader extends CRM_Volunteers_Upgrader_Base
{

    /**
     * Example: Run an external SQL script when the module is installed.
     */
    public function install()
    {
        // add contact type
        self::createVolunteerContactType();

        // install volunteer stuff
        $customData = new CRM_Volunteers_CustomData(E::LONG_NAME);
        $customData->syncOptionGroup(E::path('resources/option_group_volunteer_qualifications.json'));
        $customData->syncOptionGroup(E::path('resources/option_group_volunteer_skills.json'));
        $customData->syncCustomGroup(E::path('resources/custom_group_volunteer.json'));
    }


    /**
     * Get the data of the event contact type,
     *  and creates it if it doesn't exist yet
     */
    protected static function createVolunteerContactType() {
        $volunteer_types = civicrm_api3('ContactType', 'get', [
            'name'         => 'Volunteer',
            'option.limit' => 0
        ]);
        if ($volunteer_types['count'] > 1) {
            Civi::log()->warning(E::ts("Multiple matching Volunteer contact types found!"));
        }
        if ($volunteer_types['count'] == 0) {
            // create it
            civicrm_api3('ContactType', 'create', [
                'name'        => 'Volunteer',
                'label'       => E::ts("Volunteer"),
                'description' => E::ts("Volunteers"),
                'image_URL'   => E::url('icons/volunteer_type.png'),
                'parent_id'   => 1, // 'Individual'
            ]);
        }
    }


    /**
     * Example: add option value
     *
     * @return TRUE on success
     * @throws Exception
     */
    public function upgrade_0001()
    {
        $this->ctx->log->info('additional qualification');
        $customData = new CRM_Volunteers_CustomData(E::LONG_NAME);
        $customData->syncOptionGroup(E::path('resources/option_group_volunteer_qualifications.json'));
        return true;
    }

    /**
     * Example: add contact type
     *
     * @return TRUE on success
     * @throws Exception
     */
    public function upgrade_0002()
    {
        $this->ctx->log->info('create contact type');
        self::createVolunteerContactType();
        return true;
    }

    /**
     * Example: add custom data
     *
     * @return TRUE on success
     * @throws Exception
     */
    public function upgrade_0003()
    {
        $this->ctx->log->info('create contact type');
        $customData = new CRM_Volunteers_CustomData(E::LONG_NAME);
        $customData->syncCustomGroup(E::path('resources/custom_group_volunteer.json'));
        return true;
    }

}
